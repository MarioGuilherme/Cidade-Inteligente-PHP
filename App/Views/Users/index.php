<?php require __DIR__ . "/../Components/_Navbar.php"; ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="table-responsive table-user">
            <table class="table">
                <thead class="thead-user text-center">
                    <th scope="col">
                        #
                    </th>
                    <th scope="col">
                        Curso
                    </th>
                    <th scope="col">
                        Nome
                    </th>
                    <th scope="col">
                        Email
                    </th>
                    <th scope="col">
                        Tipo
                    </th>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<?php
    require __DIR__ . "/../Components/_Footer.php";
    require __DIR__ . "/Components/modal.php";
?>