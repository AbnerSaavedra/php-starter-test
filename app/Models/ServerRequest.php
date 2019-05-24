<?php 
namespace App\models;
use Curl\Curl;

class ServerRequest{

	function callAPI($method, $url, $data){

   $curl = new Curl();

   switch ($method){

      case 'GET':
         
         $curl->get($url, $data);
         return $this->validarResponse($curl);
         break;

      case "POST":

         $curl->post($url, $data);

          break;
      }
   }

   function validarResponse($curl){

      if ($curl->error) {
            return $response = $curl;
         } else {
             // echo 'Response:' . "\n";
             // var_dump($curl->response);
             if ($curl->response->data) {
               $response = $curl->response->data;
                return $response;
             }
         }

   }

}