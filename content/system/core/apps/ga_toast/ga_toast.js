/**
 * Created by Rolando on 21/12/2016.
 */

'use strict';


var ga_toast = function () {

    this.success_data = "success";

    this.warning_data = "warning";

    this.config = function (options = null) {
        if (options === null) options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        toastr.options = options;
    };


    this.set_toast = function (message, title = '', type = "success") {
        toastr[type](message, title);
    };

};

