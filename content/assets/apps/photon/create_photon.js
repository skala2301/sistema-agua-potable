/**
 * Created by rolandoarriaza on 3/2/17.
 */

//important SYSTEMJS
//export var p = 5;
'use strict';

export default function() {}


PhotonInsert = new React.createClass({

    getInitialState: function () {
        return {
            package : this.props.package,
            projects : [],
            devices : {
                error : true ,
                msj   : "Agrega el token del dispositivo",
                data  : []
            }
        };
    },

    componentWillMount : function()
    {
        var $that = this;
        project_data.get_projects(function (data) {
            try{
                data = JSON.parse(data);
                $that.setState({projects : data});
            }catch (e){}
        });
    },

    componentWillReceiveProps(nextProps) {

    },

    componentWillUpdate: function(nextProps, nextState){


    },

    shouldComponentUpdate: function(nextProps, nextState)
    {


        return true;
    },

    componentDidMount: function()
    {
        $("#form-request").submit(function (e) {
            photon_.create(this);
            e.preventDefault();
        });


        var that = this;
        setInterval(function () {

            var project_            = $("#photon-project").val();
            var table               = $("#data-device").find("tbody").find("tr");

            try{
                $.map(that.state.devices.data , function (a,b ) {

                    photon_.get_devices(a.id , project_ , function (m) {
                        m = JSON.parse(m);
                        $(m).map(function (x,i) {
                            let pid         = i.particle_id;
                            $(table).each(function () {
                                if($(this).attr("id") === pid){
                                    $(this).css({
                                        "opacity" : "0.4",
                                        "border": "2px solid red",
                                        "border-style": "dashed",
                                        "text-decoration" : "line-through"
                                    }).attr("name" , "disabled");
                                }
                            });
                        })

                    });
                });

            }catch (e){
                console.log(e);
            }

        } , 1000);

    },

    change_text : function (e) {

        let device_url      = $("#particle_url").val();
        var token           = e.target.value;
        var $that           = this;

        device_url = device_url.replace("{id_token}" , token );
        ga_cross_request(device_url , {} ,
            function (k) {

            if(token === '')
            {
                $that.setState({devices : {
                    "error" : true,
                    "msj"   : 'Token is a null :('
                }});

                return true ;
            }

            $that.setState({devices : {data : [] }});

            var data = $.map(k , function (a,b) {

                return [{
                        "exist" : true ,
                        "id"              : a.id ,
                        "name"            : a.name  ,
                        "connected"       : a.connected
                }]

            });

            $that.setState({
                    devices : {
                        "error" : false ,
                        "msj"   : "",
                        "data"  : data
                    }
            });


        } , function (xhr , status) {

            let error = JSON.parse(xhr.responseText);
            $that.setState({devices : {
                "error" : true,
                "msj"   : error.error_description
            }});
        } , "GET");

        //this.setState({ devices : "hols" });
    },

    change_selector : function (e) {
        if(e.target.value != -1) {
            $("#photon-token").removeAttr("disabled");
        }
        else {
            $("#photon-token").attr("disabled" , "disabled");
        }
    },

    render_table : function () {

          //console.log(this.state.devices.data);

          if(this.state.devices == null)
              return (<div></div>);

          if(this.state.devices.error == true ){
              return (<div style={{
                  'text-align': 'center',
                  'border': '1px solid red',
                  'border-style': 'dashed'
              }}>{this.state.devices.msj}</div>);
          }


          var data_Set = $.map(this.state.devices.data , function (a,b) {
              return (
                  <tr  id={a.id}>
                      <td name="check_data"><input type="checkbox" className="form-control"  /></td>
                      <td name="check_id">{a.id }</td>
                      <td name="check_name">{a.name}</td>
                      <td name="check_connect">{a.connected == true ? "Conectado" : "No conectado" }</td>
                  </tr>
              );
          });

          return (
              <table className="table table-striped table-bordered table-hover order-column" id="data-device">
                <thead>
                <tr>
                    <th>[A]</th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Estado </th>
                </tr>
                </thead>
                  <tbody>
                      {data_Set}
                  </tbody>
              </table>
          );

    },

    render : function () {
        return (
            <div>
                <div className="portlet light bordered">
                    <div className="portlet-title">
                        <div className="caption">
                            <i className="icon-equalizer font-red-sunglo"></i>
                            <span className="caption-subject font-red-sunglo bold uppercase">Crea un nuevo Photon </span>
                            <span className="caption-helper"> [Photon maker]</span>
                        </div>
                        <div className="actions">
                            <div className="portlet-input input-inline input-small">
                                <div className="input-icon right">
                                    <input className="form-control " disabled="disabled" value={ this.state.package} type="text" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="portlet-body form">

                        <form id="form-request" method="post" className="form-horizontal">
                            <div className="form-body">

                                <div className="form-group">
                                    <label className="col-md-3 control-label">Paquete</label>
                                    <div className="col-md-6">
                                        <div className="input-group">
                                            <input className="form-control"
                                                   disabled="disabled"
                                                   id="photon-package"
                                                   name="photon-package"
                                                   placeholder="Nombre de la variable global"
                                                   value={this.state.package}
                                                   type="text" />
                                        </div>
                                    </div>
                                </div>
                                <div className="form-group">
                                    <label className="col-md-3 control-label">Proyecto (*)</label>
                                    <div className="col-md-4">
                                        <select onChange={this.change_selector}
                                                className="form-control"
                                                name="photon-project"
                                                id="photon-project">
                                            <option  value="-1">Seleccione un proyecto.</option>
                                            {
                                                $(this.state.projects).map(function (k,v) {
                                                    return (
                                                        <option value={v.id}>{v.name}</option>
                                                    )
                                                })
                                            }
                                        </select>
                                    </div>
                                </div>
                                <div className="form-group">
                                    <label className="col-md-3 control-label">Token Dispositivo </label>
                                    <div className="col-md-4">
                                        <div className="input-icon right">
                                            <i className="fa fa-microphone"></i>
                                            <input className="form-control"
                                                   placeholder=""
                                                   disabled = "disabled"
                                                   name="photon-token"
                                                   id="photon-token"
                                                   onChange={this.change_text}
                                                   type="text" />
                                        </div>
                                    </div>
                                </div>


                                <div className="form-actions">
                                    <div className="row">
                                        {this.render_table()}
                                    </div>
                                </div>

                                <div className="form-actions">
                                    <div className="row">
                                        <div className="col-md-offset-3 col-md-9">
                                            <button data-style="expand-right"
                                                    type="submit"
                                                    className="btn primary mt-ladda-btn ladda-button">
                                                <span class="ladda-label">Crear Photon</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </form>

                    </div>

                </div>
            </div>
        );
    }

});


//ReactDOM.render(<PhotonInsert /> , document.getElementById("render_view"));





