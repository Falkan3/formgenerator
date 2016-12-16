var tooltips;
var alertItems=["4 osoby oglądają właśnie oferty nieruchomości", "2min temu zostało dokonane zamówienie na usługi rachunkowe"];

$(document).ready(function () {
    tooltips = $('[data-toggle="tooltip"]');

    if ($(window).width() > 768) {
        tooltips.attr('data-placement', 'bottom');
    }
    else {
        tooltips.attr('data-placement', 'bottom');
    }

    //Tooltips
    tooltips.tooltip();
    //********************

    //Click anchors
    $("a").click(function (e) {
        if ($(this).attr('href') == '#') {
            e.preventDefault();
        }
    });
    //********************

    $(window).resize(function () {
        if (this.resizeTO) clearTimeout(this.resizeTO);
        this.resizeTO = setTimeout(function () {
            $(this).trigger('resizeEnd');
        }, 10);
    });

    $(window).bind('resizeEnd', function () {
        if ($(window).width() > 768) {

        }
        else {
            tooltips.attr('data-placement', 'bottom');
        }

    });

    $.notify(
        "Start",
        { position:"b l", className:"info" }
    );

    window.setInterval(function(){
        var item = alertItems[Math.floor(Math.random()*alertItems.length)];
        $.notify(
            item,
            { position:"b l", className:"black", showDuration: 800, autoHideDelay: 7500, }
        );
    }, 20000);

});