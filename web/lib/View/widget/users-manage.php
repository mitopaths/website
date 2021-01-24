<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#users-manage" aria-expanded="true" aria-controls="users-manage">
                Manage users
            </button>
        </h5>
    </div>

    <div id="users-manage" class="collapse hide" data-parent="#accordion">
        <div class="card-body">
            <form id="users-manage-form">
                <div class="form-group row">
                    <label for="users-manage-form-id" class="col-sm-2 col-form-label">User</label>
                    <div class="col-sm-10">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">User to edit: </div>
                            </div>
                            <select id="users-manage-form-id" class="form-control">
                                <?php foreach ($users as $user): ?>
                                <option value="<?= $user->getId() ?>"><?= $user->getEmail() ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-primary">
                                    Edit
                                </button>
                            </div>
                        </div>
                        <small class="form-text text-muted">
                            User to manage.
                        </small>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>