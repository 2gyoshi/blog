// 個別表示と分離するべきかどうか考える
class Blog {
    constructor() {
        this.json = null;
    }

    // TODO: これいらなくない？
    async getArticleData() {
        const path = '/dev/blog/pub/php/get_article_json.php';
        this.json = await getJson(path);
    }

    async renderArticle() {
        const target = document.querySelector('.blog-main');
        const data = this.getData();
        data.forEach(e => {
            let html = 
                `<article class="card">
                    <div class="card-header">
                        ${this.getTitleHTML(e)}
                    </div>
                    <div class="card-content">
                        ${this.getImageHTML(e.images)}
                        <p class="card-content__text">
                            ${e.text}
                        </p>
                    </div>
                    <div class="card-fotter">
                        <div class="card-fotter__comment">
                            Comment
                        </div>
                        <time class="card-fotter__update" datetime="${e.time}">
                            ${e.time}
                        </time>
                    </div>
                </article>`;
            target.insertAdjacentHTML('beforeend', html);
        });
    }

    getData() {
        const query = location.search;
        const json  = this.json.articles;

        if(query === '') return json;
        
        if(query.indexOf('id') !== -1) {
            const id = Number(query.split('=')[1]);
            return json.filter(e => e.id === id);
        }
        
        if(query.indexOf('tag') !== -1) {
            const tag = query.split('=')[1];
            const list = json.filter(e => e.tags.filter(e => e === tag).length > 0);
            return list;
        }

    }


    getImageHTML(images) {
        let html = '';
        if(images[0] === null) return html;
        const path = '/dev/blog/pub/img/';
        images.forEach(e => {
            // TODO: alt属性をつける
            html += `<img class="card-content__image" src="${path + e}" alt="test"></img>`;
        });
        return html;
    }

    getTitleHTML(e) {
        let html = '';
        const query = location.search;
        const path = `/dev/blog/pub/html/article.html`;
        const cssClass = 'card-header__title';
        
        if(query === '') {
            html = `<a class="${cssClass}" href="${path}?id=${e.id}">
                ${e.title}
            </a>`;
        } 

        if(query.indexOf('tag') !== -1) {
            html = `<a class="${cssClass}" href="${path}?id=${e.id}">
                ${e.title}
            </span>`;
        } 

        if(query.indexOf('id') !== -1) {
            html = `<span class="${cssClass}">
                ${e.title}
            </span>`;
        }

        return html;
    }

    async renderTags() {
        const target = document.querySelector('.blog-aside');
        const path = '/dev/blog/pub/php/get_tags_json.php';
        const json = await getJson(path);

        let html = 
            `<div class="card">
                <div class="card-header">
                    <span class="card-header__title--aside">Tags</span>
                </div>
                <div class="card-content">
                    ${this.getTagHTML(json)}
                </div>
            </div>`;
        
        target.insertAdjacentHTML('beforeend', html);

    }

    getTagHTML(json) {
        const path = '/dev/blog/pub/html/blog.html';
        const cssClass = 'card-content__tag';

        let html = '';
        json.forEach(e => {
            html +=
                `<a class="${cssClass}" href="${path}?tag=${e.value}">
                    ${e.value}
                </a>`;
        });
        return html;
    }
}

window.onload = async function(){
    const blog = new Blog();
    await blog.getArticleData();
    await blog.renderArticle();
    await blog.renderTags();


}