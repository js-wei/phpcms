$(document).ready(TB_launch);

// function for adding Thickbox to elements of class .thickbox
// wrapped by Christian Montoya for uses other than $(document).ready
function TB_launch() {
    $("a.thickbox").click(function () {
        var t = this.title;
        var a = this.href || this.alt;
        //        if (a.indexOf('TB_iframe') != -1) //检测是否有TB_iniframe参数   
        //        { 
        //            window.top.TB_show(t, a);
        //            //self.parent.TB_show(t, a, g);
        //        }
        //        else {
        //            TB_show(t, a);
        //        }
        window.top.TB_show(t, a);
        this.blur();
        return false;
    });
}

function TB_show(caption, url) { //function called when the user clicks on a thickbox link
    try {
        $("body")
		.append("<div id='TB_overlay'></div><div id='TB_window'></div>");
        $("#TB_overlay").css("opacity", "0.6");
        $("#TB_overlay").css("filter", "alpha(opacity=60)");
        $("#TB_overlay").css("-moz-opacity", "0.6");
        $(window).resize(TB_position);
        $("body").append("<div id='TB_load'><div id='TB_loadContent'><img src='loadingAnimation.gif' /></div></div>");
        $("#TB_overlay").show();
        var urlString = /.jpg|.jpeg|.png|.gif|.aspx|.html|.htm/g;
        var urlType = url.match(urlString);

        if (urlType == '.jpg' || urlType == '.jpeg' || urlType == '.png' || urlType == '.gif') {//code to show images

            var imgPreloader = new Image();
            imgPreloader.onload = function () {

                // Resizing large images added by Christian Montoya
                var de = document.documentElement;
                var x = (self.innerWidth || (de && de.clientWidth) || document.body.clientWidth) - 50;
                var y = (self.innerHeight || (de && de.clientHeight) || document.body.clientHeight) - 80;
                if (imgPreloader.width > x) {
                    imgPreloader.height = imgPreloader.height * (x / imgPreloader.width);
                    imgPreloader.width = x;
                    if (imgPreloader.height > y) {
                        imgPreloader.width = imgPreloader.width * (y / imgPreloader.height);
                        imgPreloader.height = y;
                    }
                }
                else if (imgPreloader.height > y) {
                    imgPreloader.width = imgPreloader.width * (y / imgPreloader.height);
                    imgPreloader.height = y;
                    if (imgPreloader.width > x) {
                        imgPreloader.height = imgPreloader.height * (x / imgPreloader.width);
                        imgPreloader.width = x;
                    }
                }
                // End Resizing

                TB_WIDTH = imgPreloader.width + 30;
                TB_HEIGHT = imgPreloader.height + 60;
                $("#TB_window").append("<img id='TB_Image' src='" + url + "' width='" + imgPreloader.width + "' height='" + imgPreloader.height + "' alt='" + caption + "'/>" + "<div id='TB_caption'>" + caption + "</div><div id='TB_closeWindow'><a href='#' id='TB_closeWindowButton'>关闭</a></div>");
                $("#TB_closeWindowButton").click(TB_remove);
                $("#TB_Image").click(TB_remove); // close when image clicked added by Christian Montoya
                TB_position();
                $("#TB_load").remove();
                $("#TB_window").slideDown("normal");
            }

            imgPreloader.src = url;
        }

        if (urlType == '.aspx' || urlType == '.htm' || urlType == '.html') {//code to show html pages

            var queryString = url.replace(/^[^\?]+\??/, '');
            var params = parseQuery(queryString);

            TB_WIDTH = (params['width'] * 1) + 30;
            TB_HEIGHT = (params['height'] * 1) + 40;


            var id = params['id'];


            ajaxContentW = TB_WIDTH - 30;
            ajaxContentH = TB_HEIGHT - 45;
            $("#TB_window").append("<div id='TB_closeAjaxWindow'><a href='#' id='TB_closeWindowButton' value=" + id + ">关闭</a></div><div id='TB_ajaxContent' style='width:" + ajaxContentW + "px;height:" + ajaxContentH + "px;'></div>");
            $("#TB_closeWindowButton").click(TB_remove);
            $("#TB_ajaxContent").load(url, function () {
                TB_position();
                $("#TB_load").remove();
                $("#TB_window").slideDown("normal");
            });
        }

    } catch (e) {
        alert(e);
    }
}

//helper functions below

function TB_remove() {
    // #TB_load removal added by Christian Montoya; solves bug when overlay is closed before image loads
    $("#TB_window").fadeOut("fast", function () { $('#TB_window,#TB_overlay,#TB_load').remove(); });
    return false;
}

function TB_position() {
    var de = document.documentElement;
    var w = self.innerWidth || (de && de.clientWidth) || document.body.clientWidth;
    var h = self.innerHeight || (de && de.clientHeight) || document.body.clientHeight;

    if (window.innerHeight && window.scrollMaxY) {
        yScroll = window.innerHeight + window.scrollMaxY;
    } else if (document.body.scrollHeight > document.body.offsetHeight) { // all but Explorer Mac
        yScroll = document.body.scrollHeight;
    } else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
        yScroll = document.body.offsetHeight;
    }

    $("#TB_window").css({ width: TB_WIDTH + "px", height: TB_HEIGHT + "px",
        left: ((w - TB_WIDTH) / 2) + "px", top: ((h - TB_HEIGHT) / 2) + "px"
    });
    $("#TB_overlay").css("height", yScroll + "px");
}

function parseQuery(query) {
    var Params = new Object();
    if (!query) return Params; // return empty object
    var Pairs = query.split(/[;&]/);
    for (var i = 0; i < Pairs.length; i++) {
        var KeyVal = Pairs[i].split('=');
        if (!KeyVal || KeyVal.length != 2) continue;
        var key = unescape(KeyVal[0]);
        var val = unescape(KeyVal[1]);
        val = val.replace(/\+/g, ' ');
        Params[key] = val;
    }
    return Params;
}
