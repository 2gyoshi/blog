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
                <h2 class="article-title">
                    <a href="./article.html">${e.title}</a>
                </h2>
                <div class="article-content">
                    ${this.renderImg(e.image)}
                    <p class="article-content__text">${e.text}</p>
                </div>
                <div class="article-fotter">
                    <div class="article-fotter__comment">Comment</div>
                    <time class="article-fotter__published">March 6th, 2020</time>
                </div>
            </div>`;
            target.insertAdjacentHTML('beforeend', html);
        });
    }

    renderImg(images) {
        const path = '/dev/blog/pub/img/';
        let html = '';
        images.forEach(e => {
            // TODO: alt属性をつける
            html += `<img class="article-content__image" src="${path + e}" alt="test"></img>`;
        });
        return html;
    }
}

window.onload = async function(){
    const blog = new Blog();
    await blog.getArticleData();
    await blog.setArticleData();
}