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
                    <li class="breadcrumb-item"><a href="/search?q=*&filter_type[]=protein">Proteins</a></li>
                    <li class="breadcrumb-item"><a href="/molecule/<?= $protein->getName() ?>"><?= $protein->getName() ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </header>
        
        <main class="container">
            <h2>
                <?= $protein->getName() ?>
                <small class="text-muted">: edit</small>
            </h2>
            
            <form id="protein-edit-form">
                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="type" value="protein">
                <input type="hidden" name="name" value="<?= $protein->getName() ?>">
                
                <div class="form-group row">
                    <label for="protein-edit-form-name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" id="protein-edit-form-name" class="form-control" value="<?= $protein->getName() ?>" disabled="disabled">
                        <small class="form-text text-muted">Name of this protein, cannot be changed.</small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="protein-edit-form-description" class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea name="description" id="protein-edit-form-description" class="form-control"><?= $protein->getDescription() ?></textarea>
                        <small class="form-text text-muted">A brief description about this protein.</small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Attributes</label>
                    <div class="col-sm-10">
                        <div id="protein-edit-form-attributes-container" class="row mb-3">
                            <?php foreach ($protein->getAttributesAsArray() as $name => $value): ?>
                            <div class="col-sm-4">
                                <input type="text" name="attributes_names[]" class="form-control" placeholder="Attribute name" value="<?= $name ?>">
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="attributes_values[]" class="form-control" placeholder="Attribute value" value="<?= $value ?>">
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="btn-group" role="group">
                            <button id="protein-edit-form-add-attribute" class="btn btn-success btn-sm">Add attribute</button>
                            <button id="protein-edit-form-remove-attribute" class="btn btn-danger btn-sm">Remove last attribute</button>
                        </div>
                        <small class="form-text text-muted">
                            List of additional attributes of this protein.
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
            <form id="protein-delete-form">
                <input type="hidden" name="_method" value="delete">
                <input type="hidden" name="name" value="<?= $protein->getName() ?>">

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-danger btn-block">Delete protein</button>
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
        $this->view('script', ['url' => '/public/js/protein-edit.js']);
        ?>
    </body>
</html>