fetch('/script/php/publication.php')
.then(res => res.json())
.then(data => {
    console.log(data)

    data.forEach(element => {
        document.body.innerHTML += element.contenu
    })
})