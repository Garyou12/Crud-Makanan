// VALIDASI KOSONG + ANIM SHAKE
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');

    form.addEventListener('submit', e => {
        const inputs = form.querySelectorAll('input');
        let invalid = false;

        inputs.forEach(inp => {
            if (inp.value.trim() === "") {
                invalid = true;
                inp.classList.add('shake');
                setTimeout(() => inp.classList.remove('shake'), 450);
            }
        });

        if (invalid) e.preventDefault();
    });
});


// SHOW / HIDE PASSWORD
document.addEventListener("DOMContentLoaded", () => {
    const toggleBtn = document.getElementById("togglePw");
    const password = document.getElementById("password");

    if (toggleBtn && password) {
        toggleBtn.addEventListener("click", () => {
            const hidden = password.type === "password";
            password.type = hidden ? "text" : "password";
            toggleBtn.textContent = hidden ? "🙈" : "👁️";
        });
    }
});