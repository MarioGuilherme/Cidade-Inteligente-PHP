<?php require __DIR__ . "/../Shared/_Navbar.php" ?>
<main class="p-3">
    <div class="container-fluid">
        <h3 class="title-my-projetos">
            Meus Projetos
        </h3>
        <hr>
        <div class="row justify-content-center mb-5 myProjects">
            <?php
                if(empty($page->data["projects"]))
                    echo "<h3 class='text-center'>Você não está participando de nenhum projeto.</h3>";
                else
                    foreach ($page->data["projects"] as $project)
                        require __DIR__ . "/card.php";
            ?>
        </div>
        <div class="row justify-content-center mt-3 pages">
            <?php for ($i = 1; $i <= $page->data["totalPages"]; $i++) : ?>
                <?php if ($i != $page->data["currentPage"]) : ?>
                    <a href="<?= ENVIRONMENT->URL . "meus-projetos?page=$i" ?>">
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