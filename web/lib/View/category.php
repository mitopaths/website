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
<!--
                    <li class="breadcrumb-item"><a href="/search?q=*&filter_type[]=category">Mitochondrial processes</a></li>
-->
                    <li class="breadcrumb-item"><a href="/categories">Mitochondrial processes</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $category->getName() ?></li>
                </ol>
            </nav>
        </header>
        
        <main class="container">
            <h2>
                <?= $category->getName(); ?>
                <?php if (\Mitopaths\Session::isAuthenticated() && \Mitopaths\Session::getUser()->hasRole('editor')): ?>
                <a href="/category/<?= $category->getName() ?>/edit" class="btn btn-primary btn-sm float-right" title="Edit or delete this category">Edit</a>
                <?php endif; ?>
            </h2>
            
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            Description
                        </div>
                        <div class="card-body">
                            <?= $category->getDescription() ?>
                        </div>
                    </div>
                </div>
            
                <aside class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            Pathways involved (<?= count($pathways) ?>):
                            <?php if (!empty($pathways)): ?>
                            <ul class="list-inline">
                                <?php foreach ($pathways as $pathway): ?>
                                <li class="list-inline-item">
                                    <a href="/pathway/<?= str_replace(['/', '+'], ['---0', '---1'], $pathway['name']) ?>"><?= $pathway['name'] ?></a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php else: ?>
                            None known.
                            <?php endif; ?>
                        </div>
                    </div>
                </aside>
            </div>
        </main>
        
        <?php $this->view('footer'); ?>
        
        <?php $this->view('scripts'); ?>
    </body>
</html>
