<?php 

include_once __DIR__ . "/../../model/user/user.php";


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
    validarCampo('estado', 'Estado não enviado');
    validarCampo('nome', 'Nome não enviado');

    $userModel  = new User();

    $email  = $_POST['email'];
    $senha  = password_hash($_POST['senha'],PASSWORD_DEFAULT);
    $estado = $_POST['estado'];
    $nome   = $_POST['nome'];

    $array_user_infos = [
        'email' => $email,
        'senha' => $senha,
        'nome'  => $nome,
        'estado'=> $estado
    ];

    $cadastro   = $userModel->cadastro_novo_usuario($array_user_infos);

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