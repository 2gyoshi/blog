window.addEventListener('DOMContentLoaded', function () {
    const prev = '/dev/blog/pub/html/login.html';
    if(document.referrer !== prev) location.href = prev;
});