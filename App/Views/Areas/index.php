<div class="fundo">
    <?php
        require __DIR__ . "/../Page/Components/_Navbar.php";
        require __DIR__ . "/../Page/Components/_Jumbotron.php";
    ?>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <button class="btn btn-primary btn-form-area">
                <i class="mdi mdi-plus mdi-22px"></i>
                Cadastrar Área
            </button>
            <div class="table-responsive">
                <table class="table table-hover display compact cell-border w-100">
                    <thead class="thead-dark text-center">
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
                    <tbody>
                        <?php foreach ($data["areas"] as $area): ?>
                            <tr role="row">
                                <td class="text-center"><?= $area["id_area"] ?></td>
                                <td class="text-center"><?= $area["area"] ?></td>
                                <td class="text-center">
                                    <button id="<?= $area["id_area"] ?>" class="btn btn-warning btn-edit-area">
                                        Editar
                                    </button>
                                    <button id="<?= $area["id_area"] ?>" class="btn btn-danger btn-delete-area">
                                        Apagar
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
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