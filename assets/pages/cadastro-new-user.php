<?php 
    include_once __DIR__. "/../layouts/style.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Brasyst</title>
</head>
<body>
<section class="vh-100">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="../src/img/wallpaper-front-site.jpg"
                class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">

                <form>
                    <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                        <p class="lead fw-normal mb-0 me-3">Cadastro</p>
                    </div>

                    <div class="divider d-flex align-items-center my-4">
                    </div>

                    <div class="form-outline mb-4">
                        <input type="text" id="nome" required class="form-control form-control-lg nome"
                        placeholder="Nome completo" />
                        <label class="form-label" for="nome">Nome</label>
                    </div>

                    <div class="form-outline mb-4">
                        <input type="email" id="email" required class="form-control form-control-lg email"
                        placeholder="Email completo" />
                        <label class="form-label" for="email">Email</label>
                    </div>

                    <div class="form-outline mb-3">
                        <input type="password" id="senha" required name="senha" class="form-control form-control-lg "
                        placeholder="Senha de acesso" />
                        <label class="form-label" for="senha">Senha</label>
                    </div>

                    <div class="form-outline mb-3">
                        <input type="password" id="confirma_senha" required name="confirma_senha" class="form-control form-control-lg "
                        placeholder="Repita sua senha" />
                        <label class="form-label" for="confirma_senha">Confirme sua senha</label>
                    </div>

                    <div class="form-outline mb-3">
                        <select id="estado" required name="estado" class="form-control form-control-lg "
                        placeholder="Repita sua senha">
                                <option selected disabled value="">Selecione</option>
                                <option value="AC">Acre</option>
                                <option value="AL">Alagoas</option>
                                <option value="AP">Amapá</option>
                                <option value="AM">Amazonas</option>
                                <option value="BA">Bahia</option>
                                <option value="CE">Ceará</option>
                                <option value="DF">Distrito Federal</option>
                                <option value="ES">Espírito Santo</option>
                                <option value="GO">Goiás</option>
                                <option value="MA">Maranhão</option>
                                <option value="MT">Mato Grosso</option>
                                <option value="MS">Mato Grosso do Sul</option>
                                <option value="MG">Minas Gerais</option>
                                <option value="PA">Pará</option>
                                <option value="PB">Paraíba</option>
                                <option value="PR">Paraná</option>
                                <option value="PE">Pernambuco</option>
                                <option value="PI">Piauí</option>
                                <option value="RJ">Rio de Janeiro</option>
                                <option value="RN">Rio Grande do Norte</option>
                                <option value="RS">Rio Grande do Sul</option>
                                <option value="RO">Rondônia</option>
                                <option value="RR">Roraima</option>
                                <option value="SC">Santa Catarina</option>
                                <option value="SP">São Paulo</option>
                                <option value="SE">Sergipe</option>
                                <option value="TO">Tocantins</option>
                                <option value="EX">Estrangeiro</option>
                        </select>
                        <label class="form-label" for="confirma_senha">Selecione seu estado</label>
                    </div>

                    <div class="text-center text-lg-start mt-4 pt-2">
                        <button  type="button" class="btn btn-primary btn-lg btn_enviar_formulario_cadastro"
                        style="padding-left: 2.5rem; padding-right: 2.5rem;">Entrar</button>
                        <p class="small fw-bold mt-2 pt-1 mb-0">Possui conta? <a href="../../index.php" class="link-danger">Logar</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
</body>
<script>
        let btn_envia_formulario    = $('.btn_enviar_formulario_cadastro');

        btn_envia_formulario.on('click', function() {

            let valida = true;

            $('form input').each(function() {
                if ($(this).val() == '') {
                    $(this).css('border', '1px solid red');
                    valida = false;
                } else {
                    $(this).css('border', '');
                }
            });

            if(!valida) return;

            let senha                   = $('#senha').val();
            let confirma_senha          = $('#confirma_senha').val();
            let email                   = $('#email').val();
            let estado                  = $('#estado').val();
            let nome                    = $('#nome').val();

            if(!email.includes('@') || !email.includes('.')){
                Swal.fire('Erro','Seu email não é um email válido','error');
                return;
            }

            if(senha != confirma_senha){
                Swal.fire('Erro','Suas senhas não são compativeis','error').then(()=>{
                    return;
                })
            }

            if(!estado){
                Swal.fire('Erro','Você não selecionou um estado','error').then(()=>{
                    return;
                })
            }

            Swal.fire({
                title: "Está certo disso?",
                text: "Você será cadastrado no nosso sitema teste",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Cadastrar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url:"../controller/user/cadastro.php",
                            method:'POST',
                            data:{
                                'email' : email,
                                'senha' : senha,
                                'estado': estado,
                                'nome'  : nome
                            },
                                success:function(response){
                                    if(response.status == 200){
                                        Swal.fire('Sucesso',response.msg,'success').then(()=>{
                                            $('#senha').val('');
                                            $('#confirma_senha').val('');
                                            $('#email').val('');
                                            $('#estado').val('');
                                            $('#nome').val('');
                                        });
                                    }else if(response.status == 400){
                                        Swal.fire('erro',response.msg,'error');
                                    }
                                },
                                error:function(erro){
                                    console.log(erro);
                                }
                        })
                    }else{
                        Swal.fire('Desistiu?','Tudo bem, reveja suas informações antes de prosseguir','warning');
                    }
            });
            
        });
</script>
</html>