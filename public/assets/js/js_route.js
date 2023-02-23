$(function()
{


//Abonnement expirer 
$('.abnExpire').click(function()
{
Swal.fire({
            title: "Abonnement Expiré",
            text: "Veuillez renouvellez votre abonnement pour avoir accès à nouveau aux fonctionnalités",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "rgba(149, 150, 141, 0.69)" ,
            cancelButtonText: "retour",
            confirmButtonText: "Renouvellez!",
            backdrop: "rgba(237, 36, 9,0.5)",
         }).then((result) => {
                                if (result.value) 
                                {
                                     $('#main_content').load('updForfait'); 
                                }
                            })




})


//Premiere connection au site
$('.firstLog').click(function()
{
Swal.mixin({
  input: 'text',
  confirmButtonText: 'Suivant &rarr;',
  cancelButtonText: 'Annuler',
  showCancelButton: true,
  progressSteps: ['1', '2']
}).queue([
  {
    title: 'Nouveau mot de passe',
    text: 'Changement obligatoire du mot de passe'
  },
  'Confirmer le mot de passe',
]).then((result) => {
  if (result.value) {
    var answers = result.value
    if(answers[0] === answers[1])
    {
        const ipAPI = '/mbo/updPass?pass='+answers[1];

        Swal.queue([{
          title: 'Changement de mot passe',
          confirmButtonText: 'Oui, Changer',
          text:'Votre mot de passe sera changé par le nouveau saisi !',
          showLoaderOnConfirm: true,
          preConfirm: () => {
            return fetch(ipAPI)
              .then(response => response.json())
              .then(data => updPassOk())
              .catch(() => {
                Swal.insertQueueStep({
                  icon: 'error',
                  title: 'Erreur de connexion !!!'
                })
              })
          }
        }])
    }
    else
    {
        Swal.fire({
          icon: 'error',
          title: 'Mot de passe non identique',
          showConfirmButton: true,
          confirmButtonText: 'Retour',
        })
    }
  }
})

})


//Message de succes du changement de mot de passe
    function updPassOk()
    {
        Swal.fire({
                      icon: 'success',
                      title: 'Mot de passe changer avec succès',
                      showConfirmButton: true,
                      confirmButtonText: 'ok',
                      timer: 3000,
                      timerProgressBar: true,
                    });
       setTimeout(function(){  window.location.href= '/login'; }, 1000);
    }

//Option non actifi
$('.navChoix').click(function()
{
Swal.fire({
            title: "Accès non autorisé",
            text: "Veuillez passée au forfait supérieur pour bénéficier de cette fonctionnalité",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "rgba(149, 150, 141, 0.69)" ,
            cancelButtonText: "Retour",
            confirmButtonText: "Forfait supérieur!",
            backdrop: "rgba(220, 229, 34,0.5)",
         }).then((result) => {
                                if (result.value) 
                                {
                                     $('#main_content').load('updForfait'); 
                                }
                            })




})

/*--------- -----------------
TABLEAU DE BORD 
-----------------------------*/

    /******************* 
    **  A suprimer    **
    ********************
    //arrivage en attente





/*-----------------------
 menu Fournisseur
-------------------------*/
    // Nouveau
     $("#p_newF").click(function(){
                    loadingScreen();
            $('#main_content').load("/p_newF");
     });

     // List Fournisseur

     $("#p_listF").click(function(){
                    loadingScreen();
            $('#main_content').load("/p_listF");
     });

    // Echeance
     $("#p_Eche").click(function(){
                    loadingScreen();
            $('#main_content').load("/p_Eche");
     });
   
/*-----------------------
 menu Opérateur
-------------------------*/
    // Nouveau
     $("#p_Opera").click(function(){
            loadingScreen();
            $('#main_content').load("/p_Opera");
     });

    // Stock
     $("#p_OperaStock").click(function(){
                    loadingScreen();
            $('#main_content').load("/p_OperaStock");
     });

    // Nouvelles opérations
     $("#p_OpComd").click(function(){
         loadingScreen();
         $('#main_content').load("/p_OpComd");
     });

    // Liste 
    $("#p_OpListe").click(function(){
         loadingScreen();
         $('#main_content').load("/p_OpListe");
     });




/*--------- -----------------
 GESTION DES PROSPECTS
-----------------------------*/
    // Nouveau
     $("#p_prospNew").click(function(){
                     loadingScreen();
            $('#main_content').load("/p_prospNew");
     });

    // Analyse
     $("#p_prospStat").click(function(){
                     loadingScreen();
            $('#main_content').load("/p_prospStat");
     });

    // Besoins
     $("#p_prospbesoin").click(function(){
                     loadingScreen();
            $('#main_content').load("/p_prospbesoin");
     });

    // Relance SMS
    $("#p_RelSMS").click(function(){
                     loadingScreen();
            $('#main_content').load("/p_RelSMS");
    });

    // Liste des prospects
    $("#p_prospL").click(function(){
                     loadingScreen();
            $('#main_content').load("/p_prospL");
    });

/*--------- -----------------
 CAMPAGNE MARKETING
-----------------------------*/
    // Nouveau
    $("#CampgNew").click(function(){
        loadingScreen();
      $("#main_content").load("/CampgNew");
    });



    // Liste
    $("#CampgList").click(function(){
        loadingScreen();
      $("#main_content").load("/CampgList");
    });

/*--------- -----------------
 GESTION DES COMMANDES
-----------------------------*/
    // Nouveau
    $("#CommdNew").click(function(){
        loadingScreen();
      $("#main_content").load("/CommdNew");
    });
    
     $("#CommdNewF").click(function(){
        loadingScreen();
      $("#main_content").load("/CommdNew");
    });

    // Liste
    $("#CommdLvr").click(function(){
        loadingScreen();
      $("#main_content").load("/CommdLvr");
    });

/*--------- ------------
 SETING DU COMPTE
------------------------*/

    // Config Param
    $("#setting").click(function(){
        loadingScreen();
      $("#main_content").load("/setting");
    });


/*--------- ------------
 GESTION DE LA SUCCURSALE
------------------------*/
//dashboard dune succursale
$('#dashSucu').click(function()
{
  $('#s_stock').click(); 
});



/*--------- ------------
 GESTION DE L'ABONNEMENT
------------------------*/
//Info Abonnement
$('#abonmt').click(function()
{
    loadingScreen();
    $('#main_content').load('myAbonmnt'); 
});

// Gestion de crédit sms
 $("#sms_credit").click(function(){
   loadingScreen();
   $('#main_content').load('sms_credit'); 
 });



});





