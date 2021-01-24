<?php
header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
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
                    <li class="breadcrumb-item active" aria-current="page">Page not found</li>
                </ol>
            </nav>
        </header>
        
        <main class="container">
            <h2>Page not found</h2>
            <p>
                The page you are looking for was not found on this website. You should check:
            </p>
            <ul>
                <li>Inserted URL: did you follow a link on the website?</li>
                <li>Resource does not exist: what did you expect to find?</li>
                <li>
                    You may want to use our <a href="/#page-search">search utility</a> to access content on mitopatHs.
                </li>
                <li>
                    Should everything fail, you can still visit our <a href="/">home page</a>.
                </li>
            </ul>
        </main>
        
        <?php $this->view('footer'); ?>
        
        <?php $this->view('scripts'); ?>
    </body>
</html>