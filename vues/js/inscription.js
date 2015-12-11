$(document).ready(function(){
   $("#inscription").validate({
      rules: {
         nomUtilisateur: {
            required: true,
            minlength: 2,
            maxlength: 20
         },
         motDePasse: {
            required: true,
            minlength : 6,
            maxlength: 20
         },
         confMotDePasse:{
            required: true,
            minlength: 6,
            maxlength: 20
         },
         mail: {
            required: true,
            email: true
         },
         confMail: {
            required: true,
            email: true
         },
      },
         messages: {
            nomUtilisateur: {
               required: "Entrez votre nom",
               minlength: "Entrez un nom compris entre 2 et 20 caractères",
               maxlength: "Entrez un nom compris entre 2 et 20 caractères"
            },
            motDePasse: {
               required: "Entrez un mot de passe",
               minlength: "Entrez un mot de passe compris entre 6 et 20 caractères",
               maxlength: "Entrez un mot de passe compris entre 6 et 20 caractères",
            },
            confMotDePasse: {
               required: "Entrez un mot de passe identique",
               minlength: "Entrez un mot de passe compris entre 6 et 20 caractères",
               maxlength: "Entrez un mot de passe compris entre 6 et 20 caractères"
            },
            mail: {
               required: "Entrez une adresse email",
               email: "Votre adresse email doit être sous ce format : xxx@xxx.com"
            }, 
            confMail: {
               required: "Entrez une adresse email",
               email: "Votre adresse email doit être sous ce format : xxx@xxx.com"
            },     
         }
     });
});