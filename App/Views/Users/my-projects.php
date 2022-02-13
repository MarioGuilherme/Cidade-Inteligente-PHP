<?php
    require __DIR__ . "/../Page/Components/_Navbar.php";
    require __DIR__ . "/../Page/Components/_Jumbotron.php";
?>

<?= json_encode($data["projects"]) ?>