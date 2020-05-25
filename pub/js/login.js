class Login {
    constructor(utility) {
        this.utility = utility;

        // TODO: 環境依存変数 ====================
        this.nextPage = CONFIG.registerHTMLPath;
        this.userDataAPIPath = CONFIG.userDataAPIPath;
        //======================================
    }

    async check() {
        const json = await this.utility.get(this.userDataAPIPath);
        const id   = document.querySelector('#loginID').value;
        const pass = document.querySelector('#loginPass').value;
        const result = json.filter(e => e.id === id).filter(e => e.password === pass);
        if(result.length === 0) return this.mistake();
        this.correct();
    }

    correct() {
        location.href = this.nextPage;
    }

    mistake() {
        alert('ID or password is wrong');
    }
}

window.addEventListener('load', async function () {
    const utility = new Utility();
    const login = new Login(utility);
    const btn = document.querySelector('#loginBtn');
    btn.addEventListener('click', login.check.bind(login));
});