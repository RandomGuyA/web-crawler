$(document).ready(function(){

    console.log("ready");

    //displaySitemap();

    setupFolderStructure();


});



function setupFolderStructure(){

    var $sitemap = $('#sitemap');

    console.log($sitemap[0]);
    searchStructure($sitemap, "");

}

function searchStructure($node, path){

    $node.children().each(function(){

        var child = $(this)[0];
        if(child.nodeType==1){

            var tagName = child.nodeName.toLowerCase();
            if(tagName=="li"){
                searchLiNode($(child), path);
            }
        }
    });
}

function searchLiNode($node, path){

    var endOfTree= false;

    if($node.find("ul").length==0){
        endOfTree=true;
    }

    $node.children().each(function(){

        var child = $(this)[0];
        if(child.nodeType==1){

            //console.log(child.nodeName);
            var tagName = child.nodeName.toLowerCase();
            if(tagName=="ul"){

                searchStructure($(child), path);

            }else if(tagName=="a"){
                var url = $(child).attr('href');
                var str = url.split("/");
                url = "/"+str[str.length-1];
                path+=url;

                if(endOfTree){

                    console.log(path);
                    $('body').append($('<div>').text(path));
                }

            }
        }
    });
}



function displaySitemap(){
    var $sitemap = $('#sitemap');

    var wrap = $('<div>');
    $sitemap.find("a").each(function(){

        console.log("http://www.breconbeacons.org"+$(this).attr("href"));

        var url = "http://www.breconbeacons.org"+$(this).attr("href");
        wrap.append($('<div>').text(url));


    });

    $('body').append(wrap);
}