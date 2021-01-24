<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#pathway-insert" aria-expanded="true" aria-controls="pathway-insert">
                Insert pathway
            </button>
        </h5>
    </div>

    <div id="pathway-insert" class="collapse hide" data-parent="#accordion">
        <div class="card-body">
            <form id="pathway-insert-form">
                <div class="form-group row">
                    <label for="pathway-insert-form-type" class="col-sm-2 col-form-label">Type</label>
                    <div class="col-sm-10">
                        <select name="type" class="form-control" id="pathway-insert-form-type">
                            <option value="pathway">pathway</option>
                            <option value="mutated_pathway">deregulated pathway</option>
                        </select>
                        <small class="form-text text-muted">
                            Select "deregulated pathway" to insert a deregulated version of a pathway, select "pathway" otherwise.
                        </small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="pathway-insert-form-name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" id="pathway-insert-form-name" placeholder="Name">
                        <small class="form-text text-muted">
                            Name of the pathway.
                        </small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="pathway-insert-form-contributor" class="col-sm-2 col-form-label">Contributor</label>
                    <div class="col-sm-10">
                        <input type="text" name="contributor" id="pathway-insert-form-contributor" class="form-control">
                        <small class="form-text text-muted">Contributor of this pathway.</small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Main theorem</label>
                    <div class="col-sm-5">
                        <input type="text" name="theorem_body" class="form-control mitopaths-expression" placeholder="Theorem body">
                        <small class="form-text text-muted">
                            Pathway main theorem: body &rArr; head.
                        </small>
                    </div>
                    <div class="col-sm-5">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">&rArr;</span>
                            </div>
                            <input type="text" name="theorem_head" class="form-control mitopaths-expression" placeholder="Theorem head">
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Steps</label>
                    <div class="col-sm-10">
                        <div id="pathway-insert-form-steps" class="row">
                        </div>
                        <div class="btn-group" role="group">
                            <button id="pathway-insert-form-add-step" class="btn btn-success btn-sm">Add new step</button>
                            <button id="pathway-insert-form-remove-step" class="btn btn-danger btn-sm">Remove last step</button>
                        </div>
                        <small class="form-text text-muted">
                            Sequence of steps to "prove" main theorem.
                        </small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Mitochondrial processes</label>
                    <div class="col-sm-10">
                        <div id="pathway-insert-form-processes" class="row">
                        </div>
                        <div class="btn-group" role="group">
                            <button id="pathway-insert-form-add-process" class="btn btn-success btn-sm">Add mitochondrial process</button>
                            <button id="pathway-insert-form-remove-process" class="btn btn-danger btn-sm">Remove last mitochondrial process</button>
                        </div>
                        <small class="form-text text-muted">
                            List of mitochondrial processes this pathway is involved in. <strong>If the mitochondrial process you are looking for does not appear while typing, you will have to create it before proceeding.</strong>
                        </small>
                    </div>
                </div>
                
                <div class="form-group row d-none" id="pathway-insert-form-original-container">
                    <label for="pathway-insert-form-original" class="col-sm-2 col-form-label">Original pathway</label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" class="form-control ajax-search" id="pathway-insert-form-original-search" data-target="#pathway-insert-form-original" data-filter="type:pathway" placeholder="Type original pathway name here...">
                            </div>
                            <div class="col-sm-6">
                                <select name="original_pathway" class="form-control" id="pathway-insert-form-original"></select>
                            </div>
                        </div>
                        <small class="form-text text-muted">
                            Original pathway (only relevant for deregulated pathways). <strong>If original pathway does not appear while typing, you have to insert it before proceeding</strong>.
                        </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Information</label>
                    <div class="col-sm-10">
                      <textarea name="attributes[information]" class="form-control"></textarea>
                      <script>CKEDITOR.replace('attributes[information]');</script>
                      <small class="form-text text-muted">
                          Additional information such as links or textual description.
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
