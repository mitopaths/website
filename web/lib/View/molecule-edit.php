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
                    <li class="breadcrumb-item">Molecules</li>
                    <li class="breadcrumb-item"><a href="/molecule/<?= $molecule->getName() ?>"><?= $molecule->getName() ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </header>
        
        <main class="container">
            <h2>
                <?= $molecule->getName() ?>
                <small class="text-muted">: edit</small>
            </h2>
            
            <form id="molecule-edit-form">
                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="type" value="molecule">
                <input type="hidden" name="name" value="<?= $molecule->getName() ?>">
                
                <div class="form-group row">
                    <label for="molecule-edit-form-name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" id="molecule-edit-form-name" class="form-control" value="<?= $molecule->getName() ?>" disabled="disabled">
                        <small class="form-text text-muted">Name of this molecule, cannot be changed.</small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="molecule-edit-form-description" class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea name="description" id="molecule-edit-form-description" class="form-control"><?= $molecule->getDescription() ?></textarea>
                        <small class="form-text text-muted">A brief description about this molecule.</small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Attributes</label>
                    <div class="col-sm-10">
                        <div id="molecule-edit-form-attributes-container" class="row mb-3">
                            <?php foreach ($molecule->getAttributesAsArray() as $name => $value): ?>
                            <div class="col-sm-4">
                                <input type="text" name="attributes_names[]" class="form-control" placeholder="Attribute name" value="<?= $name ?>">
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="attributes_values[]" class="form-control" placeholder="Attribute value" value="<?= $value ?>">
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="btn-group" role="group">
                            <button id="molecule-edit-form-add-attribute" class="btn btn-success btn-sm">Add attribute</button>
                            <button id="molecule-edit-form-remove-attribute" class="btn btn-danger btn-sm">Remove last attribute</button>
                        </div>
                        <small class="form-text text-muted">
                            List of additional attributes of this molecule.
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
            <form id="molecule-delete-form">
                <input type="hidden" name="_method" value="delete">
                <input type="hidden" name="name" value="<?= $molecule->getName() ?>">

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-danger btn-block">Delete molecule</button>
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
        $this->view('script', ['url' => '/public/js/molecule-edit.js']);
        ?>
    </body>
</html>