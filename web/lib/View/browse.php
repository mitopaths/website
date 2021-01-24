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
                    <li class="breadcrumb-item active" aria-current="page">Browse pathways</li>
                </ol>
            </nav>
        </header>
        
        <main class="container">
            <h2>Browse pathways</h2>
            <p>Select a pathway from the list:</p>
      
            <form id="browse-pathways-form" method="GET">
                <div class="form-group row">
                    <label for="browse-pathways-form-name" class="col-sm-2 col-form-label">Pathway</label>
                    
                    <div class="input-group mb-3 col-sm-10">
                        <select id="browse-pathways-form-name" class="form-control">
                            <?php foreach ($pathways as $pathway): ?>
                            <option value="<?= str_replace(['/', '+'], ['---0', '---1'], $pathway['name']) ?>"><?= $pathway['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-primary">View</button>
                        </div>
                    </div>
                </div>  
            </form>
        </main>
        
        <?php $this->view('footer'); ?>
        
        <?php $this->view('scripts'); ?>
        <?php $this->view('script', ['url' => '/public/js/browse.js']); ?>
    </body>
</html>
