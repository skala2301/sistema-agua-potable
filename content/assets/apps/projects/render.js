'use strict';

export default function() {}


end_project_render = React.createClass({


    render : function () {
        return (
            <div id="body-render">
                <p
                    style={{
                        'border': '1px solid',
                        'border-style': 'dashed',
                        'color': 'red',
                        'text-align': 'center',
                        'font-size': '1.0em'
                    }}
                >EL PROYECTO <b>{this.props.name}</b> SE CREO CON EXITO</p>
            </div>
        );
    }

});


/**
 *
 *
 * element.style {
    border-color: red;
    border-style: dashed;
    color: blue;
    background-color: antiquewhite;
}
 *
 * **/