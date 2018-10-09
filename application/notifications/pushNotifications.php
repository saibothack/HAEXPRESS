<?php 
require_once('../configuration/config.php');


$message = $arrayNotification['mensaje'];
$title = $arrayNotification['mensaje'];
$path_to_fcm = 'https://fcm.googleapis.com/fcm/send';
$keyToken = getTokenUsr($arrayNotification['idDriver']);
$server_key = 'AIzaSyAxT23FSOzpUAOUPXoI9TcfkWG0STTaUoE';

$headers = array( 
    'Authorization:key=' . $server_key,
    'Content-Type:application/json',
    'Content-Length: 0' 
    );


$fields = array(‘to’=>$keyToken, notification’=>array(‘title’=>$title, ‘body’=>$message));

$payload = json_encode($fields);
// Abrir la sesión
$curl_session = curl_init();
// Definir la URL a la que se le hará el post
curl_setopt($curl_session, CURLOPT_URL, $path_to_fcm);
// Indicar el tipo de petición: POST
curl_setopt($curl_session, CURLOPT_POST, TRUE);
curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
// Recibimos una respuesta y la guardamos en una variable
curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
$remote_server_output = curl_exec($curl_session);
curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURLOPT_IPRESOLVE_v4);
// Definir cada uno de los parámetros
curl_setopt($curl_session, CURLOPT_POSTFIELDS, $payload);
//$result = curl_exeec($curl_session);
mysqli_close($con);
// Cerrar la sesion
curl_close($curl_session);
// Mostrar el resultado
print_r($remote_server_output);