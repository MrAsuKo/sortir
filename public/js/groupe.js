let boite = document.getElementsByClassName('boite');
let clic = document.getElementsByClassName('clic');


Array.from(clic).forEach(function(element) {
    element.addEventListener('click', () => {

        let interieurBoite = element.parentElement.querySelector('div');
        let titre = element.querySelector('h1');

        if ( interieurBoite.getAttribute('class') ===  'ouvrir')
        {
            interieurBoite.setAttribute('class', "ferme")
            titre.innerHTML = '<h1 class="filter_titre">Filtrer les Sorties <i class="fa-solid fa-arrow-down"></i></h1>'
        }
        else
        {
            interieurBoite.setAttribute('class', 'ouvrir')
            titre.innerHTML = '<h1 class="filter_titre"> Filtrer les Sorties <i class="fa-solid fa-arrow-right"></i> </h1>'
        }



    })
})



