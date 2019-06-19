feather.replace();
var clipboard = new ClipboardJS('#external-link-btn');

$("#shorten").click(function(e) {
    e.preventDefault();
    let initial_link = $("#initial_link").val();
    let expiry_date = "0000-00-00 00:00:00";
    $.ajax({
        type: "POST",
        url: "/generate/" + initial_link + "/" + expiry_date,
        success: function(result) {
            $("#result").css("display", "block");
            $("#external-link").val(result);
            $("#external-analytics").attr("href", "/analytics/" + result);
        }
    });
});