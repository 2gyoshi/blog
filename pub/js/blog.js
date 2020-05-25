// 個別表示と分離するべきかどうか考える
class Blog {
    constructor(utility) {
        this.json = null;
        this.utility = utility;
    }

    async getArticleData() {
        const path = '/dev/blog/pub/php/get_article_json.php';
        this.json = await this.utility.get(path);
    }

    render() {
        this.renderArticle();
        this.renderTag();
    }

    renderArticle() {
        const target = document.querySelector('.blog-main');
        const data = this.filterJson();
        data.forEach(e => {
            let html = `<article class="card">
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

    renderTag() {
        const target = document.querySelector('.blog-aside');

        let html = `<div class="card">
            <div class="card-header">
                <span class="card-header__title--aside">
                    Tags
                </span>
            </div>
            <div class="card-content">
                ${this.getTagHTML()}
            </div>
        </div>`;
        
        target.insertAdjacentHTML('beforeend', html);
    }

    filterJson() {
        const query = location.search;
        const json  = this.json;

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

    getImageHTML(images) {
        let html = '';
        if(images[0] === null) return html;
        const path = '/dev/blog/pub/img/article/';
        images.forEach(e => {
            html += `<img class="card-content__image"
                src="${path + e}" alt="Cannot display image file">`;
        });

        return html;
    }

    getTagHTML() {
        let html = '';
        const path = '/dev/blog/pub/html/blog.html';
        const cssClass = 'card-content__tag';

        let array = [];
        this.json.forEach(e => array = array.concat(e.tags));
        const tags = Array.from(new Set(array)).filter(e => e !== null);

        tags.forEach(i => {
            html +=
                `<a class="${cssClass}" href="${path}?tag=${i}">${i}</a>`;
        });

        return html;
    }
}

window.addEventListener('load', async function () {
    const utility = new Utility();
    const blog = new Blog(utility);
    await blog.getArticleData();
    blog.render();
});