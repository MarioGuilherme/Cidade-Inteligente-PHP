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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropDownAdmin" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Admin
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="usuarios">
                                Usuários
                            </a>
                            <a class="dropdown-item" href="cursos">
                                Cursos
                            </a>
                            <a class="dropdown-item" href="areas">
                                Áreas
                            </a>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropDownProject" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Projetos
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="<?= ENVIRONMENT->URL ?>">
                        Todos os <br> Projetos
                    </a>
                    <?php if (App\Utils\Session::isLogged()) : ?>
                        <?php if(\App\Utils\Session::isAdmin()) : ?>
                            <a class="dropdown-item" href="criar-projeto">
                                Cadastrar <br> Projeto
                            </a>
                        <?php endif ; ?>
                        <a class="dropdown-item" href="meus-projetos">
                            Meus Projetos
                        </a>
                    <?php endif ; ?>
                </div>
            </li>
            <?php if (App\Utils\Session::isLogged()) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="services/logout">
                        Sair
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
            <?php else : ?>
                <li class="nav-item">
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