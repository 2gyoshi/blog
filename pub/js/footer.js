class Footor {
    render() {
        const html = `<div class="footer-container">
            <span class="nomeaning" title="It doesn't really mean anything">
                I like Youtube!
            </span>
            <span class="nomeaning copywirte" title="It doesn't really mean anything">
                © asobiba. 2020
                </span>
        </div>`;

        const target = document.getElementById('globalFooter');
        target.innerHTML = html;
    }

}

window.addEventListener('load', () => {
    const footer = new Footor();
    footer.render();
});