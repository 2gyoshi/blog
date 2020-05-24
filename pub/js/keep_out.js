class Parts {
    constructor() {
        this.children = [];
        this.exportDOM = null;
    }

    render(){

    }
}

class KeepOut {
    constructor() {
        this.items = [];
    }
}


window.addEventListener('load', function () {
    new KeepOut();
});