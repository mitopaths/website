<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <title>Mitopaths</title>
        
        <?php $this->view('head'); ?>
    </head>
    
    <body>
        <header>
            <?php $this->view('navbar'); ?>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">mitopatHs</a></li>
                    <li class="breadcrumb-item"><a href="/search?q=*&filter_type[]=mutated_protein">Protein variants</a></li>
                    <li class="breadcrumb-item"><a href="/molecule/<?= $mutated_protein->getName() ?>"><?= $mutated_protein->getName() ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </header>
        
        <main class="container">
            <h2>
                <?= $mutated_protein->getName() ?>
                <small class="text-muted">: edit</small>
            </h2>
            
            <form id="mutated-protein-edit-form">
                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="type" value="mutated_protein">
                <input type="hidden" name="name" value="<?= $mutated_protein->getName() ?>">
                
                <div class="form-group row">
                    <label for="mutated-protein-edit-form-name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" id="mutated-protein-edit-form-name" class="form-control" value="<?= $mutated_protein->getName() ?>" disabled="disabled">
                        <small class="form-text text-muted">Name of this protein variant, cannot be changed.</small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="mutated-protein-edit-form-original" class="col-sm-2 col-form-label">Original protein</label>
                    <div class="col-sm-5">
                        <input type="text" id="mutated-protein-edit-form-original-search" class="form-control ajax-search" data-target="#mutated-protein-edit-form-original" data-filter="type:protein" value="<?= $mutated_protein->getOriginalProtein()->getName() ?>" placeholder="Type original protein name here...">
                        <small class="form-text text-muted">Name of original protein this one is a mutation of. <strong>If original protein does not appear while typing, you have to insert it before proceeding.</strong></small>
                    </div>
                    <div class="col-sm-5">
                        <select name="original_protein" id="mutated-protein-edit-form-original" class="form-control">
                            <option value="<?= $mutated_protein->getOriginalProtein()->getName() ?>"><?= $mutated_protein->getOriginalProtein()->getName() ?></option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="mutated-protein-edit-form-description" class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea name="description" id="mutated-protein-edit-form-description" class="form-control"><?= $mutated_protein->getDescription() ?></textarea>
                        <small class="form-text text-muted">A brief description about this protein variant.</small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Attributes</label>
                    <div class="col-sm-10">
                        <div id="mutated-protein-edit-form-attributes-container" class="row mb-3">
                            <?php foreach ($mutated_protein->getAttributesAsArray() as $name => $value): ?>
                            <div class="col-sm-4">
                                <input type="text" name="attributes_names[]" class="form-control" placeholder="Attribute name" value="<?= $name ?>">
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="attributes_values[]" class="form-control" placeholder="Attribute value" value="<?= $value ?>">
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="btn-group" role="group">
                            <button id="mutated-protein-edit-form-add-attribute" class="btn btn-success btn-sm">Add attribute</button>
                            <button id="mutated-protein-edit-form-remove-attribute" class="btn btn-danger btn-sm">Remove last attribute</button>
                        </div>
                        <small class="form-text text-muted">
                            List of additional attributes of this protein variant.
                        </small>
                    </div>
                </div>
                
                <div class="form-group row" id="molecule-edit-form-function">
                    <label class="col-sm-2 col-form-label">Functionalities</label>
                    <div class="col-sm-10">
                        <div id="molecule-edit-form-functions-container">
                            <?php foreach ($mutated_protein->getLostFunctionsAsArray() as $function): ?>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend"><label class="input-group-text">Loss</label>
                                </div>
                                <select name="lost_functions[]" class="form-control">
                                    <option value="<?= $function->getName() ?>"><?= $function->getName() ?></option>
                                </select>
                            </div>
                            <?php endforeach; ?>
                            <?php foreach ($mutated_protein->getGainedFunctionsAsArray() as $function): ?>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend"><label class="input-group-text">Gain</label>
                                </div>
                                <select name="gained_functions[]" class="form-control">
                                    <option value="<?= $function->getName() ?>"><?= $function->getName() ?></option>
                                </select>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="btn-group" role="group">
                            <button id="molecule-edit-form-add-function-loss" class="btn btn-success btn-sm">Add functionality loss</button>
                            <button id="molecule-edit-form-add-function-gain" class="btn btn-success btn-sm">Add functionality gain</button>
                            <button id="molecule-edit-form-remove-function" class="btn btn-danger btn-sm">Remove last functionality</button>
                        </div>
                        <small class="form-text text-muted">
                            List of functionalities lost and gained.
                        </small>
                    </div>
                </div>
                
                <div class="form-group row" id="molecule-insert-form-pathology">
                    <label class="col-sm-2 col-form-label">Pathologies</label>
                    <div class="col-sm-10">
                        <div id="molecule-edit-form-pathologies-container">
                            <?php foreach ($mutated_protein->getPathologiesAsArray() as $pathology): ?>
                            <select name="pathologies[]" class="form-control mb-3">
                                <option value="<?= $pathology->getName() ?>"><?= $pathology->getName() ?></option>
                            </select>
                            <?php endforeach; ?>
                        </div>
                        <div class="btn-group" role="group">
                            <button id="molecule-edit-form-add-pathology" class="btn btn-success btn-sm">Add pathology</button>
                            <button id="molecule-edit-form-remove-pathology" class="btn btn-danger btn-sm">Remove last pathology</button>
                        </div>
                        <small class="form-text text-muted">
                            List of pathologies associated to this protein variant.
                        </small>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary btn-block">Save changes</button>
                    </div>
                </div>
            </form>
            
            <h3>Delete</h3>
            <form id="mutated-protein-delete-form">
                <input type="hidden" name="_method" value="delete">
                <input type="hidden" name="name" value="<?= $mutated_protein->getName() ?>">

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-danger btn-block">Delete protein variant</button>
                        <small class="form-text text-muted"><strong>Warning:</strong> This operation cannot be undone.</small>
                    </div>
                </div>
            </form>
        </main>
        
        <?php $this->view('footer'); ?>
        
        <?php $this->view('widget/alert'); ?>
        
        <?php
        $this->view('scripts');
        $this->view('script', ['url' => '/public/js/alert.js']);
        $this->view('script', ['url' => '/public/js/ajax-search.js']);
        $this->view('script', ['url' => '/public/js/mutated-protein-edit.js']);
        ?>
    </body>
</html>
