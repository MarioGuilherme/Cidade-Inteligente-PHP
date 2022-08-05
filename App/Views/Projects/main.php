<div class="container-navbar">
    <?php require __DIR__ . "/../Shared/_Navbar.php" ?>
    <h3 class="title">
        Projeto Cidade Inteligente
    </h3>
</div>
<div class="subtitle">
    <p class="text-center">
        O projeto Cidade Inteligente consiste na representação em minuatura funcional, de um circuito de ambientes dividos em várias áreas.
    </p>
</div>

<main>
    <div class="galery">
        <div class="row justify-content-center mt-3">
            <?php
                if (empty($page["projects"]))
                    echo "<h3 class='text-center'>Nenhum projeto cadastrado</h3>";
                else
                    foreach ($page["projects"] as $project)
                        require __DIR__ . "/card.php";
            ?>
        </div>
        <div class="row justify-content-center mt-3">
            <?php for ($i = 1; $i <= $page["totalPages"]; $i++) : ?>
                <?php if ($i != $page["currentPage"]) : ?>
                    <a href="<?= URL . "?page=$i" ?>">
                        <button class="btn btn-default-red m-1">
                            <?= $i ?>
                        </button>
                    </a>
                <?php else : ?>
                    <button class="btn btn-strong-red m-1" disabled>
                        <?= $i ?>
                    </button>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
</main>

<?php require __DIR__ . "/../Shared/_Footer.php" ?>