document.addEventListener('DOMContentLoaded', function() {
    const regForm = document.getElementById('regForm');
    regForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        fetch('http://localhost:8080/reg', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ username, password })
        })
        .then(response => {
            if (response.ok) {
                alert('Регистрация успешна!');
                window.location.href = 'http://localhost:8080/'; // Перенаправление на главную страницу
            } else {
                response.json().then(data => {
                    alert('Ошибка регистрации: ' + data.message);
                });
            }
        })
        .catch(error => console.error('Ошибка при регистрации:', error));
    });
});
