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
            `<article class="card">
                <h2 class="card-header">
                    <a href="./article.html">${e.title}</a>
                </h2>
                <div class="card-content">
                    ${this.renderImg(e.image)}
                    <p class="card-content__text">${e.text}</p>
                </div>
                <div class="card-fotter">
                    <div class="card-fotter__comment">Comment</div>
                    <time class="card-fotter__published">March 21th, 2020</time>
                </div>
            </article>`;
            target.insertAdjacentHTML('beforeend', html);
        });
    }

    renderImg(images) {
        const path = '/dev/blog/pub/img/';
        let html = '';
        images.forEach(e => {
            // TODO: alt属性をつける
            html += `<img class="card-content__image" src="${path + e}" alt="test"></img>`;
        });
        return html;
    }
}

window.onload = async function(){
    const blog = new Blog();
    await blog.getArticleData();
    await blog.setArticleData();
}