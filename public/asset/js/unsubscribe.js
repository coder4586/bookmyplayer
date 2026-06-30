$(document).ready(function () {
    let countdown = 5;
    let interval = setInterval(function () {
        countdown--;
        $("#countdown").text(countdown);
        if (countdown <= 0) {
            clearInterval(interval);
            window.location.href = "https://www.bookmyplayer.com";
        }
    }, 1000);
});