jQuery(document).ready(function () {

    jQuery("#btnExport").click(function(){
        jQuery("#table2excel").table2excel({
            // exclude CSS class
            exclude: ".noExl",
            name: "Worksheet Name",
            filename: "Lista uczestników" //do not include extension
        });
    });


});
