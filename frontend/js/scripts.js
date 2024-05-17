document.addEventListener('DOMContentLoaded', function() {
    loadBulletins();

    const addBulletinForm = document.getElementById('addBulletinForm');
    addBulletinForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const title = document.getElementById('title').value;
        const content = document.getElementById('content').value;

        addBulletin(title, content);
    });
});

function loadBulletins() {
    fetch('http://localhost:8080/get')
        .then(response => response.json())
        .then(data => {
            const bulletinContainer = document.getElementById('bulletinContainer');
            bulletinContainer.innerHTML = ''; 

            data.forEach(bulletin => {
                const bulletinDiv = document.createElement('div');
                bulletinDiv.classList.add('bulletin');

                const titleHeader = document.createElement('h3');
                titleHeader.textContent = bulletin.title;

                const contentParagraph = document.createElement('p');
                contentParagraph.textContent = bulletin.content;

                bulletinDiv.appendChild(titleHeader);
                bulletinDiv.appendChild(contentParagraph);

                bulletinContainer.appendChild(bulletinDiv);
            });
        })
        .catch(error => console.error('Ошибка при загрузке объявлений:', error));
}

function addBulletin(title, content) {
    fetch('/create', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ title, content })
    })
    .then(response => {
        if (response.ok) {
            loadBulletins(); 
        } else {
            console.error('Ошибка при добавлении объявления');
        }
    })
    .catch(error => console.error('Ошибка при добавлении объявления:', error));
}

// function deleteBulletin(bulletinId) {
//     fetch('/delete_bulletin', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json'
//         },
//         body: JSON.stringify({ id: bulletinId })
//     })
//     .then(response => {
//         if (response.ok) {
//             loadBulletins(); 
//         } else {
//             console.error('Ошибка при удалении объявления');
//         }
//     })
//     .catch(error => console.error('Ошибка при удалении объявления:', error));
// }
