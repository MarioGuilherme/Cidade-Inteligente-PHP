<?php require __DIR__ . "/../Shared/_Navbar.php" ?>

<main class="p-3">
    <div class="container-fluid p-0">
        <div class="row text-right">
            <div class="col-12 col-md-12">
                <button class="btn btn-default-red" data-toggle="modal" data-target="#formModal">
                    <i class="fas fa-solid fa-plus"></i>
                    Cadastrar Usuário
                </button>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table hover">
                        <thead class="thead-user text-center">
                            <th scope="col">
                                #
                            </th>
                            <th scope="col">
                                Nome
                            </th>
                            <th scope="col">
                                Email
                            </th>
                            <th scope="col">
                                Curso
                            </th>
                            <th scope="col">
                                Admin
                            </th>
                            <th scope="col">
                                Tipo
                            </th>
                        </thead>
                        <tbody>
                            <?php foreach($page->data["users"] as $user): ?>
                                <tr role="row">
                                    <td>
                                        <?= $user->id_user ?>
                                    </td>
                                    <td>
                                        <?= $user->name ?>
                                    </td>
                                    <td>
                                        <?= $user->email ?>
                                    </td>
                                    <td>
                                        <?= $user->course ?>
                                    </td>
                                    <td>
                                        <?= $user->isAdmin == 1 ? "<i class='mdi mdi-check-bold mdi-24px text-success'></i>" : "<i class='mdi mdi-close-thick mdi-24px text-danger'></i>" ?>
                                    </td>
                                    <td>
                                        <button id="<?= $user->id_user ?>" class="btn btn-edit-user btn-strong-gray">
                                            Editar
                                        </button>
                                        <button id="<?= $user->id_user ?>" class="btn btn-delete-user btn-strong-red">
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