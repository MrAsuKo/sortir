

document.getElementById('sortie_lieu').addEventListener('change', (event) => {

    let lieu = document.getElementById('sortie_lieu');

    let rue = document.getElementById('rue');
    let longitude = document.getElementById('longitude');
    let latitude = document.getElementById('latitude');

    lieuSortie = lieu.value;

        $.ajax(
            {
                url:'http://127.0.0.1:8000/lieu/' + lieuSortie ,
                method:'GET'
            }
        )

            .done(
                (donnees) => {
                    rue.innerText = donnees.lieu[0];
                    longitude.innerText = donnees.lieu[1];
                    latitude.innerText = donnees.lieu[2];
                }
            )
            .fail()
            .always();




    }
)


document.getElementById('sortie_ville').addEventListener('change',(event) => {


    let cp = document.getElementById('cp');
    let ville = document.getElementById('sortie_ville')

    villeSortie = ville.querySelector('option:checked').innerText.toLowerCase()


    $.ajax(
        {
            url:'https://api-adresse.data.gouv.fr/search/?q=' + villeSortie ,
            method:'GET'
        }
    )
        .done(
            (donnees) => {
                console.log(villeSortie);
                cp.innerText = donnees.features[2].properties.postcode;
            }
        )
        .fail()
        .always();
})