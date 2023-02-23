<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


  //Interface de connexion
    Route::get('/', function () {return redirect('/login');});

  //Route Systeme d'authentifiaction
    Auth::routes(['register'=>false]);

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/dashboard', 'HomeController@index')->name('dashboard');
    Route::get('/smspromo', 'HomeController@smspromo')->name('smspromo');


/*--------------------------
  GESTION DU PAIEMENT CINETPAY
----------------------------*/
  // Achat sms_marketing
  Route::match(["get","post"],"/cinetpay_notify",
    "CampController@cinetpay_notify")->name('cinetpay.notify');

  // Abonnement Meneya
  Route::match(["get","post"],"/cinetpay_notify_abonment",
    "abonmntControl@cinetpay_notify_abonment")
  ->name('cinetpay_notify_abonment');

  // Rechargement sms
  Route::match(["get","post"],"/cinetpay_notify_sms",
    "abonmntControl@cinetpay_notify_sms")
  ->name('cinetpay_notify_sms');







/*--------------------------
  GESTION DES ABONNEMENT PAGE
----------------------------*/
    // Forfait expirer
     Route::get('forfaitDown', 'abonmntControl@forfaitDown');

    //Alert mail expiration de forfait
     Route::get('alertAbonmnt','abonmntControl@alertAbonmnt');
    // Update du forfait
     Route::get('updForfait', 'abonmntControl@updForfait');

    // Info Abonnement
     Route::get('myAbonmnt', 'abonmntControl@myAbonmnt');

    //Lancement de la tentative de souscription
     Route::get('suscribe','abonmntControl@suscribeTry');

    // Gestion de crédit sms
      Route::get('sms_credit','abonmntControl@sms_credit');

    // Rechargement de sms
     Route::get('suscribe_sms','abonmntControl@suscribe_sms');
/*--------------------------
  GESTION DE CAMPAGNE PUB
----------------------------*/
    // Page de campagne
     Route::get('/camp', 'CampController@camp')->name('camp');

    // Acheter un produit
     Route::get('/comd', 'CampController@comd')->name('comd');



/*--------------------------
  GESTION DES OPERATEURS
----------------------------*/
  /*
   *******************
    * Cas pratique*
    ---------------
     Une personne depose une somme d'argent
     pour une ou plusieurs opérations données.
     Il faut suivre les sorties et la solvabilité
     de l'operation de l'opérateur en question.
   ********************
  */
        //Opérateur => Formulaire de création
         Route::get('/p_Opera', 'p_OperaController@p_Opera')->name('p_Opera');

        // Opérateur => Nouveau
         Route::post('/p_AddOpera', 'p_OperaController@p_AddOpera')->name('p_AddOpera');

        // Opérateur => Liste
         Route::get('p_OpListe','p_OperaController@p_OpListe')->name('p_OpListe');

        // Opérateur => Suppression
         Route::get('p_OpDele','p_OperaController@p_OpDele')->name('p_OpDele');

        // Opérateur => Modification phase 1
          Route::get('p_OpUpd','p_OperaController@p_OpUpd')->name('p_OpUpd');

        // Opérateur => Modification phase 2
          Route::get('p_OpUpval','p_OperaController@p_OpUpval')->name('p_OpUpval');

        // Opérateur => Opération
          Route::match(["get","post"],"p_OpTion",
            'p_OperaController@p_OpTion')->name('p_OpTion');

        // Opérateur => Modification phase 2
         Route::get('p_OperaUpd2','p_OperaController@p_OperaUpd2')->name('p_OperaUpd2');

        // Affectation d'opérations à un opérateur
         Route::get('p_opeOpNew','p_OperaController@p_opeOpNew')->name('p_opeOpNew');

        //Liste des sorties de l'operateur
         Route::match(["get","post"],'p_listeSortie','p_OperaController@p_listeSortie')->name('p_listeSortie');
         Route::get('p_opRecuSorti','p_OperaController@p_opRecuSorti')->name('p_opRecuSorti');



        // Suppression d'une sortie
         Route::get('p_SortieDel','p_OperaController@p_SortieDel')->name('p_SortieDel');

        // Suppression d'un produit lié à une sortie
         Route::get('delPrd','p_OperaController@delPrd')
              ->name('delPrd');


        // Sortie => Effectuer une sortie pour l'opérateur
          Route::post('p_OpSortie','p_OperaController@p_OpSortie')->name('p_OpSortie');


        //Sortie => Suppression de produits
          Route::get('suprPrdSortie','p_OperaController@suprPrdSortie');

        // Nouvelle sortie
        Route::post('savePrdSortie','p_OperaController@savePrdSortie')->name('savePrdSortie');

        // Liste produit de sortie Operateur
         Route::match(["get","post"],'/listeSortiPrd',
                      'p_OperaController@listeSortiPrd')
               ->name('listeSortiPrd');

        // Vider le panier de la sortie
        Route::get('suprSortie','p_OperaController@suprSortie')->name('suprSortie');

        // Enregistrer la sortie d'une opération
         Route::get('saveSortie','p_OperaController@saveSortie')->name('saveSortie');

        //Ajout credit operation
         Route::get('addCredit','p_OperaController@addCredit')->name('addCredit');

        // Story de paiement des crédits liées une opération
         Route::get("story","p_OperaController@story")->name("story");

        // Détails d'une sortie liée à une operation
          Route::get('p_opDet','p_OperaController@p_opDet')->name('p_opDet');



        //opération => Liste
         Route::get('/p_OpComd', 'p_OperaController@p_OpComd')->name('p_OpComd');

        // Opération => Nouvelle
         Route::post('/p_AddOperation','p_OperaController@p_AddOperation')->name('p_AddOperation');
         Route::get('p_opetNew','p_OperaController@p_opetNew')->name('p_opetNew');

        // Opération => Suppression
         Route::get('p_cmdDOp','p_OperaController@p_cmdDOp')->name('p_cmdDOp');

        // Opération  => Modification Phase 1
         Route::get('p_OperaUpd','p_OperaController@p_OperaUpd')->name('p_OperaUpd');

        // Supprimer une opération liée à l'opérateur
         Route::get('p_OptnDel','p_OperaController@p_OptnDel')->name('p_OptnDel');

/*--------------------------
  GESTION DES PROSPECTS
----------------------------*/
  /*
   *******************
    * Cas pratique*
    ---------------
     Un propspect est une personne qui vient prendre des
     rensignements sur un produit sans acheter.
     L'objectif est de faire une prospection automatque.
   ********************
  */
        // Nouveau => Formulaire  prospect
         Route::get('p_prospNew','p_prospController@p_prospNew')->name('p_prospNew');

        // Suppression globale des prospects
         Route::get('p_DelPAll','p_prospController@p_DelPAll')
                ->name('p_DelPAll');

        // Suppression globale des besoins
                Route::get('p_DelBesAll','p_prospController@p_DelBesAll')
                      ->name('p_DelBesAll');

        // Liste des prospects
         Route::get('p_prospL','p_prospController@p_prospL')->name('prospect');

        // Analyse statistique
         Route::get('p_prospStat','p_prospController@p_prospStat')->name('p_prospStat');

        // Besoins
         Route::get('p_prospbesoin','p_prospController@p_prstBesoin')->name('p_prstBesoin');

        // Relance SMS
          Route::get('p_RelSMS','p_prospController@p_RelSMS')->name('p_RelSMS');

        // Ajouter
         Route::get('p_AddPros','p_prospController@p_AddPros')->name('p_AddPros');

        // Bésoins
         Route::get('p_PrBes','p_prospController@p_PrBes')->name('p_PrBes');

        // Affectation de prospect-besoins
         Route::get('p_besoL','p_prospController@p_besoL')->name('p_besoL');

        // Supprimer
          Route::get('p_DelP','p_prospController@p_DelP')->name('p_DelP');

        // SMS
          Route::get('ProsSMS','p_prospController@ProsSMS')->name('ProsSMS');

        // Modification
          Route::get('p_PrUpd','p_prospController@p_PrUpd')->name('p_PrUpd');
          Route::get('prosUp','p_prospController@prosUp')->name('prosUp');

        // Suppression de besoins
         Route::get('p_DelPB','p_prospController@p_DelPB')->name('p_DelPB');

        // Modification de besoins | prosBUp
          Route::get('p_PrUpdB','p_prospController@p_PrUpdB')->name('p_PrUpdB');
          Route::get('prosBUp','p_prospController@prosBUp')->name('prosBUp');
          Route::get('p_besAdd','p_prospController@p_besAdd')->name('p_besAdd');

        // Analyse des besoins-prospects
         Route::get('statBes','p_prospController@statBes')->name('statBes');

        // SMS Prospect
         Route::get('ReProsSMS','p_prospController@ReProsSMS')->name('ReProsSMS');




/*--------------------------
  CAMPAGNE MARKETING
----------------------------*/
  /*
   *******************
    * Cas pratique*
    ---------------
     La campagne marketing consiste à faire une campagne SMS
     aux clients: Toute personne ayant effectué déjà un achat.
   ********************
  */
    // Nouveau
     Route::get('CampgNew','p_CampMarkController@CampgNew')->name('CampgNew');

    // SMS Promotionnel
     Route::post('smsPro','p_CampMarkController@smsPro')->name('smsPro');

    // Liste
     Route::get('CampgList','p_CampMarkController@CampgList')->name('CampgList');

    // SMS Marketing unique
     Route::get('sendUniqSMS','p_CampMarkController@sendUniqSMS')->name('sendUniqSMS');

    // Campagne marketing groupé
       Route::get('sendNSMS','p_CampMarkController@sendNSMS')->name('sendNSMS');

    // Vider l'historique des sms
     Route::get('emptySMS','p_CampMarkController@emptySMS')->name('emptySMS');

/*--------------------------
  MES COMMANDES
----------------------------*/
  // Nouvelle commandes
   Route::get('CommdNew','p_CampMarkController@CommdNew')->name('CommdNew');

  //Listes des commandes
   Route::get('CommdLvr','p_CampMarkController@CommdLvr')->name('CommdLvr');

  // Suppression d'une commande
   Route::get('ComdDel','p_CampMarkController@ComdDel')->name('ComdDel');

  // Livrer une commande
   Route::get('ComdLiv','p_CampMarkController@ComdLiv')->name('ComdLiv');

  // Détails d'une commandes
   Route::get('comdShow','p_CampMarkController@comdShow')->name('comdShow');

  // Supprimer toutes les commandes
   Route::get('p_DelCdAll','p_CampMarkController@p_DelCdAll')->name('p_DelCdAll');













/*--------------------------
  FOURNISSEUR
----------------------------*/
  /*
   *******************
    * Cas pratique*
    ---------------
     Le fournisseur est une personne qui fourni ou ravitaille votre structure en produit
     IL vous faut suivre leur paiement et le niveau de leur solvabilité
   ********************
  */
    // Nouveau
     Route::get('/p_newF', 'p_FourniController@p_newF')->name('p_newF');

    // List Fournisseur
     Route::get('/p_listF', 'p_FourniController@p_listF')->name('p_listF');

    // Ajouter
     Route::post('/p_AddF','p_FourniController@p_AddF')->name('p_AddF');

    // Supprimer un fournisseur
     Route::get('/delFour', 'p_FourniController@delFour')->name('delFour');

    // Fournisseur => Update
     Route::post('/editF', 'p_FourniController@editF')->name('editF');
     Route::post('/updateF', 'p_FourniController@updateF')->name('updateF');

    // Fournisseur => Echeance consulter
     Route::post('/showFour','p_FourniController@showFour')->name('showFour');

    // Echeance
     Route::get('/p_Eche', 'p_FourniController@p_Eche')->name('p_Eche');
     Route::post('/EcheFour','p_FourniController@EcheFour')->name('EcheFour');
     Route::get('/delEch','p_FourniController@delEch')->name('delEch');
     Route::get('/p_EchOK','p_FourniController@p_EchOK')->name('p_EchOK');

    // Historique du fournisseur
     Route::get("histEch",'p_FourniController@histEch')->name('histEch');

/*--------- -----------------
        GESTION DES ARRIVAGES
-----------------------------*/
        //Ajout arrivage
    // Route::get('addArriv','p_ArrivController@addArriv')->name('addArriv');

       //Enregistre produit arrivage
    // Route::post('saveArrivPrd','p_ArrivController@saveArrivPrd')->name('saveArrivPrd');



/*
|--------------------------------------------------------------------------
| MENU DE GESTION DES INTERFACES FONCTIONNELLES SUCCURSALES
|--------------------------------------------------------------------------
|
| Ici nous gérons les routes du menu
|
*/

        Route::get('/appSuc','GestionSuccursaleController@appSuc')->name('appSuc');

        // Enregistrement de la commande
         Route::match(["get","post"],'/s_Vente',
                      's_VenteController@s_Vente')
               ->name('s_Vente');

        // Formulaire Ajout d'une vente
          Route::get('/Addvente', 's_VenteController@Addvente')->name('Addvente');

       //Recup produit de la principal
       Route::get('ajaxRecupPrdSuc','s_VenteController@ajaxRecupPrdSuc');

       //enregistre un prd d'une vente
        Route::post('/savePrdAchatSuc','s_VenteController@savePrdAchatSuc' );

        //Liste des produits de l'achat
        Route::get('/lPrdAchat','s_VenteController@lPrdAchat' );

        //Suprimer la vente en session
        Route::get('/delAchatSuc','s_VenteController@delAchatSuc');
        //Suprimer un produit de la vente en session
        Route::get('/delPrdAchatSuc','s_VenteController@delPrdAchatSuc');

        //Enregistrer la vente en session
        Route::get('/saveAchatSuc','s_VenteController@saveAchatSuc');

       //Recu de la vente
       Route::get('recuVntSuc','s_VenteController@recuVntSuc')->name('recuVntSuc');


        //Validation d'une facture proformat
        Route::get('/validVntSuc','s_VenteController@validVntSuc');

       //Editer une vente de la principales
       Route::post('editVntSuc','s_VenteController@editVntSuc');

       //Suprimer un prduit d'une vente de la principales
       Route::get('delPrdVntSuc','s_VenteController@delPrdVntSuc');

      //Mis a jour d'une vente / achat
        Route::get('/updAchatSuc','s_VenteController@updAchatSuc');

      //Suprime Vente
       Route::get('delVntSuc','s_VenteController@delVntSuc')->name('delVntSuc');

       //Detail de la vente
       Route::get('ajaxDetailVntSuc','s_VenteController@ajaxDetailVntSuc');


    /*----------------
        Credit succurcales
     -------------------*/
        // Liste credit
          Route::get('/s_credits','s_CreditController@s_credits')->name('s_credits');

        //Historique paiement d'un credit

          Route::get('/histCrd','s_CreditController@histCrd')->name('histCrd');


        //Payer un credit
          Route::post('/s_payCrd','s_CreditController@s_payCrd')->name('s_payCrd');

        //Suprimer credit
          Route::get('/delCrd','s_CreditController@delCrd')->name('delCrd');

        //Succursale ajoute credit
          Route::post('/s_addCrd','s_CreditController@s_addCrd')->name('s_addCrd');


    /*--------- --------------------------
        SETTING DU COMPTE USER
    ----------------------------------------*/
        //Afficher form de config
       Route::get('setting','SettingController@setting')->name('setting');

        //Mis a jour de l'utilisateur
       Route::post('updUser','SettingController@updUser')->name('updUser');

       //Mis a jour des taxes
       Route::post('updTaxe','SettingController@updTaxe')->name('updTaxe');

       //Mis a jour des seuil d'alertes
       Route::post('updAlert','SettingController@updAlert')->name('updAlert');

       //Mis a du resume des parametres
       Route::get('lSetting','SettingController@lSetting')->name('lSetting');

       // Mise à jour sms_key
       Route::post('updSms','SettingController@updSms')->name('updSms');

       // Mise à jour Entreprise
       Route::post('updEntp','SettingController@updEntp')->name('updEntp');
