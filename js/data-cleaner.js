
var DIR = "data/raw/";


$(document).ready(function(){

    console.log("ready");

    /*
    $('.folder').each(function() {

        var folderName = $(this).attr("id");

        $(this).find('.raw-url').each(function(){

            loadFile(folderName+"/"+$(this).html());
        });
    });
    */

/*
    loadFile( "business/breconbeacons-org-businesses-2658.html");
    */
});









function processHtmlData(data){

    var self = $(data);
    
    console.log(self.find('.business-detail-wrap')[0]);

}


function loadFile(ext, fileName){

    var file = DIR + ext +fileName;
    console.log(file);

    $.ajax({

        url: file,
        dataType: "html",
        success: function(data) {
            console.log("Data loaded");
            processHtmlData(data);
        },
        error: function(xhr, desc, err) {
            //console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        }
    });
}