function showMessage(container, message, type) {
    clearErrors(container);

    container.innerText = message;
    container.className = type === 'success' ? 'text-green-500' : 'text-red-500';
}

function clearErrors(container) {
    container.classList.remove('text-red-500', 'text-green-500');
    container.innerText = '';
}

export {
    showMessage,
    clearErrors,
}
