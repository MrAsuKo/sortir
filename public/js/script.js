

document.getElementById('sortie_lieu').addEventListener('change', (event) => {

    let lieu = document.getElementById('sortie_lieu');



    let rue = document.getElementById('rue');
    let cp = document.getElementById('cp');
    let longitude = document.getElementById('longitude');
    let latitude = document.getElementById('latitude');

    lieuUser = lieu.value;

        $.ajax(
            {
                url:'http://127.0.0.1:8000/sortie/lieu/' + lieuUser ,
                method:'GET'
            }
        )

            .done(
                (donnees) => {
                    console.log(JSON.parse(donnees))
                }
            )
            .fail()
            .always();



    }
)


