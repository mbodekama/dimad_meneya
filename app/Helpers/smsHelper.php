<?php

use App\Model\produits;

// Helper d'envoie de sms
if(!function_exists('Sendsms'))
{
  function Sendsms($msg,$tel,$sender)
  {
    // Filtrer le messages
         $nvMsg = str_replace('à','a', $msg);
         $nvMsg = str_replace('á','a', $nvMsg);
         $nvMsg = str_replace('â','a', $nvMsg);
         $nvMsg = str_replace('ç','c', $nvMsg);
         $nvMsg = str_replace('è','e', $nvMsg);
         $nvMsg = str_replace('é','e', $nvMsg);
         $nvMsg = str_replace('ê','e', $nvMsg);
         $nvMsg = str_replace('ë','e', $nvMsg);
         $nvMsg = str_replace('ù','u', $nvMsg);
         $nvMsg = str_replace('ù','u', $nvMsg);
         $nvMsg = str_replace('ü','u', $nvMsg);
         $nvMsg = str_replace('û','u', $nvMsg);
         $nvMsg = str_replace('ô','o', $nvMsg);
         $nvMsg = str_replace('î','i', $nvMsg);
         $key = getSettingByName('sms_secret');
         $api = 'Authorization: Bearer '.$key."";
         // Step 1: Créer la campagne
         $curl = curl_init();
         $datas= [
           'step' => NULL,
           'sender' => $sender,
           'name' => 'SMS MENEYA',
           'campaignType' => 'SIMPLE',
           'recipientSource' => 'CUSTOM',
           'groupId' => NULL,
           'filename' => NULL,
           'saveAsModel' => false,
           'destination' => 'NAT_INTER',
           'message' => $msg,
           'emailText' => NULL,
           'recipients' =>
           [
             [
               'phone' => $tel,
             ],
           ],
           'sendAt' => [],
           'dlrUrl' => NULL,
           'responseUrl' => NULL,
         ];
         curl_setopt_array($curl, array(
           CURLOPT_URL => 'https://api.letexto.com/v1/campaigns',
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_ENCODING => '',
           CURLOPT_MAXREDIRS => 10,
           CURLOPT_TIMEOUT => 0,
           CURLOPT_FOLLOWLOCATION => true,
           CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
           CURLOPT_CUSTOMREQUEST => 'POST',
           CURLOPT_POSTFIELDS =>json_encode($datas),
           CURLOPT_HTTPHEADER => array(
             $api,
             'Content-Type: application/json'
           ),
         ));
         $response = curl_exec($curl);
         curl_close($curl);
         $res = json_decode($response);
         $camp_id = $res->id;

         // Step2: Programmer la campagne
         $curl_send = curl_init();
         curl_setopt_array($curl_send, array(
           CURLOPT_URL => 'https://api.letexto.com/v1/campaigns/'.$camp_id.'/schedules',
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_ENCODING => '',
           CURLOPT_MAXREDIRS => 10,
           CURLOPT_TIMEOUT => 0,
           CURLOPT_FOLLOWLOCATION => true,
           CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
           CURLOPT_CUSTOMREQUEST => 'POST',
           CURLOPT_HTTPHEADER => array(
             $api
           ),
         ));
         $response_send = curl_exec($curl_send);
         curl_close($curl_send);
         return $response_send;

         // $curl = curl_init();
         // $datas = [
         //    "email"=>getSettingByName('sms_mail'),
         //    "secret"=>getSettingByName('sms_secret'),
         //    "message"=>$nvMsg,
         //    "receiver"=>$tel,
         //    "sender"=>$sender,
         //    "cltmsgid"=>"1"
         // ];
         // /*$response = $tel.'/';*/
         // curl_setopt_array($curl, array(
         //   CURLOPT_URL => "www.letexto.com/sendCampaign",
         //   CURLOPT_RETURNTRANSFER => true,
         //   CURLOPT_ENCODING => "",
         //   CURLOPT_MAXREDIRS => 10,
         //   CURLOPT_TIMEOUT => 0,
         //   CURLOPT_FOLLOWLOCATION => true,
         //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         //   CURLOPT_CUSTOMREQUEST => "POST",
         //   CURLOPT_POSTFIELDS =>json_encode($datas),
         //   CURLOPT_HTTPHEADER => array(
         //     "Content-Type: application/json",
         //    ),
         // ));
         // $response = curl_exec($curl);
         // curl_close($curl);
         // return $response;
  }
}

// Helper de solde sms
if(!function_exists('soldeSMS'))
{
  function soldeSMS($mail,$key)
  {
    $url = "http://www.letexto.com/get_sold/user/".$mail."/secret/".$key;
    $curl = curl_init();
    curl_setopt_array($curl, array(
     CURLOPT_URL => $url ,
     CURLOPT_RETURNTRANSFER => true,
     CURLOPT_ENCODING => "",
     CURLOPT_MAXREDIRS => 10,
     CURLOPT_TIMEOUT => 30,
     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
     CURLOPT_CUSTOMREQUEST =>"GET",
     CURLOPT_HTTPHEADER => array("cache-control: no-cache"),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    return $response;

  }
}

?>
