<?php 

include_once __DIR__ . "/../../model/user/user.php";
require "../../../vendor/autoload.php";


header('Content-Type: application/json; charset=utf-8');


$status_code        = 200;
$array_user_infos   = [];



function validarCampo($campo, $mensagem) {
    if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
        throw new Exception($mensagem);
    }
}

try {

    validarCampo('email', 'Email não enviado');
    validarCampo('senha', 'Senha não enviada');

    $userModel  = new User();

    $email  = filter_input(INPUT_POST,'email', FILTER_SANITIZE_EMAIL);
    $senha  = filter_input(INPUT_POST,'senha', FILTER_SANITIZE_STRING);

    $array_user_infos = [
        'email' => $email,
        'senha' => $senha,
    ];

    $login   = $userModel->login($array_user_infos);

    if($login['status'] == 401){
        http_response_code(401);
    }else if( $login['status'] == 200){
        $retorno = [
            'msg' => $login['msg'],
            'status' => $status_code
        ];
    }

} catch (Exception $e) {

    // Somente para debug
    // $retorno = [
    //     'msg' => $e->getMessage(),
    //     'status' => 400
    // ];
    http_response_code(401);
}

echo json_encode($retorno);

?>