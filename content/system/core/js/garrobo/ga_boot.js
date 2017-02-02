"use strict";

$.fn.extend({
    
    animateCss: function (animationName) {
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        $(this).addClass('animated ' + animationName).one(animationEnd, function () {
            $(this).removeClass('animated ' + animationName);
        });
    },
    login: function (lang , query="") {
        $(this).unbind().submit(function (event) {
            var url = $("#url").val();
            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                beforeSend: function () {
                     $("button[type=submit]").html("<img title='loading' style='width:20%' src='" + url + "content/assets/svg/ripple.svg'><span>" + lang.wait + "</span>");
                },
                success: function (data) {
                    var j = JSON.parse(data);
                    switch(j.error)
                    {
                        case 0:
                            if(query == "")
                                window.location.href = j.msj + "?token=" + j.token  + "&u=" + j.user;
                            else {
                                if(query.indexOf("?") > -1 )
                                    window.location.href =  j.msj + query +  "&token=" + j.token  + "&u=" + j.user;
                                else
                                    window.location.href =  j.msj + query +  "?token=" + j.token  + "&u=" + j.user;
                            }
                            break;
                        case 1:
                            $("#class_error")
                                    .removeClass("display-hide")
                                    .find("span")
                                    .html(j.msj);
                            
                            $("button[type=submit]").html("<span>" + lang.login +"</span>");
                            $(".content").animateCss("tada");
                            break;
                    }
                                  
                },
                fail: function () {
                    $(".content").animateCss("tada");
                    $("button[type=submit]").html("<span>System error</span>");
                }
            });

            event.preventDefault();
        });
    },
    ga_forms : function (data= {a: null , b: null }) {

        $(this).unbind().submit(function (e) {

            if(data.a == null || typeof data.a !== 'function') return false;
            if(data.b == null) data.b = function () {};

            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: data.a  ,
                beforeSend : data.b
            }).fail(( jqXHR, textStatus, errorThrown )=>{
                console.log(jqXHR);
                console.log("Status: " + textStatus );
            });

            e.preventDefault();
        });


    },
    forms : function (success = function(){} , beforesend = function(){}) {
        $(this).unbind().submit(function (e) {
            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: success ,
                beforeSend : beforesen
            }).fail(( jqXHR, textStatus, errorThrown )=>{
                console.log("Opps !!!");
            });

            e.preventDefault();
        });


    },
    ga_submit : function(fn = null  , $this = null  )
    {


        if($this == null) $this = this;

        if(fn != null && typeof  fn === 'function')
        {
            $($this).unbind().submit(fn(event, params));
            return true ;
        }

        $($this).unbind().submit(function(event , fn ){
            console.log("hola mundo");
            console.log(fn );
            event.preventDefault();
        });

    }

});


