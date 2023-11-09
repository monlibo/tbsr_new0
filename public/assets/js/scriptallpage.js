$(document).ready(function () {
    $("#registration_form_agent").change(function (e) {
        e.preventDefault();


        fetch('/inscriptionselect', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                registration_form_agent: $("#registration_form_agent").val()
            })
        })
            .then(response => {

                if (!response.ok) {
                    throw new Error('La requête a échoué');
                }

                return response.json();
            })
            .then(data => {

                console.log('Données récupérées avec succès :', data);
            })
            .catch(error => {

                console.error('Erreur de requête :', error);
            });

    });

    $('label + ul').each(function () {
        // Pour chaque label + ul, ajoutez la classe text-danger à chaque li
        $(this).find('li').addClass('alert alert-danger fw-semibold ');
    });
});