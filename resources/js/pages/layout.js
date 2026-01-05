import { logout, isAuthenticated } from "../auth.js";

const eventsButton = document.getElementById('events-button');
const helpdeskButton = document.getElementById('helpdesk-button');
const logoutButton = document.getElementById('logout-button');

if (isAuthenticated()) {
    eventsButton.classList.remove('hidden');
    helpdeskButton.classList.remove('hidden');
    logoutButton.classList.remove('hidden');
}

logoutButton.addEventListener('click', async (e) => {
    e.preventDefault();

    await logout();

    window.location.href = '/login';
});
