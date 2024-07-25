
document.addEventListener('DOMContentLoaded', function () {
    const showLoginButton = document.getElementById('show-login');
    const showSignupButton = document.getElementById('show-signup');
    const loginForm = document.querySelector('.form--login');
    const signupForm = document.querySelector('.form--signup');
    const formWrapper = document.querySelector('.form-wrapper');

    showLoginButton.addEventListener('click', function () {
        formWrapper.style.display = 'block';
        loginForm.style.display = 'block';
        signupForm.style.display = 'none';
    });

    showSignupButton.addEventListener('click', function () {
        formWrapper.style.display = 'block';
        loginForm.style.display = 'none';
        signupForm.style.display = 'block';
    });
});
