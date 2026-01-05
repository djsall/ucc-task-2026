import { request } from './api';

async function fetchEvents() {
    return request('GET', '/events');
}

async function createEvent(data) {
    return request('POST', '/events', data);
}

async function updateEvent(id, data) {
    return request('PUT', `/events/${id}`, data);
}

async function deleteEvent(id) {
    return request('DELETE', `/events/${id}`);
}

export {
    fetchEvents,
    createEvent,
    updateEvent,
    deleteEvent,
};
