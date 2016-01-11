$(document).ready(function(){
   $("#connexion").validate({
      rules: {
         nomUtilisateur: {
            required: true,
         },
         motDePasse: {
            required: true,
         },
      },
         messages: {
            nomUtilisateur: {
               required: "Entrez votre nom d'utilisateur"
            },
            motDePasse: {
               required: "Entrez votre mot de passe"
            },     
         }
     });
});