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
                    <li class="breadcrumb-item active" aria-current="page"><?= $molecule->getName() ?></li>
                </ol>
            </nav>
        </header>
        
        <main class="container">
            <h2>
                <?= $molecule->getName(); ?>
                <?php if (\Mitopaths\Session::isAuthenticated() && \Mitopaths\Session::getUser()->hasRole('editor')): ?>
                <a href="/molecule/<?= $molecule->getName() ?>/edit" class="btn btn-primary btn-sm float-right" title="Edit or delete this molecule">Edit</a>
                <?php endif; ?>
            </h2>
            
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            Description
                        </div>
                        <div class="card-body">
                            <?= $molecule->getDescription() ?>
                        </div>
                    </div>
                </div>

                <aside class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <dl>
                                <?php foreach ($molecule->getAttributesAsArray() as $key => $value): ?>
                                <dt class="col-sm-3"><?= $key ?></dt>
                                <dd>
                                  <?php if (filter_var($value, FILTER_VALIDATE_URL)): ?>
                                  <a href="<?= $value ?>" target="_blank"><?= $value ?></a>
                                  <?php else: ?>
                                  <?= $value ?>
                                  <?php endif; ?>
                                </dd>
                                <?php endforeach; ?>
                            </dl>
                        </div>
                    </div>
                </aside>
            </div>
        </main>
        
        <?php $this->view('footer'); ?>
        
        <?php $this->view('scripts'); ?>
    </body>
</html>
