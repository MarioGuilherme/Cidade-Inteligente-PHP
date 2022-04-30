    <?php
        require __DIR__ . "/../Page/Components/_Navbar.php";
        require __DIR__ . "/../Page/Components/_Jumbotron.php";
    ?>
    <div class="container-fluid">
        <div class="row justify-content-center mt-3">
            <button class="btn btn-primary btn-form-area">
                <i class="mdi mdi-plus mdi-22px"></i>
                Cadastrar Área
            </button>
            <div class="table-responsive table-areas">
                <table class="table">
                    <thead class="thead-area text-center">
                        <th scope="col">
                            #
                        </th>
                        <th scope="col">
                            Área
                        </th>
                        <th scope="col">
                            Ações
                        </th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
            require __DIR__ . "/../Page/Components/_Footer.php";
        ?>
<?php
    require __DIR__ . "/Components/modal.php";
?>