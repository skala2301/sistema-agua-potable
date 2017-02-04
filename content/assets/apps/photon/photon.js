/**
 * Created by rolandoarriaza on 4/2/17.
 */


var photon_ = {

    init : () => {

        $("#create_new_").click(function () {

            alert();

            let name = $("#txt-new-element").val();
            $("#device_name").val(name);

            ReactDOM.render( React.createElement(PhotonInsert,{})
                , document.getElementById("render_view")
            );

        });

    }


};
