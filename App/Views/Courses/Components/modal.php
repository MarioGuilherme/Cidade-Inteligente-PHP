<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Cadastrar Curso
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="id_course" value="0">
                    <div class="form-group">
                        <label class="text-dark">
                            Curso
                        </label>
                        <input class="form-control" maxlength="45" type="text" name="course">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-new-course">
                    Cadastrar
                </button>
                <button type="button" class="btn btn-primary btn-update-course">
                    Salvar
                </button>
            </div>
        </div>
    </div>
</div>