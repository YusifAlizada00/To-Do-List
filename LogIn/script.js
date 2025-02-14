var registerLogin_Function = {
    passwordMatch: function () {
        var forgotContainer = document.getElementById('forgotContainer');

        forgotContainer.addEventListener('submit', function (event) {
            var confirmPassword = document.getElementById('confirmPassword');
            var forgotPassword = document.getElementById('forgotPassword');
            if (forgotPassword.value !== confirmPassword.value) {
                event.preventDefault();
                alert('Passwords must match!');
            }
        });
    },

    displayForgotContainer: function () {
        var forgotPass = document.getElementById('forgotPass');
        var forgotContainer = document.getElementById('forgotContainer');
        var signInForm = document.getElementById('signIn');

        forgotPass.addEventListener('click', function () {
            signInForm.style.display = "none";
            forgotContainer.style.display = "block";
        });
    },

    toggleConfirmPassword: function () {
        var toggleConfirmPassword = document.getElementById('toggleConfirmPassword');

        toggleConfirmPassword.addEventListener('click', function () {
            var confirmPassword = document.getElementById('confirmPassword');
            if (confirmPassword.type === "password") {
                confirmPassword.type = "text";
                toggleConfirmPassword.classList.remove("fa-eye");
                toggleConfirmPassword.classList.add("fa-eye-slash");
            } else {
                confirmPassword.type = "password";
                toggleConfirmPassword.classList.remove("fa-eye-slash");
                toggleConfirmPassword.classList.add("fa-eye");
            }
        });
    },

    toggleForgotPassword: function () {
        var toggleForgotPassword = document.getElementById('toggleForgotPassword');

        toggleForgotPassword.addEventListener('click', function () {
            var forgotPassword = document.getElementById('forgotPassword');
            if (forgotPassword.type === "password") {
                forgotPassword.type = "text";
                toggleForgotPassword.classList.remove("fa-eye");
                toggleForgotPassword.classList.add("fa-eye-slash");
            } else {
                forgotPassword.type = "password";
                toggleForgotPassword.classList.remove("fa-eye-slash");
                toggleForgotPassword.classList.add("fa-eye");
            }
        });
    },

    signUpPassword: function () {
        var toggleSignUpPassword = document.getElementById('toggleSignUpPassword');

        toggleSignUpPassword.addEventListener('click', function () {
            var signUpPasswordInput = document.getElementById('signUpPasswordInput');
            if (signUpPasswordInput.type === "password") {
                signUpPasswordInput.type = "text";
                toggleSignUpPassword.classList.remove("fa-eye");
                toggleSignUpPassword.classList.add("fa-eye-slash");
            } else {
                signUpPasswordInput.type = "password";
                toggleSignUpPassword.classList.remove("fa-eye-slash");
                toggleSignUpPassword.classList.add("fa-eye");
            }
        });
    },

    signInPassword: function () {
        var toggleSignInPassword = document.getElementById('toggleSignInPassword');

        toggleSignInPassword.addEventListener('click', function () {
            var signInPasswordInput = document.getElementById('signInPasswordInput');
            if (signInPasswordInput.type === "password") {
                signInPasswordInput.type = "text";
                toggleSignInPassword.classList.remove("fa-eye");
                toggleSignInPassword.classList.add("fa-eye-slash");
            } else {
                signInPasswordInput.type = "password";
                toggleSignInPassword.classList.remove("fa-eye-slash");
                toggleSignInPassword.classList.add("fa-eye");
            }
        });
    },

    logInButton: function () {
        var loginBtn = document.getElementById('logInBtn');
        var signInForm = document.getElementById('signIn');
        var signUpForm = document.getElementById('signUp');

        loginBtn.addEventListener('click', function () {
            signUpForm.style.display = "block";
            signInForm.style.display = "none";
        });
    },

    signInForm: function () {
        const signInForm = document.getElementById('signIn');

        signInForm.addEventListener('submit', function (event) {
            event.preventDefault();
            window.location.href = '/To-Do-List/Pricing/payment.html';
        });
    }
};
