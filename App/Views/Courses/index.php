<div class="fundo">
    <?php
        require __DIR__ . "/../Page/Components/_Navbar.php";
        require __DIR__ . "/../Page/Components/_Jumbotron.php";
    ?>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <button class="btn btn-primary btn-form-course">
                <i class="mdi mdi-plus mdi-22px"></i>
                Cadastrar Curso
            </button>
            <div class="table-responsive">
                <table class="table table-hover display compact cell-border w-100">
                    <thead class="thead-dark text-center">
                        <th scope="col">
                            #
                        </th>
                        <th scope="col">
                            Curso
                        </th>
                        <th scope="col">
                            Ações
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