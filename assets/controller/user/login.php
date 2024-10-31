<?php 

include_once __DIR__ . "/../../model/user/user.php";
include_once __DIR__ . "/../../API/apiJWT.php";


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

    $email  = $_POST['email'];
    $senha  = $_POST['senha'];

    $array_user_infos = [
        'email' => $email,
        'senha' => $senha,
    ];

    $cadastro   = $userModel->login($array_user_infos);

    if($cadastro['status'] == 400){
        throw new Exception($cadastro['msg']);
    }else if( $cadastro['status'] == 200){
        $retorno = [
            'msg' => $cadastro['msg'],
            'status' => $status_code
        ];
    }

} catch (Exception $e) {
    $status_code = 400;
    $retorno = [
        'msg' => $e->getMessage(),
        'status' => $status_code
    ];
}

echo json_encode($retorno);

?>