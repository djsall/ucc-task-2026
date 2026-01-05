const API_BASE_URL = '/api';

function getToken() {
    return localStorage.getItem('token');
}

function setToken(token) {
    localStorage.setItem('token', token);
}

function clearToken() {
    localStorage.removeItem('token');
}

async function request(method, endpoint, data = null) {
    const headers = {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    };

    const token = localStorage.getItem('token');

    if (token) {
        headers['Authorization'] = `Bearer ${token}`;
    }

    const response = await fetch(`${API_BASE_URL}${endpoint}`, {
        method,
        headers,
        body: data ? JSON.stringify(data) : null,
    });

    if (response.status === 204) {
        return null;
    }

    if (response.status === 401) {
        clearToken();
    }

    if (!response.ok) {
        throw await response.json().catch(() => ({}));
    }

    return await response.json();
}

export {
    request,
    setToken,
    clearToken,
};
