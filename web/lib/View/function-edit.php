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
                    <li class="breadcrumb-item">Functions</li>
                    <li class="breadcrumb-item"><?= $function->getName() ?></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </header>
        
        <main class="container">
            <h2>
                <?= $function->getName() ?>
                <small class="text-muted">: edit</small>
            </h2>
            
            <form id="function-edit-form">
                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="name" value="<?= $function->getName() ?>">
                
                <div class="form-group row">
                    <label for="function-edit-form-name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" id="function-edit-form-name" class="form-control" value="<?= $function->getName() ?>" disabled="disabled">
                        <small class="form-text text-muted">Name of this functionality, cannot be changed.</small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="function-edit-form-description" class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea name="description" id="function-edit-form-description" class="form-control"><?= $function->getDescription() ?></textarea>
                        <small class="form-text text-muted">A brief description about this functionality.</small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary btn-block">Save changes</button>
                    </div>
                </div>
            </form>
            
            <h3>Delete</h3>
            <form id="function-delete-form">
                <input type="hidden" name="_method" value="delete">
                <input type="hidden" name="name" value="<?= $function->getName() ?>">

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-danger btn-block">Delete functionality</button>
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
        $this->view('script', ['url' => '/public/js/function-edit.js']);
        ?>
    </body>
</html>