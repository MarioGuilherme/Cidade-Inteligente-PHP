<?php require __DIR__ . "/../Shared/_Navbar.php" ?>

<main class="p-3">
    <div class="container-fluid p-0">
        <div class="row text-right">
            <div class="col-12 col-md-12">
                <button class="btn btn-default-red" data-toggle="modal" data-target="#formModal">
                    <i class="fas fa-solid fa-plus"></i>
                    Cadastrar Área
                </button>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table hover">
                        <thead class="text-center">
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
                            <?php foreach($page["areas"] as $area): ?>
                                <tr role="row">
                                    <td>
                                        <?= $area["id_area"] ?>
                                    </td>
                                    <td>
                                        <?= $area["area"] ?>
                                    </td>
                                    <td>
                                        <button id="<?= $area["id_area"] ?>" class="btn btn-edit-area btn-strong-gray">
                                            Editar
                                        </button>
                                        <button id="<?= $area["id_area"] ?>" class="btn btn-delete-area btn-strong-red">
                                            Apagar
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php 
    require __DIR__ . "/../Shared/_Modal.php";
    require __DIR__ . "/../Shared/_Footer.php";
?>