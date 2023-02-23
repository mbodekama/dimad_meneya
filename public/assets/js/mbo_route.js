$(function()
{



/*--------- -----------------
TABLEAU DE BORD 
-----------------------------*/


            /*--------- -----------------
                GESTION DES ARRIVAGES
            -----------------------------*/

    //Ajout arrivage       
        $('#addArriv').click(function()
        {
              loadingScreen();
            $('#main_content').load('/mbo/addArriv');
        });




    $('#arrivAttn').click(function()
    {
                    loadingScreen();
            $('#main_content').load('/mbo/arrivAttn');
    });
    
    //arrivage valide
    $('#arrivOk').click(function()
    {
                    loadingScreen();
            $('#main_content').load('mbo/arrivOk');
    }); 

    $('#arrivagePrincipal').click(function()
    {
                    loadingScreen();
            $('#main_content').load('mbo/approvi');
    });

//lsit arrivage  ** remove for version 2     

    // $('#listArriv').click(function()
    // {
    //     $('#main_content').load('mbo/listArriv');
    // });

    
//statistique Arrivage
    $('#statArriv').click(function()
    {
                    loadingScreen();
            $('#main_content').load('/dashboard');
    });


    $('#listArrivage').click(function()
    {
                    loadingScreen();
            $('#main_content').load('mbo/listAprovi');
    }); 


    $('#produitsPrincipal').click(function()
    {
                    loadingScreen();
            $('#main_content').load('/mbo/allPrd');
    });


            /*--------- -----------------
                GESTION DES SUCCURSALES 
            -----------------------------*/

    $('#creerSuccursale').click(function()
    {
                    loadingScreen();
            $('#main_content').load('mbo/addSuc');
    });


    $('#listeSuccursale').click(function()
    {
                    loadingScreen();
            $('#main_content').load('mbo/listSuc');
    }); 

/*-----------------------
 onglet Versement
-------------------------*/
    // Rapport de vente
     $("#rapportSuc").click(function(){
                    loadingScreen();
            $('#main_content').load("mbo/rapportSuc");
     });

    // Liste
     $("#p_LVer").click(function(){
                    loadingScreen();
            $('#main_content').load("mbo/p_LVer");
     });



            /*--------- -----------------
                GESTION DES EMPLOYES  PRINCIPALE
            -----------------------------*/

    $('#ajouterEmploye').click(function()
    {
                    loadingScreen();
            $('#main_content').load('mbo/addEmpl');
    }); 


    $('#listeEmploye').click(function()
    {
                    loadingScreen();
            $('#main_content').load('mbo/listEmpl');
    });



            
            /*--------- -----------------
                GESTION DE VENTE PRINCIPALE
            -----------------------------*/
    $('#achatPrincipal').click(function()
    {
                    loadingScreen();
            $('#main_content').load('mbo/venteP');
    });

    $('#liste_ventePrincipal').click(function()
    {
                    loadingScreen();
            $('#main_content').load('mbo/lventeP');
    }); 

    $('#clientPrincipal').click(function()
    {
                    loadingScreen();
            $('#main_content').load('mbo/clientPrincipal');
    });
        
    $('#proformat').click(function()
    {
                    loadingScreen();
            $('#main_content').load('mbo/lfactuProP');
    });

    $('#stockP').click(function()
    {
                    loadingScreen();
            $('#main_content').load('mbo/stockP');
    });


            /*--------- -----------------
                GESTION DES CLIENT P
            -----------------------------*/

    // Clients
     $("#p_client").click(function(){
                    loadingScreen();
      $('#main_content').load('/mbo/s_Client');


     });

            /*--------- -----------------
                GESTION DES CLIENT P
            -----------------------------*/

    // Ajout Archives
     $("#addDoc").click(function()
     {
        loadingScreen();
       $('#main_content').load('/mbo/addDoc');
     });
     
    // Liste Archives
     $("#listDoc").click(function()
     {
        loadingScreen();
       $('#main_content').load('/mbo/listDoc');
     });

});