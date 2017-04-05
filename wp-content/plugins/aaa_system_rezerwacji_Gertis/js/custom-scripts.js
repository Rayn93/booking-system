jQuery(document).ready(function () {

    var event_turn = getUrlParameter('event_turn');


    jQuery("#btnExport").click(function(){
        jQuery("#table2excel").table2excel({
            // exclude CSS class
            exclude: ".noExl",
            name: "event_turn",
            filename: "Lista uczestników: " + event_turn //do not include extension
        });
    });


});


function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};


