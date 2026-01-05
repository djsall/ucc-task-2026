import {fetchEvents, createEvent, updateEvent, deleteEvent} from '../events.js';
import {isAuthenticated} from "../auth.js";
import {showMessage} from "./common.js";

const elements = {
    form: document.getElementById('form'),
    list: document.getElementById('list'),
    idField: document.getElementById('item-id'),
    nameField: document.getElementById('name'),
    descriptionField: document.getElementById('description'),
    submitButton: document.getElementById('submit'),
};

let events = [];

function escapeHTML(string) {
    const div = document.createElement('div');
    div.textContent = string;
    return div.innerHTML;
}

async function syncEvents() {
    const response = await fetchEvents();
    events = response.data;
    render();
}

function render() {
    if (events.length === 0) {
        elements.list.innerHTML = `<li class="text-center p-4">No events found.</li>`;
        return;
    }

    elements.list.innerHTML = events.map(event => `
        <li class="flex border mb-2 items-center justify-between p-2">
            <div>
                <strong>${escapeHTML(event.name)}</strong>
                <p class="text-sm text-gray-600">${escapeHTML(event.description || '')}</p>
            </div>
            <div class="flex gap-2">
                <button data-id="${event.id}" data-action="edit" class="btn-edit">Edit</button>
                <button data-id="${event.id}" data-action="delete" class="btn-delete text-red-500">Delete</button>
            </div>
        </li>
    `).join('');
}

elements.form.addEventListener('submit', async (event) => {
    event.preventDefault();
    const id = elements.idField.value;
    const payload = {
        name: elements.nameField.value,
        description: elements.descriptionField.value
    };

    elements.submitButton.disabled = true;

    try {
        if (id) {
            await updateEvent(id, {description: payload.description});
        } else {
            await createEvent(payload);
        }

        elements.form.reset();
        elements.idField.value = '';
        elements.nameField.disabled = false;
        await syncEvents();
    } finally {
        elements.submitButton.disabled = false;
    }
});

elements.list.addEventListener('click', async (event) => {
    const id = event.target.dataset.id;
    const action = event.target.dataset.action;

    if (!id) return;

    if (action === 'edit') {
        const item = events.find(i => i.id == id);
        if (item) {
            elements.idField.value = item.id;
            elements.nameField.value = item.name;
            elements.nameField.disabled = true;
            elements.descriptionField.value = item.description;
            elements.descriptionField.focus();
        }
    }

    if (action === 'delete') {
        if (confirm('Delete this event?')) {
            await deleteEvent(id);
            await syncEvents();
        }
    }
});

document.addEventListener('DOMContentLoaded', async () => {
    if (!isAuthenticated()) {
        window.location.href = '/login';
        return;
    }

    await syncEvents();
});
