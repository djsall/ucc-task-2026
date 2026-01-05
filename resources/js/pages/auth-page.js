import {login, isAuthenticated} from '../auth.js';
import {clearErrors, showMessage} from "./common.js";

const elements = {
    form: document.getElementById('form'),
    errorContainer: document.getElementById('form-error'),
    submitButton: document.getElementById('submit'),
};

elements.form.addEventListener('submit', async (e) => {
    e.preventDefault();

    clearErrors(elements.errorContainer);

    const data = {
        email: e.target.email.value,
        password: e.target.password.value,
    }

    elements.submitButton.disabled = true;

    if (!data.email || !data.password) {
        showMessage(elements.errorContainer, 'Please input your email and password', 'error');
        return;
    }

    const result = await login(data);

    elements.submitButton.disabled = false;

    if (!result) {
        showMessage(elements.errorContainer, 'Wrong username or password', 'error');

        return;
    }

    window.location.href = '/';
});

document.addEventListener('DOMContentLoaded', async () => {
    if (isAuthenticated()) {
        window.location.replace('/');
    }
});
