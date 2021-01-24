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
        </header>

        <main class="page" id="page-search">
            <div class="container d-flex h-100 text-center">
                <?php $this->view('widget/page-search'); ?>
            </div>
        </main>

        <section id="page-info" class="page" style="background-image: url('http://blog.hostbaby.com/wp-content/uploads/2014/03/PaintSquares_1920x1234.jpg');">
            <?php $this->view('widget/page-info'); ?>
        </section>
        
        <?php $this->view('footer'); ?>
        
        <?php $this->view('scripts'); ?>
        <?php $this->view('script', ['url' => '/public/js/index.js']); ?>
    </body>
</html>