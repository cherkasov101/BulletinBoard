document.addEventListener('DOMContentLoaded', function() {
    const authForm = document.getElementById('authForm');
    authForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        fetch('http://localhost:8080/auth', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ username, password })
        })
        .then(response => {
            if (response.ok) {
                alert('Авторизация успешна!');
                window.location.href = 'http://localhost:8080/';
            } else {
                response.json().then(data => {
                    alert('Ошибка авторизации: ' + data.message);
                });
            }
        })
        .catch(error => console.error('Ошибка при авторизации:', error));
    });
});
