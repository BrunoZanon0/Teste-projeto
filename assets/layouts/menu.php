<nav class="navbar navbar-expand-lg navbar-light bg-light p-2 w-100">
    <a class="navbar-brand" href="#">Sistema</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link logout" href="#">Sair</a>
            </li>
        </ul>
    </div>
</nav>

<script>
    $('.logout').on('click',function(){
        localStorage.removeItem('auth');
        localStorage.removeItem('session');

        sessionStorage.removeItem('auth');
        sessionStorage.removeItem('session');

        window.location.href = '/projects/Teste-projeto/index.php';

    })
</script>