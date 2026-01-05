import {request, setToken, clearToken} from './api';

async function login(data) {
    const response = await request('POST', '/login', data);

    if (response.token) {
        setToken(response.token);
        return true;
    }

    return false;
}

async function forgotPassword(email) {
    try {
        await request('POST', '/forgot-password', {email});
        return true;
    } catch (error) {
        return false;
    }
}

async function resetPassword(data) {
    try {
        await request('POST', '/reset-password', {
            token: data.token,
            email: data.email,
            password: data.password,
            password_confirmation: data.password_confirmation,
        });

        return true;
    } catch (error) {
        return false;
    }
}

async function logout() {
    await request('POST', '/logout');
    clearToken();
}

function isAuthenticated() {
    return !!localStorage.getItem('token');
}

export {
    login,
    logout,
    isAuthenticated,
    forgotPassword,
    resetPassword,
};
