<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="id_user" value="0">
                    <div class="form-group">
                        <label class="text-dark">
                            Curso
                        </label>
                        <div class="form-group">
                            <select id="my-select" class="form-control" name="course">
                                <option value="0">
                                    SELECIONE O CURSO
                                </option>
                                <?php foreach ($data["courses"] as $course) : ?>
                                    <option value="<?= $course["id_course"] ?>">
                                        <?= $course["course"] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="text-dark">
                            Nome
                        </label>
                        <input class="form-control" maxlength="100" type="text" name="name">
                    </div>
                    <div class="form-group">
                        <label class="text-dark">
                            Email
                        </label>
                        <input class="form-control" maxlength="60" type="text" name="email">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default-red btn-block btn-save">
                    Salvar
                </button>
            </div>
        </div>
    </div>
</div>