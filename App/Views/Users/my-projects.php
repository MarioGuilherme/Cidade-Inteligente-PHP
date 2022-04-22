<?php
    require __DIR__ . "/../Page/Components/_Navbar.php";
    require __DIR__ . "/../Page/Components/_Jumbotron.php";
?>
<div class="container-fluid ">
    <h3 class="title-my-projetos mt-5">
        Meus Projetos
    </h3>
    <hr>
    <div class="row justify-content-center mb-5">
        <?php
            if(empty($data["projects"])) {
                echo "<h3 class='text-center'>Você não está participando de nenhum projeto ainda.</h3>";
            } else {
                foreach ($data["projects"] as $project) {
                    require __DIR__ . "/Components/card.php";
                }
            }
        ?>
    </div>
</div>
<?php
    require __DIR__ . "/../Page/Components/_Footer.php";
?>