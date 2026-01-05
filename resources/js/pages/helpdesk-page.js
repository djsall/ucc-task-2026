import {fetchEvents, createEvent, updateEvent, deleteEvent} from '../events.js';
import {isAuthenticated} from "../auth.js";
import {clearErrors, showMessage} from "./common.js";
import {fetchMessages, createQuestion} from "../helpdesk.js";

const elements = {
    form: document.getElementById('form'),
    list: document.getElementById('list'),
    idField: document.getElementById('item-id'),
    questionField: document.getElementById('question'),
    submitButton: document.getElementById('submit'),
    errorField: document.getElementById('form-error'),
};

let messages = [];

function escapeHTML(string) {
    const div = document.createElement('div');
    div.textContent = string;
    return div.innerHTML;
}

async function syncMessages() {
    const response = await fetchMessages();
    messages = response.data;
    render();
}

function render() {
    if (messages.length === 0) {
        elements.list.innerHTML = `<li class="text-center p-4">No messages found.</li>`;
        return;
    }

    elements.list.innerHTML = messages.map(message => `
        <li class="flex border mb-2 items-center justify-between p-2 ${message.is_resolved ? 'bg-green-50' : ''}">
            <div>
                <strong>${escapeHTML(message.question)}</strong>
                <p class="text-sm text-gray-600">${escapeHTML(message.answer || '')}</p>
            </div>
            <div>
                Resolved: ${message.is_resolved ? 'yes' : 'no'}
            </div>
        </li>
    `).join('');
}

elements.form.addEventListener('submit', async (event) => {
    event.preventDefault();
    const question = elements.questionField.value;
    if (question.length < 10) {
        showMessage(elements.errorField, 'The question needs to be at least 10 characters long');
    }

    elements.submitButton.disabled = true;

    try {
        await createQuestion(question);

        clearErrors(elements.errorField);
        elements.form.reset();
        await syncMessages();
    } finally {
        elements.submitButton.disabled = false;
    }
});

document.addEventListener('DOMContentLoaded', async () => {
    if (!isAuthenticated()) {
        window.location.href = '/login';
        return;
    }

    await syncMessages();
});
