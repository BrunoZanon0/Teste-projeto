<?php 

include_once __DIR__ . "/../../connect/connect.php";
include_once __DIR__ . "/../../API/apiJWT.php";

class User{
    public $table;
    public $conn;
    public function __construct() {
        $this->table = "users";
        $connect = new Connect();
        $this->conn = $connect->conn;
    }

    public function get_user_by_email($email){
        
            $sql_verifica = "SELECT * FROM $this->table WHERE email = ? LIMIT 1";
        
            $stmt = $this->conn->prepare($sql_verifica);
            $stmt->bindParam(1, $email, PDO::PARAM_STR);
        
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }

            return false;
    }

    public function cadastro_novo_usuario($array_user_infos){
        $status_user    = '1';
        $status_code    = 200;

        try {
            $verifica_email = $this->get_user_by_email($array_user_infos['email']);

            if($verifica_email) throw new Exception('O Email já está cadastrado em nosso sistema.'); // VERIFICA SE O EMAIL EXISTE

            $sql_cadastro   = "INSERT INTO $this->table (
                                                email,
                                                nome,
                                                senha,
                                                estado,
                                                status
                                                ) VALUES (
                                                ?, ?, ?, ?, ?
                                                )";

            $stmt = $this->conn->prepare($sql_cadastro);

            $stmt->bindParam(1,$array_user_infos['email'],PDO::PARAM_STR);
            $stmt->bindParam(2,$array_user_infos['nome'],PDO::PARAM_STR);
            $stmt->bindParam(3,$array_user_infos['senha'],PDO::PARAM_STR);
            $stmt->bindParam(4,$array_user_infos['estado'],PDO::PARAM_STR);
            $stmt->bindParam(5,$status_user,PDO::PARAM_INT);

            $result = $stmt->execute();

            if(!$result){
                throw new Exception($stmt->errorInfo());
            }

            $retorno = [
                'msg'       => 'Você foi cadastrado no sistema',
                'status'    => $status_code
            ];
        } catch (Exception $e) {

            $status_code = 400;
            
            $retorno = [
                'msg'       => $e->getMessage(),
                'status'    => $status_code
            ];
        }

        return $retorno;
        
    }

    public function login($array_user_infos){

        $status_code    = 200;
        $msg            = '';

        try {

            $sql_verifica = "SELECT * FROM $this->table WHERE email = ? LIMIT 1";
        
            $stmt = $this->conn->prepare($sql_verifica);

            $stmt->bindParam(1, $array_user_infos['email'], PDO::PARAM_STR);

            if($stmt->execute()){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($row) { 
                    if(password_verify($array_user_infos['senha'], $row['senha'])){
                        $retorno = [
                            'msg'       => 'logou',
                            'status'    => $status_code
                        ];
                    } else {
                        $msg =  'Email ou senha incorreta';
                    }
                } else {
                    $msg = 'Email ou senha incorreta';
                }
            }else{
                throw new Exception($stmt->errorInfo());
            }

            if($msg) throw new Exception($msg);
            
        } catch (Exception $e) {
            $status_code = 400;
            
            $retorno = [
                'msg'       => $e->getMessage(),
                'status'    => $status_code
            ];
        }

        return $retorno;
    }

    public function auth($array_user_infos){
        
    }

}