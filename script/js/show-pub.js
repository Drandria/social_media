async function loadPage() {
    let isActive = await session()

    if (isActive) {

        const pub_form = document.querySelector('.pub-form')

        pub_form.addEventListener('submit', function (event) {
            event.preventDefault()

            let contenu = document.getElementById('contenu-pub').value
            publish(contenu)
        })

        publication()
        get_comment()


    } else {
        window.location.href = '/page/login.html'
    }
}

document.addEventListener('DOMContentLoaded', function () {
    loadPage()
})