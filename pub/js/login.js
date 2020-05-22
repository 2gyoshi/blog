class Login {
    constructor() {
        this.nextPage = '/dev/blog/pub/html/regester.html';
    }
    async decision() {
        const path = '/dev/blog/pub/php/get_user_json.php';
        const json = await getJson(path);
        const id   = document.querySelector('#js-login-id').value;
        const pass = document.querySelector('#js-login-pass').value;
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

window.onload = () => {
    const login = new Login();
    const btn = document.querySelector('#js-login-btn');
    btn.addEventListener('click', login.decision.bind(login));


}