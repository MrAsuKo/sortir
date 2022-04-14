
let rue = document.getElementById('rue');
let longitude = document.getElementById('longitude');
let latitude = document.getElementById('latitude');


document.getElementById('sortie_lieu').addEventListener('click', (event) => {

    let lieu = document.getElementById('sortie_lieu');



    lieuSortie = lieu.value;

        $.ajax(
            {
                url:'/lieu/' + lieuSortie ,
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
    let ville = document.getElementById('sortie_ville');
    let lieu = document.getElementById('sortie_lieu');

    villeSortie = ville.querySelector('option:checked').innerText.toLowerCase()
    villeSortie = ville.value;


    $.ajax(
        {
            url:'/ville/' + villeSortie ,
            method:'GET'
        }
    )
        .done(
            (donnees) => {

                cp.innerText = donnees.ville[0];
                console.log(donnees.lieuxNoms[0]);
                console.log(lieu.innerHTML);
                let nbrLieux = donnees.lieuxNoms.length;

                lieu.innerHTML = '';
                for( let i=0; i < nbrLieux; i++)
                {
                    lieu.innerHTML += `<option value="${donnees.lieuxId[i]}">${donnees.lieuxNoms[i]}</option>"`
                }

                rue.innerText = '';
                longitude.innerText = '';
                latitude.innerText = '';

            }
        )
        .fail()
        .always();
})