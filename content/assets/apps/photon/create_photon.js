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
            token : Math.random().toString(36).substring(1)
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
    },

    change_text : function (e) {
        this.setState({ token : e.target.value })
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
                                        <select className="form-control"
                                                name="photon-project"
                                                id="photon-project">
                                            <option value="-1">Seleccione un proyecto.</option>
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
                                    <label className="col-md-3 control-label">Nombre del photon (*)</label>
                                    <div className="col-md-6">
                                        <div className="input-group">
                                            <input name="photon-name"
                                                   id="photon-name"
                                                   className="form-control"
                                                   placeholder="el nombre con que se identifica el photon"
                                                   type="text" />
                                        </div>
                                    </div>
                                </div>
                                <div className="form-group">
                                    <label className="col-md-3 control-label">Variable Global (*)</label>
                                    <div className="col-md-6">
                                        <div className="input-group">
                                            <input className="form-control"
                                                   id="photon-global"
                                                   name="photon-global"
                                                   placeholder="Nombre de la variable global"
                                                   type="text" />
                                        </div>
                                    </div>
                                </div>
                                <div className="form-group">
                                    <label className="col-md-3 control-label">ID photon (*)</label>
                                    <div className="col-md-4">
                                        <div className="input-icon">
                                            <i className="fa fa-bell-o"></i>
                                            <input
                                                className="form-control"
                                                name="photon-id"
                                                id="photon-id"
                                                placeholder="id photon en particle"
                                                type="text" />
                                        </div>
                                    </div>
                                </div>
                                <div className="form-group">
                                    <label className="col-md-3 control-label">Token Photon </label>
                                    <div className="col-md-4">
                                        <div className="input-icon right">
                                            <i className="fa fa-microphone"></i>
                                            <input className="form-control"
                                                   value={this.state.token}
                                                   placeholder=""
                                                   name="photon-token"
                                                   id="photon-token"
                                                   onChange={this.change_text}
                                                   type="text" />
                                        </div>
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





