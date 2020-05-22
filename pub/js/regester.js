window.addEventListener('DOMContentLoaded', function () {
    // TODO： まとめられないか考える
    const referrer = 'http://localhost/dev/blog/pub/html/login.html'
    const back = '/dev/blog/pub/html/login.html';
    if(document.referrer !== referrer) location.href = back;
});