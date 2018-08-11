/**
 * Created by timoblume on 15.03.17.
 */
function responsiveNavigation() {
    var viewportWidth = $(window).width();
    $("#navigation-container").css("height", $("#navigation-affix").outerHeight(true));

    $("#navigation-affix").affix({
        offset: {top: $("header").outerHeight(true)}
    });

    if (viewportWidth > 768) {
        $("#navigation").removeClass("collapse");
        $("#navigation").removeAttr(" style ");
    }
    else {
        $("#navigation").addClass("collapse");
        $("#navigation-container").removeAttr(" style ");
        // Höhe neu setzen
        $("#navigation-container").css("height", $("#navigation-toggle").outerHeight(true));
        $("#navigation").removeAttr(" style ");

    }
}
$(document).ready(responsiveNavigation);
$(window).resize(responsiveNavigation);