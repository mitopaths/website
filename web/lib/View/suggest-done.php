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
                    <li class="breadcrumb-item"><a href="/my-account">My account</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Suggest</li>
                </ol>
            </nav>
        </header>
        
        <main class="container">
            <h2>Thank you!</h2>
            <p>
                Thank you for your suggestion. You will be contacted by our editors on the email address you provided: <a href="mailto:<?= $user->getEmail() ?>"><?= $user->getEmail() ?></a>.
            </p>
        </main>
        
        <?php $this->view('footer'); ?>
        
        <?php $this->view('scripts'); ?>
    </body>
</html>