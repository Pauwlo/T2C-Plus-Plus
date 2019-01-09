// Prevents MobileSafari from opening links in a new window.
$(function () {
    var a = $('a');

    $.each(a, function (k,v) {
        v.onclick = function () {
            window.location=this.getAttribute("href");
            return false;
        }
    });
})
