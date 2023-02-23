function init()
{
    //-------------Configuration
    CinetPay.setConfig({
        apikey: '6820562105ffc56b7257464.26123769',
        site_id: 814773,
        notify_url: 'http://5d451451a1c7.ngrok.io/cinetpay_notify_sms'
    });

    //-------------Gestion des evenements
    //error
    CinetPay.on('error', function (e) {
        console.error(e);
        Swal.fire({
                  'title': 'Erreur',
                  'icon': 'error',
                  'text': e.message
                });
    });
    //ajax
    CinetPay.on('ajaxStart', function () {
        document.getElementById('bt_get_signature').setAttribute('disabled', 'disabled');
    });
    CinetPay.on('ajaxStop', function () {
        document.getElementById('bt_get_signature').removeAttribute('disabled');
    });
    //Lorsque la signature est généré
    CinetPay.on('signatureCreated', function (token) {
        console.log('Tocken généré: ' + token);
    });
    CinetPay.on('paymentPending', function (e) {
        console.log("paiement en cours");
    });
    CinetPay.on('paymentSuccessfull', function (paymentInfo) {
        if (typeof paymentInfo.lastTime != 'undefined') {
            if (paymentInfo.cpm_result == '00') {
                Swal.fire({
                  'title': 'Paiement validée !',
                  'icon': 'success',
                  'text': 'Mercie, Votre solde sera actif dans quelques instants '
                });
                
            } else {
                Swal.fire({
                  'title': 'Paiement interrompue!',
                  'icon': 'error',
                  'text': paymentInfo.cpm_error_message
                });
               
            }
        }
    });

    // Application des méthodes

        //Lancement de la souscription
        $('.Suscribe_sms').click(function()
        {
          var montant_sms = $("#montant").val();
          if(montant_sms!=0)
          {
            $("#montant").val('');
            const ipAPI = '/suscribe_sms?sms='+montant_sms;
            Swal.queue([{
              title: 'Système de paiement',
              confirmButtonText: 'Payez maitenant',
              text:'Le système de paiement est en cours de chargement',
              showLoaderOnConfirm: true,
              preConfirm: () => {
                return fetch(ipAPI)
                 .then(response => response.json())
                 .then(data => testMe(data))
                 .catch(() => {
                   Swal.insertQueueStep({
                     icon: 'error',
                     title: 'Erreur de connexion !!!'
                   })
                  })
              }
            }])
          }
        });

    // Méthode
    function testMe(data)
    {
      /* console.log(data);*/
      CinetPay.setSignatureData({
       amount: parseInt(data.amount),
       trans_id: data.trans_id,
       currency: 'XOF',
       designation: data.designation,
       custom: ''
      });
      CinetPay.getSignature();
    }


}