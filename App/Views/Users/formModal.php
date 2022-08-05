<form>
    <input type="hidden" name="id_user" value="">
    <div class="form-group">
        <label class="text-dark">
            Curso
        </label>
        <div class="form-group">
            <select id="my-select" class="form-control" name="id_course">
                <?php foreach ($page["courses"] as $course) : ?>
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
    <div class="form-group">
        <label class="text-dark">
            Admin
        </label>
        <br>
        <input type="checkbox" name="isAdmin">
    </div>
</form>