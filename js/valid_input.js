function vldEmail(inpt) //valider un email
{
    email = inpt.value;//la valeur de l'email saisie
    
    
    
    if(!/^[a-z0-9._-]+@[a-z09._-]+$/.test(email)){
            setTimeout(function(){
                alert('votre email est invalide');
                document.getElementById('email_go').focus();
            },0);
    }
}

function vldMinChar(inpt,min)//on vérifie que le mot de passe continent plus de 6 caractères
{
    var nb_caractere = inpt.value.length;
    if(nb_caractere  < min)
        {
            alert('le champ remplit dois avoir un minimum de  ' + min +' caracteres !');
            setTimeout(function(){
                document.getElementById('valid_min').focus();
            },0);
        }
}





