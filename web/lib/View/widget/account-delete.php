<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#delete" aria-expanded="true" aria-controls="delete">
                Delete account
            </button>
        </h5>
    </div>

    <div id="delete" class="collapse hide" data-parent="#accordion">
        <div class="card-body">
            <form id="account-delete">
                <input type="hidden" name="_method" value="delete">

                <div class="form-group row">
                    <label for="input-email" class="col-sm-2 col-form-label">Confirm</label>
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary btn-block">Delete account</button>
                        <small id="help-delete" class="form-text text-muted">
                            <strong>Warning:</strong> this action cannot be undone!
                        </small>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>