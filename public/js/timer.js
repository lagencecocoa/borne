var h = $('#h').text(); // Heure
var m = $('#m').text(); // Minute
var s =$('#s').text(); // Seconde

var temps; // Contiendra l'exécution de notre code 
var bo = true; // Permettra de contrôler l'exécution du code

function dchiffre(nb)
{
    if(nb < 10 && nb > 0) // si le chiffre indiqué est inférieurs à dix ...
    {
        nb = nb; 
    }
     
    return nb;
}

jQuery("#start").click(function()
{
    if(bo) // On controle bo pour savoir si un autre Intervalle est lancé
    {
        temps = setInterval(function()
        {
            s++;
             
            if(s > 59)
            {
                m++;
                s = 0;
            }
             
            if(m > 59)
            {
                h++;
                m = 0;
            }
             
            jQuery("#s").html(dchiffre(s));
            jQuery("#m").html(dchiffre(m));
            jQuery("#h").html(dchiffre(h));
             
             
        },1000);
         
                // On affecte false à bo pour empécher un second Intervalle de se lancer
        bo = false; 
    }
});
jQuery("#pause").click(function()
{
     
    clearInterval(temps); // On stop l'intervalle lancer
     
       // On affiche les variable dans les conteneur dédié
    jQuery("#s").html(dchiffre(s));
    jQuery("#m").html(dchiffre(m));
    jQuery("#h").html(dchiffre(h));
     
       // Affecter true a bo pour indiquer qu'il n'y a plus d'Intervalle actif
    bo = true
});