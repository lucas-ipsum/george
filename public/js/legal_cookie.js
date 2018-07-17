$( document ).ready(function() {

    var footer_style = "<style>\n" +
        ".legal_footer {\n" +
        "   position: fixed;\n" +
        "   left: 0;\n" +
        "   minHeight: 84px;" +
        "   bottom: 0;\n" +
        "   width: 100%;\n" +
        "   background: #13306a;\n" +
        "   border-bottom: 3px solid #fff;\n" +
        "   color: white;\n" +
        "   text-align: center;\n" +
        "}\n" +
        "</style>\n";

    var footer = "<div class=\"legal_footer\">\n" +
        "<a id=\"legalfooter-button\" role=\"button\" data-toggle=\"collapse\" href=\"\" aria-expanded=\"false\" aria-controls=\"legalfooter\"><b style=\"position: absolute;right: 20px;\"><i class=\"fa fa-times\" aria-hidden=\"true\"></i></a>\n" +
        "</b><b>Verwendung von Cookies</b><br><br>" +
        "Um unsere Webseite für Sie optimal zu gestalten und fortlaufend verbessern zu können, verwenden wir Cookies. Durch die weitere Nutzung der Webseite stimmen Sie der Verwendung von Cookies zu.<br>" +
        "Weitere Informationen zu Cookies erhalten Sie in unserer <a href='/de/439479.html' target='_blank'><ins>Datenschutzerklärung</ins></a>" +
        "</div>"

    if(getCookie("Legal") === "" && getCookie("Legal") !== "1") {
        var div = document.createElement( "div" );
        div.innerHTML = footer_style;
        document.querySelector("body" ).appendChild( div.firstChild );
        div.innerHTML = footer;
        document.querySelector("body" ).appendChild( div.firstChild );
    }


    $("#legalfooter-button").on("click", function() {
        setCookie("Legal", 1, 365)
        $(".legal_footer").remove();
    })
});

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}


function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
