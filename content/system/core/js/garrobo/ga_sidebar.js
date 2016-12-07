/***
 * @author Rolando Arriaza <rolignu90>
 * @version 2.1.0
 * @todo ga_sidebar
 * @licence MIT
 * @React ga_sidebar system interface
 *
 *  <NabVar> es una funcion en la cual hace que el sidebar sea dinamico UTILIZANDO REACT JS
 *            ok partamos de REACT JS , si no sabes que es mejor ni mires el codigo hasta que sepas,
 *            otra tecnologia que necesitas saber es JSX que se utiliza para el renderizado de los elementos
 *            de ahi necesitas saber ES6 y JQUERY (como framework) si no sabes aprende.
 *
 *            Gracias a su DOM VIRTUAL re react js logramos obtener un rednerizado a base de cambios
 *            esto significa que no necesitamos renderizar todo el sidebar para para ver los cambios de los
 *            componentes si no que VD detecta en donde se ha hecho el cambio
 *
 *            bug fixed front-end navbar section by section to sidebar
 *
 * **/

'use strict';


var url                 = $("#ga_url").val();
var controller          = $("#ga_controller").val();
var interval            = $("#ga_reflesh").val();
var storage             = $("#ga_storage").val();
var hibrid              = $("#ga_hibrid").val();
var controller_menu     = $("#ga_controller_menu").val();
var dashboard_          = $("#ga_dashboard").val();


var NavBar = React.createClass({

    getInitialState: function () {
        return {objects: []};
    },

    Server: function () {

        var that = this;
        $.ajax({

            url: that.props.url + that.props.controller,
            beforeSend: function () {
            },
            statusCode: {
                404: function () {
                    console.log("Error 404 al momento de llamar al sidebar");
                },
                500: function () {
                    console.log("Error 500 al momento de llamar al sidebar");
                }
            }

        }).done((a) => {
            try {

                let k = JSON.parse(a);
                let m = [];
                $.each(k, function (x, y) {
                    m.push(y);
                });
                that.setState({
                    objects: m
                });
            }catch(ex) {
                console.log("garrobo_sidebar_error : " + ex);
               // console.log(a);
            }
        }).fail(function (e, status) {
            console.log(status);
        });

    },

    componentDidMount: function () {
        this.Server();
        setInterval(this.Server, this.props.interval);
    },
    
    sidebar_: (l, $this) => {
        /**
         * bug fixed date 22-07-16
            |
                fix what is not when the url
                initial dashboard and disables the sidebar xhr in the initial system ,
                which makes the load dom updated again
         * **/
        try {
            let r = l.route !== null && l.route !== "" ? l.route : l.location;
            let current = window.location.href;
            let dashboard_url = url + dashboard_;
            let done = false;
            if (current == dashboard_url || current == (dashboard_url + "/")) done = true;

            if (l.route == null) l.route = '';

            let icon_ = null;
            if (typeof l.objects.icon == "undefined")
                icon_ = "";
            else
                icon_ = l.objects.icon;


            if (hibrid == "1" && done == true)
                return (<li className="nav-item">
                    <a id={"sga_" + l.name}
                       href={ "javascript:ga_('" + url + l.dashboard + r + "','" + l.name + "');"  }
                       className="nav-link ">
                        <i className={icon_}></i>
                        <span className="title">{l.name}</span>
                    </a>
                </li>);
            else
                return (<li className="nav-item">
                    <a href={ url + l.dashboard + l.route } rel="loadpage" className="nav-link ">
                        <i className={icon_}></i>
                        <span className="title">{l.name}</span>
                    </a>
                </li>);
        }catch (ex)
        {
            return null;
        }

    },

    namespace_: (a) => {
        return (<li className="heading">
            <h3 className="uppercase">{a.name}</h3>
        </li>);
    },

    section_: (s, $this) => {


        let sec = '';
        let icon_ = null;

        if(typeof s.objects.icon == "undefined")
            icon_ = "";
        else
            icon_ = s.objects.icon;



        if (typeof s.section === 'object') {

            let cc = Object.keys(s.section);

            if(cc.length >= 1)
            {
                sec = $.map(s.section , function(k){

                    let p = $.map(k.sidebar, (m)=> {
                        return $this.sidebar_(m);
                    });

                    return (<li className="nav-item  ">
                        <a href="javascript:;" className="nav-link nav-toggle">
                            <i className={k.objects.icon}></i>
                            <span className="title">{k.name}</span>
                            <span className="arrow open"></span>
                        </a>
                        <ul className="sub-menu">
                            {p}
                        </ul>
                    </li>);
                });
            }

        }

        let side = $.map(s.sidebar, (m)=> {
            return $this.sidebar_(m);
        });



        return (

            <li className="nav-item  ">
                <a href="javascript:;" className="nav-link nav-toggle">
                    <i className={icon_}></i>
                    <span className="title">{s.name}</span>
                    <span className="arrow open"></span>
                </a>
                <ul className="sub-menu">
                    {side}
                    { (sec != '') ? sec : null }
                </ul>
            </li>
        );

    },

    render: function () {


        let d = this.state.objects;
        var $this = this;

        let ChildCode = $.map(d, (a) => {


            let data = [];

            data.push($this.namespace_(a));

            if (typeof a.sidebar === 'object') {
                $.map(a.sidebar, (m) => {
                    data.push($this.sidebar_(m));
                });
            }

            if (typeof  a.section === 'object') {
                $.map(a.section, (s) => {
                    data.push($this.section_(s, $this));
                });
            }

            return data;

        });



        return (
            <ul className="page-sidebar-menu  page-header-fixed "
                data-keep-expanded="false"
                data-auto-scroll="true"
                data-slide-speed="200"
                style={{"padding-top" : "20px"}}>
                <li className="sidebar-toggler-wrapper hide">
                    <div className="sidebar-toggler"></div>
                </li>
                {ChildCode}
            </ul>

        );

    }
});

var MenuBar = React.createClass({

    getInitialState: function () {
        return {objects: []};
    },

    Server: function () {

        var that = this;
        $.ajax({

            url: that.props.url + that.props.controller,
            beforeSend: function () {
            },
            statusCode: {
                404: function () {
                    console.log("Error 404 al momento de llamar al sidebar");
                },
                500: function () {
                    console.log("Error 500 al momento de llamar al sidebar");
                }
            }

        }).done((a) => {
            try {
                let k = JSON.parse(a);
                let m = [];
                $.each(k, function (x, y) {
                    m.push(y);
                });
                that.setState({
                    objects: m
                });
            }catch(ex){
                console.log("Error sidebar : --->");
                console.log(ex);
            }
        }).fail(function (e, status) {
            console.log(status);
        });

    },

    componentDidMount: function () {
        this.Server();
        setInterval(this.Server, this.props.interval);
    },

    render: function () {

        let d = this.state.objects;


        var menu = $.map( d , (a)=> {

            let style = {};
            if(a.divider === true)
            {
                style = { "display" : "none" }
            }
            else
            {
                style = { "display" : "inline" }
            }

            if(hibrid == 1)
            {
                //   <li className="divider"></li>
                return (
                    <li id={ 'sub_menu_' + a.id}>
                        <a href={"javascript:ga_('" + url + a.dashboard  + "/" + a.location + "');"}>
                            <i className={a.icon}></i> {a.name}
                        </a>
                    </li>
                );
            }
            else {
                return (
                    <li id={ 'sub_menu_' + a.id}>
                        <a href={ url + a.dashboard  + "/" + a.location }>
                            <i className={a.icon}></i> {a.name}</a>
                    </li>
                );
            }
        });

        return (<span>{menu}</span>);

    }
});


ReactDOM.render(
    <NavBar url={url} controller={controller} interval={interval}/>,
    document.getElementById('ga_nav')
);

ReactDOM.render(
    <MenuBar url={url} controller={controller_menu} interval={interval}/>,
    document.getElementById('ga_sub_menu')
);



