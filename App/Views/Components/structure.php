<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $data["title"] ?>
    </title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;700&display=swap">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="assets/libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/libs/MaterialDesign/css/materialdesignicons.css">
    <link rel="stylesheet" href="assets/fonts/font.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/<?= $data["css"] ?>.css">
</head>

<body>

    <?php
        $file = __DIR__ . "/../$view.php";
        if(file_exists($file))
            require $file;
        else
            die("View file ($file) doesn't exist!");
    ?>

    <script src="assets/libs/jQuery/jquery-3.6.0.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="assets/js/functions.js"></script>
    <script src="assets/js/<?= $data["js"] ?>.js"></script>
</body>

</html>