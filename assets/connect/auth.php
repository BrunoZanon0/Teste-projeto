<?php 

require "../../vendor/autoload.php";

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With");

use Dotenv\Dotenv;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$dotenv = Dotenv::createImmutable(dirname(__FILE__,3));
$dotenv->load();

$key        = $_SERVER['KEY'];
$headers    = getallheaders();
$token_front= $headers['Authorization'];

$token = str_replace('"', '' , $token_front);

try {
    $decoded = JWT::decode($token, new Key($key, 'HS256'));
    echo json_encode($decoded);

} catch (Throwable $e) {
    if($e->getMessage() == 'Expired token'){
        http_response_code(401);
        die('EXPIRED') ;
    }
}