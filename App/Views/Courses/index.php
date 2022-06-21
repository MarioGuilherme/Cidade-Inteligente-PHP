<?php require __DIR__ . "/../Components/_Navbar.php"; ?>
<div class="container-fluid">
    <div class="row text-right mt-2 mb-2">
        <div class="col-12 col-md-12">
            <button class="btn btn-form-course">
                <i class="mdi mdi-plus mdi-22px"></i>
                Cadastrar Curso
            </button>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="table-responsive table-course">
            <table class="table">
                <thead class="thead-course text-center">
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
</div>
<?php
    require __DIR__ . "/../Components/_Footer.php";
    require __DIR__ . "/Components/modal.php";
?>