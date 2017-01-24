$(document).ready(function () {
    var text = $("form#contact-form input[type='text']");
    var email = $("form#contact-form input[type='text']#email");
    var checkboxesAndRadios = $("form#contact-form input[type='checkbox'], form#contact-form input[type='radio']");
    var checkboxes = $("form#contact-form input[type='checkbox']");
    var multiselects_unique = $("form#contact-form div[data-unique='unique'] select");
    //var fieldGroups = $("form#contact-form .field-group .input-body");

    var other = $("form#contact-form input[type='text'][name^='other']");
    var submit = $("form#contact-form input[type='submit']");

    other.each(function (e) {
        if ($(this).parent().find("input[type='checkbox'], input[type='radio']").prop('checked') != true)
            $(this).hide();
    });

    checkboxesAndRadios.change(function (e) {
        other.each(function (e) {
            if ($(this).parent().find("input[type='checkbox'], input[type='radio']").prop('checked') != true)
                $(this).hide();
            else
                $(this).show();
        });
        /*
         var ele = $(this).parent().find("input[type='text'][name^='other']");
         console.log((ele.parent().find("input[type='checkbox'], input[type='radio']").prop("checked")))
         if (ele.parent().find("input[type='checkbox'], input[type='radio']").prop('checked') != true)
         ele.hide();
         else
         ele.show();
         */
    });

    other.on("input", function () {
        $(this).removeClass("wrong_input");
    });

    checkboxes.change(function (e) {
        var max = $(this).attr('max_ticks');
        if ($(this).parent().parent().find("input[type='checkbox']:checked").length > max) {
            e.preventDefault();
            $(this).prop("checked", false);
        }
    });

    checkboxesAndRadios.change(function () {
        $(this).parent().parent().removeClass("wrong_input");
    });

    submit.click(function (e) {
        var max_validate = 2;
        var responses = [];
        responses[0] = []; //container for wrong inputs in $
        responses[1] = validateOther();
        responses[2] = validateRadiosAndCheckboxes();
        if (email.length > 0) {
            responses[3] = validateEmail();
            max_validate = 3;
        }
        var wrong = false;
        for (var i = 1; i <= max_validate; i++) {
            if (responses[i][0] == true) {
                wrong = true;
                $.merge(responses[0], responses[i][1]);
            }
        }
        if (wrong == true) {
            e.preventDefault();
            $(responses[0]).each(function () {
                $(this).addClass('wrong_input');
            });
            $('html, body').stop().animate({
                scrollTop: responses[0][0].offset().top - 30
            }, 1500, 'easeInOutExpo');
        }
        multiselects_unique.find('option').removeAttr('disabled');

        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new
                    Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-69096423-1', 'auto');
        ga('send', 'pageview');
    });

    function validateOther() {
        var wrongInputs = [];
        var wrong = false;
        other.each(function (e) {
            var box = $(this).parent().find("input[type='checkbox'], input[type='radio']");
            if (box.prop('checked') == true) {
                if ($(this).val().length == 0 && $(this).attr('name') != 'other_pyt7') {
                    wrongInputs.push($(this));
                    wrong = true;
                }
            }
        });
        return [wrong, wrongInputs];
    }

    function validateRadiosAndCheckboxes() {
        var wrongInputs = [];
        var wrong = false;
        var fieldGroups = $("form#contact-form .field-group");
        var fieldGroupInputs = $("form#contact-form .field-group input[type='checkbox'], form#contact-form .field-group input[type='radio']")

        fieldGroups.each(function () {
            var correctField = false;
            var fields = $(this).find("input[type='checkbox'], input[type='radio']");
            if (fields.length > 0) {
                fields.each(function () {
                    var min = $(this).attr('min_ticks');
                    if (min != null) {
                        if ($(this).parent().parent().find("input[type='checkbox']:checked").length >= min) {
                            correctField = true;
                        }
                    }
                    else {
                        if ($(this).prop("checked") == true)
                            correctField = true;
                    }
                });
                if (correctField == false) {
                    wrongInputs.push($(this).find(".input-body:first"));
                    wrong = true;
                }
            }
        });


        return [wrong, wrongInputs];
    }

    $("#dropdownId").on('change', function () {
        var ddl = $(this);
        var previous = ddl.data('previous');
        ddl.data('previous', ddl.val());
    });


    multiselects_unique.attr("data-prev", multiselects_unique.val());

    multiselects_unique.change(function (data) {
        var jqThis = $(this);
        var this_prev = jqThis.attr("data-prev");
        var option = $(this).parent().parent().find('select option[value=\'' + this_prev + '\']');
        if (option.length > 0) {
            option.each(function () {
                $(this).removeAttr('disabled');
            });
        }

        if (this.value != '') {
            var option_2 = $(this).parent().parent().find('select option[value=\'' + this.value + '\']');
            if (option_2.length > 0) {
                option_2.each(function () {
                    $(this).attr('disabled', "disabled");
                });
            }
        }

        jqThis.attr("data-prev", this.value);
    });

    function validateEmail() {
        var wrong = false;
        var wrong_inputs = [];
        wrong = !emailIsValid(email.val());
        if (wrong == true) {
            wrong_inputs.push($(email));
        }

        return [wrong, wrong_inputs];
    }

    /*
     text.on("input", function() {
     if(!textIsValid($(this).val()))
     {
     //$(this).removeClass("correct_input");
     $(this).addClass("wrong_input");
     }
     else
     {
     //$(this).addClass("correct_input");
     $(this).removeClass("wrong_input");
     }
     if($(this).val().length==0) {
     $(this).removeClass("wrong_input");
     //$(this).removeClass("correct_input");
     }
     });
     */

    email.on("input", function () {
        if (!emailIsValid($(this).val())) {
            //$(this).removeClass("correct_input");
            $(this).addClass("wrong_input");
        }
        else {
            //$(this).addClass("correct_input");
            $(this).removeClass("wrong_input");
        }
        if ($(this).val().length == 0) {
            $(this).removeClass("wrong_input");
            //$(this).removeClass("correct_input");
        }
    });
});

function textIsValid(input) {
    var regex = /^[a-zA-Z0-9\s\,\.]*$/;
    return regex.test(input);
}

function emailIsValid(input) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(input);
}