feather.replace();
var clipboard = new ClipboardJS('#external-link-btn');

$("#shorten").click(function(e) {
    e.preventDefault();
    let initial_link = $("#initial_link").val();
    let expire_date = "0000-00-00 00:00:00";
    $.ajax({
        type: "POST",
        url: "/api/generate",
        data: {
            initial_link: initial_link,
            expire_date: expire_date
        },
        success: function(result) {
            let hostname = $(location).attr('hostname');
            let protocol = $(location).attr('protocol');
            $("#external-link").val(protocol + "//" + hostname + "/" + result);
            $("#external-analytics").attr("href", "/analytics/" + result);
            $("#result").css("display", "block");
        }
    });
});