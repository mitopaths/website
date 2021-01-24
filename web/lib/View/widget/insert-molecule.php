<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#molecule-insert" aria-expanded="true" aria-controls="molecule-insert">
                Insert molecule
            </button>
        </h5>
    </div>

    <div id="molecule-insert" class="collapse hide" data-parent="#accordion">
        <div class="card-body">
            <form id="molecule-insert-form">
                <div class="form-group row">
                    <label for="molecule-insert-form-type" class="col-sm-2 col-form-label">Type</label>
                    <div class="col-sm-10">
                        <select name="type" class="form-control" id="molecule-insert-form-type">
                            <option value="molecule">simple molecule</option>
                            <option value="protein">protein</option>
                            <option value="mutated_protein">protein variant</option>
                        </select>
                        <small class="form-text text-muted">
                            Select type of molecule (protein, protein variant or "simple" molecule).
                        </small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="molecule-insert-form-name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" id="molecule-insert-form-name" class="form-control" placeholder="Name">
                        <small class="form-text text-muted">
                            Name of this molecule, e.g. CYC5, MICU...
                        </small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="molecule-insert-form-description" class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea name="description" id="molecule-insert-form-description" class="form-control" placeholder="Description"></textarea>
                        <small class="form-text text-muted">
                            A brief description about this molecule.
                        </small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Attributes</label>
                    <div class="col-sm-10">
                        <div id="molecule-insert-form-attributes" class="row">
                        </div>
                        <div class="btn-group" role="group">
                            <button id="molecule-insert-form-add-attribute" class="btn btn-success btn-sm">Add attribute</button>
                            <button id="molecule-insert-form-remove-attribute" class="btn btn-danger btn-sm">Remove last attribute</button>
                        </div>
                        <small class="form-text text-muted">
                            List of additional attributes of this molecule.
                        </small>
                    </div>
                </div>
                
                <div class="form-group row d-none" id="molecule-insert-form-original-container">
                    <label for="molecule-insert-form-original" class="col-sm-2 col-form-label">Original protein</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control ajax-search" id="molecule-insert-form-original-search" data-target="#molecule-insert-form-original" data-filter="type:protein" placeholder="Type original protein name here...">
                        <select name="original_protein" class="form-control" id="molecule-insert-form-original"></select>

                        <small class="form-text text-muted">
                            Original protein (only relevant for protein variants). <strong>If original protein does not appear while typing, you have to insert it before proceeding</strong>.
                        </small>
                    </div>
                </div>
                
                <div class="form-group row d-none" id="molecule-insert-form-function">
                    <label class="col-sm-2 col-form-label">Functionalities</label>
                    <div class="col-sm-10">
                        <div id="molecule-insert-form-functions">
                        </div>
                        <div class="btn-group" role="group">
                            <button id="molecule-insert-form-add-function-loss" class="btn btn-success btn-sm">Add functionality loss</button>
                            <button id="molecule-insert-form-add-function-gain" class="btn btn-success btn-sm">Add functionality gain</button>
                            <button id="molecule-insert-form-remove-function" class="btn btn-danger btn-sm">Remove last functionality</button>
                        </div>
                        <small class="form-text text-muted">
                            List of functionalities lost and gained.
                        </small>
                    </div>
                </div>
                
                <div class="form-group row d-none" id="molecule-insert-form-pathology">
                    <label class="col-sm-2 col-form-label">Pathologies</label>
                    <div class="col-sm-10">
                        <div id="molecule-insert-form-pathologies">
                        </div>
                        <div class="btn-group" role="group">
                            <button id="molecule-insert-form-add-pathology" class="btn btn-success btn-sm">Add pathology</button>
                            <button id="molecule-insert-form-remove-pathology" class="btn btn-danger btn-sm">Remove last pathology</button>
                        </div>
                        <small class="form-text text-muted">
                            List of pathologies associated to this protein variant.
                        </small>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary btn-block">Insert</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
