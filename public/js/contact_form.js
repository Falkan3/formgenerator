$(document).ready(function() {
    var text= $("form#contact-form input[type='text']");

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
});

function textIsValid(input) {
    var regex =  /^[a-zA-Z0-9\s\,\.]*$/;
    return regex.test(input);
}