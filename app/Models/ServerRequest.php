<?php 
namespace App\models;
use Curl\Curl;

class ServerRequest{

	function callAPI($method, $url, $data){

   $curl = new Curl();

   switch ($method){
    case 'GET':
      $curl->get($url, $data);
      return $this->validarResponse($curl, "GET");
      break;
    case "POST":
      $curl->post($url, $data);
      return $this->validarResponse($curl, "POST");
      break;
    case "PUT":
      $curl->put($url, $data);
      return $this->validarResponse($curl, "PUT");
      break;
    case "DELETE":
      $curl->delete($url, $data);
      return $this->validarResponse($curl, "DELETE");
      break;
  }
}
  function validarResponse($curl, $method){

    if ($curl->error) {
      return $response = $curl;
    } else {
     if ($curl->response->data) {
       $response = $curl->response->data;
       return $response;
     }
   }
   if($method === "POST") {
    echo 'Data server received via POST:' . "\n";
    var_dump($curl->response->form);
   }
 }

}
