class Blog {
    constructor() {
        this.json = null;
    }

    async getArticleData() {
        const path = '/dev/blog/pub/php/get_article_json.php';
        this.json = await getJson(path);
    }

    async setArticleData() {
        const articles = this.json.articles;
        const target = document.querySelector('.blog-main');
        articles.forEach(e => {
            let html = 
            `<div class="article">
                <h2 class="article__title">
                    <a href="./article.html">${e.title}</a>
                </h2>
                <div class="article__cotent">
                    ${this.renderImg(e.image)}
                    <p class="article__text">${e.text}</p>
                </div>
            </div>`;
            target.insertAdjacentHTML('beforeend', html);
        });
    }

    renderImg(images) {
        const path = '/dev/blog/pub/img/';
        let html = '<div class="article__image">';

        images.forEach(e => {
            // TODO: alt属性をつける
            html += `<img src="${path + e}" alt="test"></img>`;
        });

        html += '</div>';
        return html;
    }
}

window.onload = async function(){
    const blog = new Blog();
    await blog.getArticleData();
    await blog.setArticleData();
}