<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#pathology-insert" aria-expanded="true" aria-controls="pathology-insert">
                Insert pathology
            </button>
        </h5>
    </div>

    <div id="pathology-insert" class="collapse hide" data-parent="#accordion">
        <div class="card-body">
            <form id="pathology-insert-form">
                <div class="form-group row">
                    <label for="pathology-insert-form-name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" id="pathology-insert-form-name" class="form-control" placeholder="Name">
                        <small class="form-text text-muted">
                            Name of the new pathology.
                        </small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="pathology-insert-form-description" class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea name="description" id="pathology-insert-form-description" class="form-control" placeholder="Description"></textarea>
                        <small class="form-text text-muted">
                            A brief description about the pathology.
                        </small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button class="btn btn-primary btn-block">Insert</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>