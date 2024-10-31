<?php 

require "../../../vendor/autoload.php";

use Dotenv\Dotenv;
use Firebase\JWT\JWT;

class ApiJWT{
    public function encode($array){
        $dotenv = Dotenv::createImmutable(dirname(__FILE__,3));
        $dotenv->load();

        $payload = [
            "exp" => time() + 60*5, // 5 minutos autenticado
            "iat" => time(),
            "email" => $array['email'],
            "nome"  => $array["nome"],
            "id"    => $array["id"],
            "estado"=> $array["estado"]
        ];

        $enconde = JWT::encode($payload, $_ENV['KEY'],'HS256');

        return json_encode($enconde);
    }
}