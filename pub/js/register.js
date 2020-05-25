class Tag {
    constructor() {
        this.items = [];
        this.target = document.getElementById('tagDisplay');
    }

    addItem(value) {
        if(value === '') return;
        if(this.items.indexOf(value) > -1) return;
        this.items.push(value);
    }

    removeItem(event) {
        const item = event.target.parentNode;
        const wrapper = item.parentNode;
        const value = item.innerHTML;
        wrapper.remove();
        this.items = this.items.filter(e => e === value);
    }

    display() {
        this.target.innerHTML = '';
        this.items.forEach(e => {
            const wrapperCssClass = 'register-tag';
            const tagCssClass = 'register-tag__item';
            const delCssClass = 'register-tag__delete';

            const wrapper = document.createElement('div');
            wrapper.classList.add(wrapperCssClass);

            const tag = document.createElement('span');
            tag.classList.add(tagCssClass);
            tag.innerHTML = e;

            const del = document.createElement('span');
            del.addEventListener('click', this.removeItem.bind(this));
            del.classList.add(delCssClass);
            del.innerHTML = '×';

            wrapper.insertAdjacentElement('beforeend', tag);
            tag.insertAdjacentElement('beforeend', del);
            this.target.insertAdjacentElement('beforeend', wrapper);
        });
    }
}

class Image {
    constructor() {
        this.items = [];
        this.target = document.getElementById('imgDisplay');
    }

    addItem(value) {
        if(value === '') return;
        if(this.items.indexOf(value) > -1) return;
        this.items.push(value);
    }

    removeItem(event) {
        const item = event.target.parentNode;
        const wrapper = item.parentNode;
        const value = item.innerHTML;
        wrapper.remove();
        this.items = this.items.filter(e => e === value);
    }

    display() {
        this.target.innerHTML = '';
        // FileListオブジェクトを利用する
        this.items.forEach(e => {
            for(let i = 0; i < e.length; i++) {
                const wrapperCssClass = 'register-img';
                const imgCssClass = 'register-img__item';
                const delCssClass = 'register-img__delete';

                const wrapper = document.createElement('div');
                wrapper.classList.add(wrapperCssClass);

                const img = document.createElement('span');
                img.classList.add(imgCssClass);
                img.innerHTML = e[i].name;

                const del = document.createElement('span');
                del.addEventListener('click', this.removeItem.bind(this));
                del.classList.add(delCssClass);
                del.innerHTML = '×';

                wrapper.insertAdjacentElement('beforeend', img);
                img.insertAdjacentElement('beforeend', del);
                this.target.insertAdjacentElement('beforeend', wrapper);
            }
        });
    }
}

class Register {
    constructor(tag, img, utility) {
        this.tag = tag;
        this.img = img;
        this.utility = utility;

        // ボタン
        this.tagBtn = document.getElementById('tagBtn');
        this.imgBtn = document.getElementById('imgBtn');
        this.submitBtn = document.getElementById('submitBtn');

        // インプット
        this.imageInput = document.getElementById('imageInput');
        this.titleInputDom = document.getElementById('titleInput');
        this.textInputDom  = document.getElementById('textInput');
        this.tagInputDom   = document.getElementById('tagInput');
    }

    init() {
        this.addEvent();
    }

    addEvent() {
        this.addImgEvent();
        this.addTagBtnEvent();
        this.addSubmitBtnEvent();
    }

    addImgEvent() {
        this.imageInput.addEventListener('change', this.addImgInputChange.bind(this));
    }

    addTagBtnEvent() {
        this.tagBtn.addEventListener('click', this.addTagBtnClick.bind(this));
    }

    addSubmitBtnEvent() {
        this.submitBtn.addEventListener('click', this.submitBtnClick.bind(this));
    }

    addImgInputChange() {
        this.img.addItem(this.imageInput.files);
        this.img.display();
    }

    addTagBtnClick() {
        this.tag.addItem(this.tagInputDom.value);
        this.tag.display();
    }

    async submitBtnClick() {
        const registerResult = await this.register();
        if(registerResult.status < 0) {
            return alert(registerResult.message);
        }

        const uploadResult = await this.upload();
        if(uploadResult.status < 0) {
            return alert(uploadResult.message);
        }

        return alert('success!');
    }

    async register() {
        const url = '/dev/blog/pub/php/register.php';
        const data = this.getFormData();
        const response = await this.utility.post(url, data);
        return response;
    }

    async upload() {
        const url = '/dev/blog/pub/php/upload.php';
        const formData = new FormData();
        this.img.items.forEach(e => {
            for(let i = 0; i < e.length; i++) {
                formData.append('files[]', e[i]);
            }
        });
        const response = await this.utility.upload(url, formData);
        return response;
    }

    getFormData() {
        const title  = this.titleInputDom.value;
        const text   = this.textInputDom.value;
        const images = [];
        const tags   = this.tag.items;

        this.img.items.forEach(e => {
            for(let i = 0; i < e.length; i++) {
                let file = e[i].name;
                if(images.indexOf(file) !== -1) continue;
                images.push(e[i].name);
            }
        });
   
        const object = {
            title: title,
            text: text,
            images: images,
            tags: tags
        }

        return object;
    }

}

window.addEventListener('DOMContentLoaded', function () {
    const referrer = 'http://localhost/dev/blog/pub/html/login.html'
    if(document.referrer !== referrer) location.href = referrer;
});

window.addEventListener('load', function () {
    const img = new Image();
    const tag = new Tag();
    const utility = new Utility();
    const register = new Register(tag, img, utility)
    register.init();
});