async function like(like_button) {

    const data = {
        id_publication: parseInt(like_button.value)
    };

    fetch('/script/php/reaction.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json' // Si tu envoies des données JSON
        },
        body: JSON.stringify(data) // Convertit l'objet JavaScript en chaîne JSON
    })
    .then(response => response.json()) // Transforme la réponse en JSON (selon le cas)
    .then(resultat => {
        console.log('Succès :', resultat); // Traite la réponse du serveur
    })
    .catch(erreur => {
        console.error('Erreur :', erreur); // Gère les erreurs
    });
}

async function get_comment() {
    fetch('/script/php/get_comment.php')
    .then(response => response.json())
    .then(result => {
        console.log(result)

        const comment_container = document.querySelectorAll('.comment-container')

        result.forEach(element => {
            comment_container.forEach(comment => {
                if (element.id_publication == parseInt(comment.id)) {
                    let content = `
                        <div class="comment-element">
                            <div class="comment-head">
                                <h3 class="username">${element.username}</h3>
                                <p class="date">${element.date_heure}</p>
                            </div>
                            <p class="content">
                                ${element.contenu}
                            </p>
                            <div class="stat">
                                <p class="like-nbr">like 0</p>
                            </div>
                            <div class="action">
                                <button class="like" value="${element.id}">Like</button>
                            </div>
                        </div>
                    `
                    comment.innerHTML += content
                }
            })
        });
    })
}