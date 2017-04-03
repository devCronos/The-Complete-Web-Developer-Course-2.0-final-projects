/**
 * Created by Cronos on 2/9/2017.
 */

function updateOutput(){
    $("iframe").contents().find("html").html("<html><head>" +
    "<style type='text/css'>" + $("#csstext").val()+ "</style>" +
    "</head><body>"+$("#htmltext").val()+ "</body></html>");
    document.getElementById("ifr").contentWindow.eval($("#jstext").val());
}

$('a').hover(function() {
$(this).css('cursor','default');
});

$("#htmlt").click(function() {
   $("#html").toggle()
});
$("#csst").click(function() {
   $("#css").toggle()
});
$("#jst").click(function() {
   $("#js").toggle()
});
$("#outputt").click(function() {
   $("#output").toggle()
});
$(".button").click(function() {
    $(this).toggleClass("not-selected")
})

$(".toggable").height($(window).height()-$("#top-container").height);

updateOutput()
$("#htmltext").on("change keyup paste", function () {
    updateOutput()
});




