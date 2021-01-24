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
                    <li class="breadcrumb-item active" aria-current="page">Search</li>
                </ol>
            </nav>
        </header>
        
        <main class="container">
            <h2>
                <?php if ($result['q'] !== '*'): ?>
                Results for "<?= $result['q']; ?>"
                <?php else: ?>
                Search results
                <?php endif; ?>
            </h2>
            <small class="text-muted">
                <?= $result['results'] ?> results in <?= printf('%.2f', $result['response_time'] / 1000) ?> seconds.
            </small>
            
            <div class="row">
                <section class="col-sm-8 col-lg-9">
                    <?php $this->view('widget/search-box', $_variables); ?>
                    <?php $this->view('widget/search-paginator', $_variables); ?>
                    
                    <?php
                    foreach ($result['items'] as $item):
                        $this->view('widget/search-item', ['item' => $item]);
                    endforeach;
                    ?>
                </section>
                
                <aside class="col-sm-4 col-lg-3">
                    <?php $this->view('widget/search-panel', $_variables); ?>
                </aside>
            </div>
        </main>
        
        <?php $this->view('footer'); ?>
        
        <?php $this->view('scripts'); ?>
    </body>
</html>
