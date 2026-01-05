import {forgotPassword, isAuthenticated} from '../auth.js';
import {showMessage} from "./common.js";

const elements = {
    form: document.getElementById('form'),
    errorContainer: document.getElementById('form-error'),
    submitButton: document.getElementById('submit'),
}

elements.form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const email =  e.target.email.value;

    if (! email) {
        showMessage(elements.errorContainer, 'Please input your email', 'error');

        return;
    }

    elements.submitButton.disabled = true;

    const result = await forgotPassword(email);

    elements.submitButton.disabled = false;

    if (result) {
        showMessage(elements.errorContainer, 'Reset link sent', 'success');

        return;
    }

    showMessage(elements.errorContainer, 'Reset failed', 'error')
});


document.addEventListener('DOMContentLoaded', async () => {
    if (isAuthenticated()) {
        window.location.replace('/');
    }
});
