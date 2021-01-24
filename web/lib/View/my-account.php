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
                    <li class="breadcrumb-item active" aria-current="page">My account</li>
                </ol>
            </nav>
        </header>
        
        <main class="container">
            <h2>My Account</h2>
            <dl class="row">
                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9"><?= $user->getEmail(); ?></dd>

                <dt class="col-sm-3">Affiliation</dt>
                <dd class="col-sm-9"><?= $user->getAffiliation(); ?></dd>

                <?php if ($user->getRole() !== 'simple'): ?>
                <dt class="col-sm-3">Role</dt>
                <dd class="col-sm-9"><?= $user->getRole(); ?></dd>
                <?php endif; ?>

                <dt class="col-sm-3">Registered on</dt>
                <dd class="col-sm-9"><?= date('d/m/Y, H:i:s', $user->getCreationTimestamp()); ?></dd>
                
                <dt class="col-sm-3">Last account update</dt>
                <dd class="col-sm-9"><?= date('d/m/Y, H:i:s', $user->getUpdateTimestamp()); ?></dd>
                
                <dt class="col-sm-3">Logout</dt>
                <dd class="col-sm-9"><button class="btn btn-secondary btn-sm" id="logout-button">Logout</button></dd>
            </dl>
            
            
            <section id="accordion">
                <?php $this->view('widget/account-update', ['user' => $user]); ?>
                <?php $this->view('widget/suggest'); ?>
                <?php $this->view('widget/contact', ['user' => $user]); ?>
                
                <?php if ($user->hasRole('editor')): ?>
                <?php $this->view('widget/insert-molecule'); ?>
                <?php $this->view('widget/pathway-insert'); ?>
                <?php $this->view('widget/mitochondrial-process-insert'); ?>
                <?php $this->view('widget/function-insert') ?>
                <?php $this->view('widget/pathology-insert') ?>
                <?php endif; ?>
                
                <?php if ($user->hasRole('admin')): ?>
                <?php $this->view('widget/users-manage', $_variables); ?>
                <?php endif; ?>
                
                <?php $this->view('widget/account-delete'); ?>
            </section>
        </main>
        
        <?php $this->view('footer'); ?>
        
        <?php $this->view('widget/alert'); ?>
        
        <?php $this->view('scripts'); ?>
        <?php $this->view('script', ['url' => '/public/js/alert.js']); ?>
        <?php $this->view('script', ['url' => '/public/js/my-account.js']); ?>
        <?php $this->view('script', ['url' => '/public/js/expression-validator.js']); ?>
        <?php $this->view('script', ['url' => '/public/js/ajax-search.js']); ?>
    </body>
</html>
