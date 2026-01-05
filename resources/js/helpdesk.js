import { request } from './api';

async function createQuestion(question) {
    return request('POST', '/messages', {
        question,
    });
}

async function fetchMessages() {
    return request('GET', '/messages');
}

export {
    createQuestion,
    fetchMessages,
};
