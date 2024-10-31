<?php include_once __DIR__. "../../layouts/style.php";?>
<script src="../js/global.js"></script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <div >
        <?php include_once __DIR__."/../layouts/menu.php";?>
        <div class="p-4 text-center">
            <h2>Parabéns você acabou de logar</h2>
            <h5>Algumas informações sobre você</h5>
            <h6 class="inf_user"></h6>
        </div>
    </div>

</body>
<script>
    const userData = JSON.parse(sessionStorage.getItem('auth'));
    setTimeout(() => {
        $('.inf_user').html(`Seu nome é ${userData.nome} <br>
        Email: ${userData.email}`)
    }, 1000);
</script>
</html>