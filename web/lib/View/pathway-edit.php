<?php
function expression_to_string($expression) {
    $visitor = new \Mitopaths\Model\Expression\Visitor\Export();
    $expression->accept($visitor);
    return htmlentities($visitor->getResult());
}
$steps = $pathway->getStepsAsArray();
$processes = $pathway->getMitochondrialProcessesAsArray();
?>
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
                    <li class="breadcrumb-item"><a href="/search?q=*&filter_type[]=pathway">Pathways</a></li>
                    <li class="breadcrumb-item"><a href="/pathway/<?= str_replace(['/', '+'], ['---0', '---1'], $pathway->getName()) ?>"><?= $pathway->getName() ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </header>
        
        <main class="container">
            <h2>
                <?= $pathway->getName() ?>
                <small class="text-muted">: edit</small>
            </h2>
            
            <form id="pathway-edit-form" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="type" value="pathway">
                <input type="hidden" name="name" value="<?= str_replace(['/', '+'], ['---0', '---1'], $pathway->getName()) ?>">
                
                <div class="form-group row">
                    <label for="pathway-edit-form-name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" id="pathway-edit-form-name" class="form-control" value="<?= $pathway->getName() ?>" disabled="disabled">
                        <small class="form-text text-muted">Name of this pathway, cannot be changed.</small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="pathway-edit-form-contributor" class="col-sm-2 col-form-label">Contributor</label>
                    <div class="col-sm-10">
                        <input type="text" name="contributor" id="pathway-edit-form-contributor" class="form-control" value="<?= $pathway->getContributor() ?>">
                        <small class="form-text text-muted">Contributor of this pathway.</small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Main theorem</label>
                    <div class="col-sm-5">
                        <input type="text" name="theorem_body" value="<?= expression_to_string($pathway->getTheorem()->getBody()) ?>" class="form-control mitopaths-expression" placeholder="Theorem body">
                        <small class="form-text text-muted">
                            Pathway main theorem: body &rArr; head.
                        </small>
                    </div>
                    <div class="col-sm-5">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">&rArr;</span>
                            </div>
                            <input type="text" name="theorem_head" value="<?= expression_to_string($pathway->getTheorem()->getHead()) ?>" class="form-control mitopaths-expression" placeholder="Theorem head">
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Steps</label>
                    <div class="col-sm-10">
                        <div id="pathway-edit-form-steps-container" class="row">
                            <?php for ($i = 0; $i < count($steps); ++$i): ?>
                            <div class="col-sm-6">
                                <input type="text" name="step_body[<?= $i ?>]" value="<?= expression_to_string($steps[$i]->getBody()) ?>" class="form-control mitopaths-expression" placeholder="Step body">
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">&rArr;</span>
                                    </div>
                                    <input type="text" name="step_head[<?= $i ?>]" value="<?= expression_to_string($steps[$i]->getHead()) ?>" class="form-control mitopaths-expression" placeholder="Step head">
                                </div>
                            </div>
                            <?php endfor; ?>
                        </div>
                        <div class="btn-group" role="group">
                            <button id="pathway-edit-form-add-step" class="btn btn-success btn-sm">Add new step</button>
                            <button id="pathway-edit-form-remove-step" class="btn btn-danger btn-sm">Remove last step</button>
                        </div>
                        <small class="form-text text-muted">
                            Sequence of steps to "prove" main theorem.
                        </small>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Mitochondrial processes</label>
                    <div class="col-sm-10">
                        <div id="pathway-edit-form-processes-container" class="row">
                            <?php for ($i = 0; $i < count($processes); ++$i): ?>
                            <div class="col-sm-6 mb-3">
                                <input type="text" value="<?= $processes[$i]->getName() ?>" class="form-control ajax-search" data-target="#pathway-edit-form-process-<?= $i ?>" data-filter="type:category" placeholder="Type mitochondrial process name here...">
                            </div>
                            <div class="col-sm-6">
                                <select name="mitochondrial_processes[]" id="pathway-edit-form-process-<?= $i ?>" class="form-control">
                                    <option value="<?= $processes[$i]->getName() ?>"><?= $processes[$i]->getName() ?></option>
                                </select>
                            </div>
                            <?php endfor; ?>
                        </div>
                        <div class="btn-group" role="group">
                            <button id="pathway-edit-form-add-process" class="btn btn-success btn-sm">Add mitochondrial process</button>
                            <button id="pathway-edit-form-remove-process" class="btn btn-danger btn-sm">Remove last mitochondrial process</button>
                        </div>
                        <small class="form-text text-muted">
                            List of mitochondrial processes this pathway is involved in. <strong>If the mitochondrial process you are looking for does not appear while typing, you will have to create it before proceeding.</strong>
                        </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Information</label>
                    <div class="col-sm-10">
                      <textarea name="attributes[information]" class="form-control"><?= $pathway->getAttribute('information');  ?></textarea>
                      <script>CKEDITOR.replace('attributes[information]');</script>
                      <small class="form-text text-muted">
                          Additional information such as links or textual description.
                      </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Images</label>
                    <div class="col-sm-10" style="max-height: 160px; overflow-y: auto">
                        <small class="form-text text-muted">
                            Sequence of images associated to this pathway. Leaving this blank will leave images as they are.
                        </small>
                        <?php for ($i = 0; $i < 40; ++$i): ?>
                          <label style="display: block">
                            <?= $i + 1 ?>
                            <input type="file" classe="form-control-file" name="image[]">
                          </label>
                        <?php endfor; ?>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary btn-block">Save changes</button>
                    </div>
                </div>
            </form>
            
            <h3>Delete</h3>
            <form id="pathway-delete-form">
                <input type="hidden" name="_method" value="delete">
                <input type="hidden" name="name" value="<?= str_replace(['/', '+'], ['---0', '---1'], $pathway->getName()) ?>">

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-danger btn-block">Delete pathway</button>
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
        $this->view('script', ['url' => '/public/js/pathway-edit.js']);
        $this->view('script', ['url' => '/public/js/expression-validator.js']);
        $this->view('script', ['url' => '/public/js/ajax-search.js']);
        ?>
    </body>
</html>
