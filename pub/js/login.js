class Login {
    constructor(utility) {
        this.nextPage = '/dev/blog/pub/html/register.html';
        this.utility = utility;
    }
    async check() {
        const path = '/dev/blog/pub/php/get_user_json.php';
        const json = await this.utility.get(path);
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