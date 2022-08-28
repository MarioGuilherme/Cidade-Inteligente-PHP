<form>
    <input type="hidden" name="id_user" value="">
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
    <div class="passwordInputs">
        <div class="form-group">
            <label class="text-dark">
                Senha
            </label>
            <input class="form-control" maxlength="60" type="password" name="password">
        </div>
        <div class="form-group">
            <label class="text-dark">
                Confirmar Senha
            </label>
            <input class="form-control" maxlength="60" type="password" name="confirmPassword">
        </div>
    </div>
    <div class="form-group">
        <label class="text-dark">
            Curso
        </label>
        <div class="form-group">
            <select id="my-select" class="form-control" name="id_course">
                <option value="">
                    SELECIONE O CURSO DO USUÁRIO
                </option>
                <?php foreach ($page->data["courses"] as $course) : ?>
                    <option value="<?= $course->id_course ?>">
                        <?= $course->course ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label>
            Tipo de Usuário
        </label>
        <select class="form-control" name="isAdmin">
            <option value="">
                SELECIONE O TIPO DE USUÁRIO
            </option>
            <option value="1">
                Professor(a)
            </option>
            <option value="0">
                Aluno(a)
            </option>
        </select>
    </div>
</form>