async function session() {
    try {
        const response = await fetch('/script/php/session.php');
        const result = await response.json();
        console.log(result);
        return result.status === "active";
    } catch (error) {
        console.error("Erreur lors de la vérification de la session :", error);
        return false;
    }
}


async function like(like_button, link) {

    const data = {
        id_ref: parseInt(like_button.value)
    };

    fetch(link, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json' 
        },
        body: JSON.stringify(data) 
    })
    .then(response => response.json()) 
    .then(resultat => {
        console.log('Succès :', resultat); 
    })
    .catch(erreur => {
        console.error('Erreur :', erreur);
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
                                <p class="like-nbr">like ${element.reaction}</p>
                            </div>
                            <div class="action">
                                <button class="like like-comment" value="${element.id}">Like</button>
                            </div>
                        </div>
                    `
                    comment.innerHTML += content
                }
            })
        })

        const like_button_com = document.querySelectorAll('.like-comment')
    
            like_button_com.forEach(element => {
                element.addEventListener('click', () => like(element,"/script/php/reaction_comment.php"))
            })

    })
}