<div class="fundo">
    <?php
        require __DIR__ . "/../Page/Components/_Navbar.php";
        require __DIR__ . "/../Page/Components/_Jumbotron.php";
    ?>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class=" table-responsive table-user">
                <table class="table table-hover display compact cell-border w-100">
                    <thead class="thead-user">
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
        <?php
            require __DIR__ . "/../Page/Components/_Footer.php";
        ?>
    </div>
</div>
<?php
    require __DIR__ . "/Components/modal.php";
?>