// class Utility {
//     async get(path) {
//         try {
//             const response = await fetch(path, {
//                 method: "GET",
//                 mode: "cors",
//                 cache: "no-cache"
//             });
    
//             if (response.ok) {
//                 const json = await response.json();
//                 return json;
//             } else {
//                 throw new Error('Network response was not ok.');
//             }
//         } catch (error) {
//             console.error(error);
//         }
//     }
    
//     async post(url, data) {
//         try {
//             const response = await fetch(url, {
//                 method: "POST",
//                 mode: "cors",
//                 cache: "no-cache",
//                 body: JSON.stringify(data)
//             });
    
//             if (response.ok) {
//                 const json = await response.json();
//                 return json;
//             } else {
//                 throw new Error('Network response was not ok.');
//             }
//         } catch (error) {
//             console.error(error);
//         }
//     }
// }

class Tag {
    constructor() {
        this.items = [];
        this.displayDom = document.getElementById('tagDisplay');
    }

    addItem(value) {
        if(value === '') return;
        if(this.items.indexOf(value) > -1) return;
        this.items.push(value);
    }

    removeItem(value) {
        this.items = this.items.filter(e => e === value);
    }

    display() {
        this.displayDom.innerHTML = this.getDisplayHTML();
    }

    getDisplayHTML() {
        const array = this.items.map(e => `<span>${e}</span>`);
        return array.join();
    }
}

class Register {
    constructor(utility, tag) {
        this.tag = tag;
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
        this.addTagBtnEvent();
        this.addSubmitBtnEvent();
    }
    
    addTagBtnEvent() {
        this.tagBtn.addEventListener('click', this.addTagBtnClick.bind(this));
    }

    addSubmitBtnEvent() {
        this.submitBtn.addEventListener('click', this.submitBtnClick.bind(this));
    }

    addTagBtnClick() {
        this.tag.addItem(this.tagInputDom.value);
        this.tag.display();
    }

    async submitBtnClick() {
        const url = '/dev/blog/pub/php/register.php';
        const data = this.getFormData();
        const response = await this.utility.post(url, data);
        return alert(response.message);
    }

    getFormData() {
        const title  = this.titleInputDom.value;
        const text   = this.textInputDom.value;
        const images = [];
        const tags   = this.tag.items;

        const fileList = this.imageInput.files;
        for(let i = 0; i < fileList.length; i++) {
            images.push(fileList[i].name);
        }

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
    const utility = new Utility();
    const tag = new Tag();
    const register = new Register(utility, tag)
    register.init();
});