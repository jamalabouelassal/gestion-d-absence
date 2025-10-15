// Animations
const registerButton = document.getElementById("register");
const loginButton = document.getElementById("loga");
const container = document.getElementById("container");

registerButton.addEventListener("click", () => {
  container.classList.add("right-panel-active");
});

loginButton.addEventListener("click", () => {
  container.classList.remove("right-panel-active");
});

// Register Form Validation
const registerForm = document.getElementById('registerForm');
const code = document.getElementById('code');
const nom = document.getElementById('nom');
const prenom = document.getElementById('prenom');
const cin = document.getElementById('cin');
const email = document.getElementById('email');
const password = document.getElementById('password');
const activationMessage = document.getElementById('activationMessage');

function showError(input, message) {
    const formControl = input.parentElement;
    formControl.className = 'form-control error';
    const small = formControl.querySelector('small');
    small.innerText = message;
}

function showSuccess(input) {
    const formControl = input.parentElement;
    formControl.className = 'form-control success';
    const small = formControl.querySelector('small');
    small.innerText = '';
}

function checkEmail(input) {
    const emailRegex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;
    if (emailRegex.test(input.value.trim())) {
        showSuccess(input);
        return true;
    } else {
        showError(input, "*Email is not valid");
        return false;
    }
}

function checkRequired(inputArr) {
    let isValid = true;
    inputArr.forEach(function(input) {
        if (input.value.trim() === '') {
            showError(input, `*${getFieldName(input)} is required`);
            isValid = false;
        } else {
            showSuccess(input);
        }
    });
    return isValid;
}

function getFieldName(input) {
    return input.id.charAt(0).toUpperCase() + input.id.slice(1);
}

registerForm.addEventListener('submit', function(e) {
    e.preventDefault();
    if (checkRequired([code, nom, prenom, cin, email, password]) && checkEmail(email)) {
        const formData = new FormData(registerForm);
        
        fetch('activate_account_process.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            activationMessage.innerText = data;
            activationMessage.style.color = data.includes('successfully') ? 'green' : 'red';
        })
        .catch(error => {
            activationMessage.innerText = 'An error occurred. Please try again.';
            activationMessage.style.color = 'red';
        });
    }
});

// Login Form Validation
const loginForm = document.querySelector('.login-container form');
const login = document.getElementById('login');
const loginPassword = document.getElementById('loginPassword');

function showLoginError(input, message) {
    const formControl = input.parentElement;
    formControl.className = 'form-control2 error';
    const small = formControl.querySelector('small');
    small.innerText = message;
}

function showLoginSuccess(input) {
    const formControl = input.parentElement;
    formControl.className = 'form-control2 success';
    const small = formControl.querySelector('small');
    small.innerText = '';
}

function checkLoginRequired(inputArr) {
    let isValid = true;
    inputArr.forEach(function(input) {
        if (input.value.trim() === '') {
            showLoginError(input, `*${getFieldName(input)} is required`);
            isValid = false;
        } else {
            showLoginSuccess(input);
        }
    });
    return isValid;
}

loginForm.addEventListener('submit', function(e) {
    e.preventDefault();
    if (checkLoginRequired([login, loginPassword])) {
        loginForm.submit();
    }
});
