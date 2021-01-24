<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#edit" aria-expanded="true" aria-controls="edit">
                Update account information
            </button>
        </h5>
    </div>

    <div id="edit" class="collapse hide" data-parent="#accordion">
        <div class="card-body">
            <form id="account-update">
                <input type="hidden" name="_method" value="put">

                <div class="form-group row">
                    <label for="input-email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" id="input-email" placeholder="Email" value="<?= $user->getEmail() ?>">
                        <small id="help-email" class="form-text text-muted">
                            Please use your official, institutional email.
                        </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="input-password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" class="form-control" id="input-password" placeholder="Password" value="">
                        <small id="help-password" class="form-text text-muted">
                            Leave empty to keep your current password.
                        </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="input-affiliation" class="col-sm-2 col-form-label">Affiliation</label>
                    <div class="col-sm-10">
                        <input type="text" name="affiliation" class="form-control" id="input-affiliation" placeholder="Affiliation" value="<?= $user->getAffiliation() ?>">
                        <small id="help-affilaition" class="form-text text-muted">
                            Your institution's name.
                        </small>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary btn-block">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>