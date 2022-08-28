<nav class="navbar navbar-expand-lg navCity">
    <h4 class="navbar-brand">
        <i class="fas fa-solid fa-city"></i> Cidade Inteligente
    </h4>
    <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-solid fa-bars"></i>
    </button>
    <div id="my-nav" class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <?php if (App\Utils\Session::isLogged()) : ?>
                <?php if(\App\Utils\Session::isAdmin()) : ?>
                    <li class="nav-item active">
                        <div class="dropdown">
                            <a class="nav-link" aria-colcount="dropdown-toggle" id="dropDownAdmin" data-toggle="dropdown" aria-expanded="false" href="#">
                                Admin
                                <i class="fas fa-chevron-up"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropDownAdmin">
                                <li>
                                    <a class="dropdown-item" href="usuarios">
                                        Usuários
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="cursos">
                                        Cursos
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item areas" href="areas">
                                        Áreas
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            <li class="nav-item active">
                <div class="dropdown">
                    <a class="nav-link" aria-colcount="dropdown-toggle" id="dropDownProject" data-toggle="dropdown" aria-expanded="false" href="#">
                        Projetos
                        <i class="fas fa-chevron-up"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropDownProject">
                        <li>
                            <a class="dropdown-item" href="/">
                                Todos os <br> Projetos
                            </a>
                        </li>
                        <?php if (App\Utils\Session::isLogged()) : ?>
                            <?php if(\App\Utils\Session::isAdmin()) : ?>
                                <li>
                                    <a class="dropdown-item" href="criar-projeto">
                                        Cadastrar <br> Projeto
                                    </a>
                                </li>   
                            <?php endif ; ?>
                            <li>
                                <a class="dropdown-item" href="meus-projetos">
                                    Meus Projetos
                                </a>
                            </li>
                        <?php endif ; ?>
                    </ul>
                </div>
            </li>
            <?php if (App\Utils\Session::isLogged()) : ?>
                <li class="nav-item active">
                    <a class="nav-link" href="services/logout">
                        Sair
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
            <?php else : ?>
                <li class="nav-item active">
                    <a class="nav-link btn btn-default-red" href="login">
                        LOGIN
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
<script>
    document.querySelector("a[href='<?= $page->currentNavItem ?>']").classList.add("disabled");
</script>