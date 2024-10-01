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


async function like(like_button, link, div) {

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

        let selector = "." + div + resultat.id + " .sum-pub-like"
        document.querySelector(selector).textContent = resultat.count
    })
    .catch(erreur => {
        console.error('Erreur :', erreur);
    });
}


async function get_comment() {
    fetch('/script/php/get_comment.php')
    .then(response => response.json())
    .then(result => {

        result.forEach(element => {
            let selector = ".pub" + element.id_publication + " .comment-container"
            let className = "comm" + element.id

            document.querySelector(selector).innerHTML += `<div class="comment-element ${className}"></div>`

            com_template(element)
        })

        attachCommentLikeListeners()       

    })
}

function attachCommentLikeListeners() {
    const like_button_com = document.querySelectorAll('.like-comment');

    like_button_com.forEach(element => {
        element.addEventListener('click', () => like(element, "/script/php/reaction_comment.php", "comm"));
    });
}

async function publication() {
    fetch('/script/php/publication.php')
    .then(res => res.json())
    .then(data => {
        const pub_container = document.querySelector('.pub-container')
        pub_container.innerHTML = ""

        data.forEach(element => {
            let className = "pub" + element.id

            pub_container.innerHTML += `<div class="container ${className} "></div>`

            pub_template(element)
        })
        attachPublicationLikeListeners()
        handleCommentSubmissions()
    })
}

function attachPublicationLikeListeners() {
    const like_buttons = document.querySelectorAll('.like-pub');

    like_buttons.forEach(button => {
        button.addEventListener('click', () => like(button, '/script/php/reaction.php', "pub"))
    });
}

async function publish (content) {
    const data = {
        contenu: content
    }

    fetch('/script/php/publish.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json' 
        },
        body: JSON.stringify(data) 
    })
    .then(response => response.json()) 
    .then(resultat => {
        console.log('Succès :', resultat);

        publication()
    })
    .catch(erreur => {
        console.error('Erreur :', erreur);
    });
}

async function comment (content, id_pub) {
    const data = {
        contenu: content,
        id_publication : id_pub
    }

    fetch('/script/php/comment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json' 
        },
        body: JSON.stringify(data)
    })
    .then (response => response.json())
    .then (resultat => {

        let select = ".pub" + id_pub + " .sum-pub-comm"
        document.querySelector(select).textContent = resultat.length

        let selector = ".pub" + id_pub + " .comment-container"
        const comm_container = document.querySelector(selector)

        comm_container.innerHTML = ""

        resultat.forEach(element => {
            let className = "comm" + element.id
            document.querySelector(selector).innerHTML += `<div class="comment-element ${className}"></div>`
            
            com_template(element)
        });
        attachCommentLikeListeners()

    })
    .catch(erreur => {
        console.error('Erreur :', erreur);    
    }) 
}

function handleCommentSubmissions() {
    const comment_form = document.querySelectorAll('.comment-form')

        comment_form.forEach(element => {

            element.addEventListener('submit', function (event) {
                event.preventDefault()

                let contenu = element.querySelector('.contenu-comm').value
                let id_pub = parseInt(element.querySelector('.hidden').value)

                comment(contenu, id_pub)
            })
        });
}