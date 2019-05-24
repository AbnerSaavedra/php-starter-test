<?php 
namespace App\models;

use Curl\Curl;

class ServerRequest{

	function callAPI($method, $url, $data){
   $curl = curl_init();

   switch ($method){
      case "POST":
         curl_setopt($curl, CURLOPT_POST, 1);
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         break;
      case "PUT":
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
         break;
      default:
         if ($data)
            $url = sprintf("%s?%s", $url, http_build_query($data));
   }

   // OPTIONS:
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'APIKEY: 111111111111111111111',
      'Content-Type: application/json',
   ));
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

   // EXECUTE:
   $result = curl_exec($curl);
   if(!$result){die("Connection Failure");}
   curl_close($curl);
   return $result;
}

}

//From: https://www.weichieprojects.com/blog/curl-api-calls-with-php/

// $curl = new Curl();
         // $curl->get('https://auth.dev.graphs.social/v4/login', array(
         //     'email' => $postData['email'],
         //     'password' => $postData['password'],
         //     'application_id' => $postData['appId']
         // ));

//    if ($curl->error) {
      //       //echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
      //       $responseMessage = "Ha ocurrido un error: . $curl->errorCode . ': ' . $curl->errorMessage";
      //    } else {
      //        echo 'Response:' . "\n";
      //        var_dump($curl->response);
      //        //echo($curl->response->data->access_token);
      //        if ($curl->response->data->access_token) {

      //           $access_token = $curl->response->data->access_token;
      //           $curl->get('https://api.dev.graphs.social/v4/graphs', array(
      //           'access_token' => $access_token ));

      //             if ($curl->error) {

      //                echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";

      //             } else {

      //                 echo 'Response:' . "\n";
      //                 var_dump($curl->response);
      //                // return new RedirectResponse('posts');
      //        }
            
      //    } else{
      //          $responseMessage = "Ha ocurrido un error: " . $curl->response->data->text;
      //       return $this->renderHTML('login.twig', [
      //       'responseMessage' => $responseMessage]);
      //        }
      // }