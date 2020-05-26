class Header {
    constructor() {
        // TODO: 環境依存変数 ====================
        this.indexHTMLPath = CONFIG.indexHTMLPath;
        this.workHTMLPath = CONFIG.workHTMLPath;
        this.blogHTMLPath = CONFIG.blogHTMLPath;
        this.aboutHTMLPath = CONFIG.aboutHTMLPath;
        //======================================
    }

    render() {
        const html = `<div class="global-header__container">
            <h1 class="global-header__title">
                <a href="${this.indexHTMLPath}">asobiba</a>
            </h1>
            <nav class="global-navi">
                <input type="checkbox" id="drawer-checkbox"
                    class="global-navi__checkbox" />
                <label for="drawer-checkbox" class="global-navi__label">
                    <span class="global-navi__icon"></span>
                </label>
                <label for="drawer-checkbox" class="global-navi__label--close">
                    <span class="global-navi__icon--close"></span>
                </label>
                <ul class="global-navi__list">
                    <li><a href="${this.workHTMLPath}">Work</a></li>
                    <li><a href="${this.blogHTMLPath}">Blog</a></li>
                    <li><a href="${this.aboutHTMLPath}">About</a></li>
                </ul>
            </nav>
        </div>`;

        const target = document.getElementById('globalHeader');
        target.innerHTML = html;
    }

}

window.addEventListener('load', () => {
    const header = new Header();
    header.render();
});