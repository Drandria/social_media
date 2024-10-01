function pub_template(element) {

    let template = `
        <div class="pub-head">
            <h2 class="username">${element.username}</h2>
            <p class="date">${element.created_at}</p>
        </div>
        <p class="content">
            ${element.contenu}
        </p>
        <div class="stat">
            <p class="like-nbr">like <span class="sum-pub-like">${element.reaction}</span></p>
            <p class="comment">comment <span class="sum-pub-comm">${element.comment}</span></p>
        </div>
        <div class="action">
            <button class="like like-pub" value=${element.id}>Like</button>
        </div>

        <div class="comment-section" id=${element.id}>
            <form class="comment-form">
                <input type="hidden" name="id_publication" value="${element.id}" class="hidden">
                <textarea name="contenu" id="contenu" placeholder="Ecrire ici votre texte" class="contenu-comm publication"></textarea>
                <button type="submit" class="submit">Comment</button>
            </form>
            <div class="comment-container"></div>
        </div>
    `

    let selector = ".pub-container > .pub" + element.id

    const pub = document.querySelector(selector)

    pub.innerHTML = template
}

function com_template(element) {

    let template = `
        <div class="comment-head">
            <h3 class="username">${element.username}</h3>
            <p class="date">${element.date_heure}</p>
        </div>
        <p class="content">
            ${element.contenu}
        </p>
        <div class="stat">
            <p class="like-nbr">like <span class="sum-pub-like">${element.reaction}</span></p>
        </div>
        <div class="action">
            <button class="like like-comment" value="${element.id}">Like</button>
        </div>
    `
    let selector = ".comment-container > .comm" + element.id
    const comm = document.querySelector(selector)

    comm.innerHTML = template
}