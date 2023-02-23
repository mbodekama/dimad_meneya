function init() {

    //-------------Configuration
    CinetPay.setConfig({
        apikey: '6820562105ffc56b7257464.26123769',
        site_id: 814773,
        notify_url: 'https://5d2b9b2f7dfe.ngrok.io/cinetpay_notify'
    });
    //-------------Gestion des evenements
    //error
    CinetPay.on('error', function (e) {
        console.error(e);
        Swal.fire('Une erreur est survenue');
        //var error_div = document.getElementById('error_info');
        //error_div.innerHTML = '';
        //error_div.innerHTML += '<b>Error code:</b>' + e.code + '<br><b>Message:</b>:' + e.message;
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
        //Swal.fire('Paiement en cours <br>');
        //var error_div = document.getElementById('error_info');
        //error_div.innerHTML = 'Paiement en cours <br>';
        //error_div.innerHTML += '<b>code:</b>' + e.code + '<br><b>Message:</b>:' + e.message;
    });
    CinetPay.on('paymentSuccessfull', function (paymentInfo) {
        //var error_div = document.getElementById('error_info');
        //var sucess_div = document.getElementById('success_info');
        if (typeof paymentInfo.lastTime != 'undefined') {
            if (paymentInfo.cpm_result == '00') {
                Swal.fire({
                  'title': 'Commande validée !',
                  'icon': 'success',
                  'text': 'Vous serez livré dans quelques instant'
                });
                //Swal.fire('Paiement succès');
                //error_div.innerHTML = '';
                //sucess_div.innerHTML = 'Votre paiement a été validé avec succès : <br> Montant :' + paymentInfo.cpm_amount + '<br>';
                //trans_id.value = Math.floor((Math.random() * 10000000) + 10000);
            } else {
                //Swal.fire('Une erreur est survenue :' + paymentInfo.cpm_error_message);
                //error_div.innerHTML = 'Une erreur est survenue :' + paymentInfo.cpm_error_message;
                //sucess_div.innerHTML = '';
                Swal.fire({
                  'title': 'Votre commande a echouée !',
                  'icon': 'error',
                  'text': paymentInfo.cpm_error_message
                });

                //console.log(paymentInfo.cpm_error_message);
            }
        }
    });

    //Application des méthodes
    var bt_get_signature = document.getElementById('pay');
    bt_get_signature.addEventListener('click', function () {
         $(".sedPay").show();
         var nom  = $("#nom").val();
         var tel  = $("#tel").val();
         var lieu = $("#lieu").val();
         var qte  = $("#qte").val();
         var idP  = $("#prdId").val();
         if (qte=="") {
           var qte = 1;
         }
         console.log("nom: "+nom+"/ tel:"+tel+" /lieu:"+lieu+" /qte:"+qte+
         " / idPrd:"+idP);
          if (nom!=''&&tel!=''&&lieu!='') {
           $.ajax({
             url:'comd',
             method:'get',
             data:{nom:nom,tel:tel,lieu:lieu,qte:qte,prod:idP},
             dataType:'json',
             success:function(data){
                CinetPay.setSignatureData({
                    amount: data.command.amount,
                    trans_id: data.command.code,
                    currency: 'XOF',
                    designation: data.command.designation,
                    custom: ''
                });
                CinetPay.getSignature();
                $(".sedPay").hide();
             },
             error:function(data){
               Swal.fire({
                  'title': 'Oops...',
                  'icon': 'error',
                  'text': data.responseJSON.message
               });
                $(".sedPay").hide();
               
             }
           });
          }else{
           Swal.fire('Veuillez nous fournir votre addresse de livraison');
            $(".sedPay").hide();
          }
    });
}
