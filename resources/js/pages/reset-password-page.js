import {resetPassword, isAuthenticated} from '../auth.js';
import {showMessage} from "./common.js";

const elements = {
    form: document.getElementById('form'),
    errorContainer: document.getElementById('form-error'),
    submitButton: document.getElementById('submit'),
};

elements.form.addEventListener('submit', async (event) => {
    event.preventDefault();

    const {password, password_confirmation} = event.target.elements;

    if (password.value !== password_confirmation.value) {
        showMessage(elements.errorContainer, 'Passwords do not match', 'error');
        return;
    }

    const urlParams = new URLSearchParams(window.location.search);
    const payload = {
        token: urlParams.get('token'),
        email: urlParams.get('email'),
        password: password.value,
        password_confirmation: password_confirmation.value
    };

    if (!payload.token || !payload.email) {
        showMessage(elements.errorContainer, "Invalid reset URL", 'error');
        return;
    }

    elements.submitButton.disabled = true;

    const response = await resetPassword(payload);

    if (response) {
        showMessage(elements.errorContainer, 'Password reset successful!', 'success');
        elements.form.reset();
    } else {
        showMessage(elements.errorContainer, "Reset password failed", 'error');
    }

    elements.submitButton.disabled = false;
});

document.addEventListener('DOMContentLoaded', async () => {
    if (isAuthenticated()) {
        window.location.replace('/');
    }
});
