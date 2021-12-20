window.onload = () => {
    // gestion des boutons supprimer
    let links = document.querySelectorAll("[data-delete]");
    // On boucle sur links

    for (link of links) {
        link.addEventListener("click", function(e) {

            //  On empêche la navigation
            e.preventDefault();

            // On demande la confirmation

            if (confirm("Voulez-vous supprimer cette image ?")) {
                // On envoie une requête Ajax vers le href du lien avec la methode DELETE
                fetch(this.getAttribute("href"), {
                    method: "DELETE",
                    headers: {
                        'x-Requested-with': "XMLHttpRequest",
                        'Content-Type': "application/json"
                    },
                    body: JSON.stringify({ "_token": this.dataset.token })


                }).then(
                    // On récupère la reponse en JSON
                    response => response.json()
                ).then(data => {
                    if (data.success) {
                        this.parentElement.remove();

                    } else {
                        alert(data.error);
                    }
                }).catch(e => alert(e));

            }
        })

    }
}