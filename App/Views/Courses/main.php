<?php require __DIR__ . "/../Shared/_Navbar.php" ?>

<main class="p-3">
    <div class="container-fluid p-0">
        <div class="row text-right">
            <div class="col-12 col-md-12">
                <button class="btn btn-default-red" data-toggle="modal" data-target="#formModal">
                    <i class="fas fa-solid fa-plus"></i>
                    Cadastrar Curso
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
                                Curso
                            </th>
                            <th scope="col">
                                Ações
                            </th>
                        </thead>
                        <tbody>
                            <?php foreach($page->data as $course): ?>
                                <tr role="row">
                                    <td>
                                        <?= $course->id_course ?>
                                    </td>
                                    <td>
                                        <?= $course->course ?>
                                    </td>
                                    <td>
                                        <button id="<?= $course->id_course ?>" class="btn btn-edit-course btn-strong-gray">
                                            Editar
                                        </button>
                                        <button id="<?= $course->id_course ?>" class="btn btn-delete-course btn-strong-red">
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