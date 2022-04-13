$.ajax(
    {
        url:'http://127.0.0.1:8000/sortie/trouve/12',
        method:'GET'
    }
)
    .done(
        (donnees) =>{
            let CodePostal = $(`<p>${donnes.codePostal()}</p>`);
            $('#CP').append(CodePostal);
        }
    )
    .fail()
    .always()
;

/*
function select (){
    console.log('coucou')
    let monElement = document.getElementById('CP');
    let id =document.getElementById('sortie_ville').value;
    monElement.innerText = "Code Postal :" + id;
}
*/