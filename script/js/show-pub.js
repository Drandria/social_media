async function loadPage() {
    let isActive = await session()

    if (isActive) {
        fetch('/script/php/publication.php')
        .then(res => res.json())
        .then(data => {
            console.log(data)
    
            const main = document.querySelector('main')
    
            data.forEach(element => {
                let content = `
                    <div class="container" value=${element.id}>
                        <div class="pub-head">
                            <h2 class="username">${element.username}</h2>
                            <p class="date">${element.created_at}</p>
                        </div>
                        <p class="content">
                            ${element.contenu}
                        </p>
                        <div class="stat">
                            <p class="like-nbr">like ${element.reaction}</p>
                            <p class="comment">comment ${element.comment}</p>
                        </div>
                        <div class="action">
                            <button class="like like-pub" value=${element.id}>Like</button>
                        </div>
    
                        <div class="comment-container" id=${element.id}>
                            <form action="/script/php/comment.php" method="post">
                                <input type="hidden" name="id_publication" value="${element.id}">
                                <textarea name="contenu" id="contenu" placeholder="Ecrire ici votre texte" class="publication"></textarea>
                                <input type="submit" value="Comment">
                            </form>
                        </div>
                    </div>
                `
    
                main.innerHTML += content
            })
    
            get_comment()
    
            const like_button = main.querySelectorAll('.like-pub')
    
            like_button.forEach(element => {
                element.addEventListener('click', () => like(element,"/script/php/reaction.php"))
            })
    
        })
    } else {
        window.location.href = '/page/login.html'
    }
}

document.addEventListener('DOMContentLoaded', function () {
    loadPage()
})