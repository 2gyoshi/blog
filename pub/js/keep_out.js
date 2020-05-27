class KeepOut {
    constructor() {
        // TODO: 環境依存変数 ====================
        this.keepOutImage = CONFIG.keepOutImage;
        //======================================
    }

    render() {
        const html = `
        <h1 class="keep-out-message">ただいま工事中です</h1>
        <img class="keep-out" src="${this.keepOutImage}" alt="keep out">`;
        document.querySelector('main').innerHTML = html;
    }
}

window.addEventListener('load', () => {
    const ko = new KeepOut();
    ko.render();
});