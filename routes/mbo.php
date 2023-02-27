<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| MBO Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*-------------------
        A SAVOIR 
--------------------*/
  /*
   ***********************************
    * La gestion de la Principales*
    ---------------
     la principale est une succursale
     mais qui est gerer par les admin
     de la plateformes. Elle a plus de
     droit et d'option ques les autres
     succursale. !!! Elle porte le ID
     1 de la table succursales. La 
    selection des succursales est donc
    privée de l'ID 1 (reserve plutôt a
    la principale). !!!!!!!!!!!!!!!!
   ************************************
  */


/*--------------------------
  GESTION DES ARRIVAGES
----------------------------*/

    //Ajouter / faire un new arrivage
    Route::get('addArriv','p_ArrivController@addArriv')->name('addArriv');

    //liste produit arrivage en cour
        Route::get('lArrivPrd','p_ArrivController@lArrivPrd')->name('lArrivPrd');

    //Suprimer arrivage
       Route::get('deleteArriv','p_ArrivController@deleteArriv');

    //Suprime un produit de l'arrivage
       Route::get('delArrivPrd','p_ArrivController@delArrivPrd');

    //Enregistre arrivage
       Route::get('saveArriv','p_ArrivController@saveArriv')->name('saveArriv');

    //Arrivages en attente
       Route::get('arrivAttn','p_ArrivController@arrivAttn')->name('arrivAttn');

    //Edition des Arrivages 
       Route::post('editArriv','p_ArrivController@editArriv')->name('editArriv');

    //Suprimer un prduit d'une vente de la principales
       Route::get('delPrdArriv','p_ArrivController@delPrdArriv'); 

        //Mettre a jour un prduit d'une vente de la principales
       Route::get('updPrdArriv','p_ArrivController@updPrdArriv'); 

       //Detail Arrivage
       Route::get('detailArriv','p_ArrivController@detailArriv')->name('detailArriv');

       // Validation d'un Arrivages
       Route::get('arrivValid','p_ArrivController@arrivValid')->name('arrivValid');

       // Supression d'un Arrivages
       Route::get('arrivDel','p_ArrivController@arrivDel')->name('arrivDel');

       //Arrivages validés
       Route::get('arrivOk','p_ArrivController@arrivOk')->name('arrivOk'); 

       //Enregistre produit arrivage
        Route::post('saveArrivPrd','p_ArrivController@saveArrivPrd')->name('saveArrivPrd');
        //list arrivage ** remove for version 2
       // Route::get('listArriv','p_ArrivController@listArriv')->name('listArriv');

       //update arrivage
       Route::get('updArriv','p_ArrivController@updArriv')->name('updArriv');


/*--------------------------
  GESTION DES APPROVISIONN
----------------------------*/
       //Page d'appprovisionnement
        Route::get('/approvi', 'ApprovisionnementController@approvi')->name('approvi');

       //save aprovi Produits
        Route::post('/addPrdAprovi', 'ApprovisionnementController@addPrdAprovi');

       //Liste  Prd de l'Aprovisionement
        Route::get('/listAproviPrd', 'ApprovisionnementController@listAproviPrd');

        //Delete  article of Aprovisionement 
          Route::get('/delAproviPrd','ApprovisionnementController@delAproviPrd');
        
        //Delete   Aprovisionement 
         Route::get('/delAprovi', 'ApprovisionnementController@delAprovi' );

        //Save produit de l'approvisionnement
         Route::get('/saveAprovi', 'ApprovisionnementController@saveAprovi' );

        //liste des'approvisionnement
         Route::get('/listAprovi', 'ApprovisionnementController@listAprovi' );

         //Liste approvisionnent produit 
          Route::get('/approviList', 'ApprovisionnementController@approviList' );

         //Approvisionnement Recu
          Route::get('/aprovRecu', 'ApprovisionnementController@aprovRecu' );
         
         //Tous les produits de la boutique
          Route::get('/allPrd', 'ApprovisionnementController@allPrd' );

          



/*--------------------------
  GESTION DES SUCCURSALES
----------------------------*/

      //Stock d'une succursale
        Route::post('/stockSuc','GestionSuccursaleController@stockSuc');

      //Creer une succursale
        Route::get('/addSuc','GestionSuccursaleController@addSuc')->name('addSuc');

      //Enregistrer une succursale
        Route::post('/saveSuc','GestionSuccursaleController@saveSuc')->name('saveSuc');

      //Lister les succursales
        Route::get('/listSuc','GestionSuccursaleController@listSuc');

      //Mis a jour des succursales
        Route::post('/UpdSuc','GestionSuccursaleController@UpdSuc');

      //DELETE SUCCURSALE
        Route::get('/delSuc','GestionSuccursaleController@delSuc')->name('delSuc');

        // Listes versement
         Route::get('/p_LVer', 'p_VersController@p_LVer')->name('p_LVer');

        // Generer un rapport  versement
         Route::get('/rapportSuc', 'p_VersController@rapportSuc');

        //Lancer lanalyse du rapport de versement
         Route::post('/rapAnlyz', 'p_VersController@rapAnlyz');

        //Ajouter une demande de  versement  
         Route::get('/addVers', 'p_VersController@addVers');

        //enregistrement du paiement
         Route::post('/payVers', 'p_VersController@payVers');

        //Historiques des paiements
         Route::get('/histPayVers','p_VersController@histPayVers');

        //Suprimer des versements
         Route::get('/delVers','p_VersController@delVers');



/*------------------------------
  GESTION DES PRODUITS & CATGO
-------------------------------*/
        //Afficher liste des categories
       Route::get('lCateg','produitsControl@lCateg')->name('lCateg');

        //Afficher produit trier par categorie
       Route::post('prdByCatg','produitsControl@prdByCatg')->name('prdByCatg');

        //Ajout categorie  
       Route::post('addCatgo','produitsControl@addCatgo')->name('addCatgo');

       //Ajout de produit
      Route::post('/addPrd','produitsControl@addPrd')->name('addPrd');

      //Calculé le Prix de vente  automatiquement
      Route::get('/calPrixAuto','produitsControl@calPrixAuto')->name('calPrixAuto');

      //Delete Produit
      Route::get('/delPrd','produitsControl@delPrd')->name('delPrd');

      //Delete Catégorie
      Route::get('/delCatgo','produitsControl@delCatgo')->name('delCatgo');

      //Search in all produit
      Route::get('/ajaxPrdAll','produitsControl@ajaxPrdAll')->name('ajaxPrdAll');
      




/*---------------------------------
  GESTION DES RESSOURHE HUMAINES
-----------------------------------*/

        //Add employer
          Route::get('/addEmpl','GestionEmployeController@addEmpl')->name('addEmpl');
        
        //liste  employer
          Route::get('/listEmpl','GestionEmployeController@listEmpl');

          //save  employer
          Route::post('ajaxSaveEmpl','GestionEmployeController@ajaxSaveEmpl');

          //Update Acces Employer
          Route::post('updAcces','GestionEmployeController@updAcces');

          //delete  employer
          Route::get('ajaxDelEmpl','GestionEmployeController@ajaxDelEmpl');

          //Edit  employer
          Route::post('editEmpl', 'GestionEmployeController@editEmpl');

          //update  employer
          Route::post('UpdEmpl', 'GestionEmployeController@UpdEmpl');

          //update  employer
          Route::get('updPass', 'GestionEmployeController@updPass');
          //Demetre les access
          Route::get('delAllAcces','GestionEmployeController@delAllAcces');


/*-----------------------
  GESTION INTERFACES
-------------------------*/
          



/*-----------------------------------
  GESTION DES ALERTES & NOTIFICATION
-------------------------------------*/

      //Notification de demande de versement 
      Route::get('alertVers', 'GestionAlertController@alertVers');
      




    /*--------- --------------------------
        GESTION DES VENTES PRINCIPALES
    --------------------------------------*/
        //Faire une vente
       Route::get('venteP','GestionVentePrincipalController@venteP')->name('venteP');

       //enregistre un prd d'une vente
        Route::post('/savePrdAchatP','GestionVentePrincipalController@savePrdAchatP' );

        //Liste des produits de l'achat 
        Route::get('/lPrdAchat','GestionVentePrincipalController@lPrdAchat' );

        //Suprimer la vente en session 
        Route::get('/delAchat','GestionVentePrincipalController@delAchat');

        //Suprimer un produit de la vente en session 
        Route::get('/delPrdAchat','GestionVentePrincipalController@delPrdAchat');

        //Enregistrer la vente en session 
        Route::get('/saveAchat','GestionVentePrincipalController@saveAchat');

        //Mis a jour d'une vente / achat
        Route::get('/updAchat','GestionVentePrincipalController@updAchat');

        //Mis a jour d'une vente / achat
        Route::get('/validVnt','GestionVentePrincipalController@validVnt');
        

       //liste des ventes de la principale
       Route::get('lventeP','GestionVentePrincipalController@lventeP'); 

       //liste des ventes en facture proformat de la principale
       Route::get('lfactuProP','GestionVentePrincipalController@lfactuProP'); 

       //Detail de la vente
       Route::get('ajaxDetailVntP','GestionVentePrincipalController@ajaxDetailVntP');

       //Suprime Vente
       Route::get('delVntP','GestionVentePrincipalController@delVntP')->name('delVntP');

       //Suprimer toutes  Vente
       Route::get('delAllVntP','GestionVentePrincipalController@delAllVntP');

       //Editer une vente de la principales
       Route::post('editVntP','GestionVentePrincipalController@editVntP'); 

       //Suprimer un prduit d'une vente de la principales
       Route::get('delPrdVnt','GestionVentePrincipalController@delPrdVnt'); 

       //Update un produit de la vente
       Route::get('updPrdVnt','GestionVentePrincipalController@updPrdVnt'); 
       


       

       //Recu de la vente
       Route::get('recuVntP','GestionVentePrincipalController@recuVntP')->name('recuVntP');

       //Recup produit de la principal 
       Route::get('ajaxRecupPrdP','GestionVentePrincipalController@ajaxRecupPrdP');


 //Recup produit de la principal 
       Route::get('ajaxRecupPrdPTest','GestionVentePrincipalController@ajaxRecupPrdPTest');

        //Facture proformat => Vente  
       Route::get('factVnt','GestionVentePrincipalController@factVnt')->name('factVnt');

       //Stock de la principale
       Route::get('/stockP', 'GestionVentePrincipalController@stockP')->name('stockP');


    /*----------------------
      Gestion des clients
     ------------------------*/
        // Ajout client
         Route::post('AddClt','GestionClient@AddClt')->name('AddClt');

        // Delete client
         Route::get('/delClt','GestionClient@delClt')->name('delClt');

        //Updtate client 
         Route::post('/UpdClt','GestionClient@UpdClt')->name('UpdClt');


        //CLient succursales liste
          Route::get('/s_Client', 'GestionClient@listClt')->name('listClt');

        //Liste Achat d'un CLient de la succursales
          Route::get('/listAchatClt', 'GestionClient@listAchatClt')->name('listAchatClt');



    /*----------------------
      Appel ajax  nécessaire
     ------------------------*/
    //Formater un prix en Ajax
          Route::get('/formatPriceJs', 'abonmntControl@formatPriceJs');



    /*----------------------
      Génération de reçu
     ------------------------*/
          Route::get('/recuVntP', 'GestionVentePrincipalController@recuVntP')->name('recuVntP');



    /*--------- --------------------------
        GESTION DES ARCHIVES
    --------------------------------------*/

    //Ajout de archives
      Route::get('/addDoc', 'GestionArchives@addDoc')->name('addDoc');
    //Liste de archives
      Route::get('/listDoc', 'GestionArchives@listDoc')->name('listDoc'); 
    //Enregster de archives
      Route::post('/saveDoc', 'GestionArchives@saveDoc')->name('saveDoc'); 

    //Enregster Dossier de archives
      Route::get('/saveFolder', 'GestionArchives@saveFolder')->name('saveFolder'); 
      
    //Update my folder 
      Route::post('/updDoc', 'GestionArchives@updDoc')->name('updDoc'); 

    //Delete one or all DOC 
      Route::get('/delDoc', 'GestionArchives@delDoc')->name('delDoc');

    //Consulter le contenue d'un dossier
      Route::get('/viewFolder', 'GestionArchives@viewFolder')->name('viewFolder');

    //Modification deun fichier
      Route::post('/updFile', 'GestionArchives@updFile')->name('updFile'); 
      
    //Delete one or all file 
      Route::get('/delFile', 'GestionArchives@delFile')->name('delFile');
