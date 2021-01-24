<?php
function pathway_to_array(\Mitopaths\Model\Pathway $pathway) {
    $array = new \Mitopaths\Model\Expression\Visitor\Vector();
    $data = [
        'name' => $pathway->getName(),
        'theorem' => [
            'head' => $pathway->getTheorem()->getHead()->accept($array),
            'body' => $pathway->getTheorem()->getBody()->accept($array)
        ],
        'steps' => []
    ];

    foreach ($pathway->getStepsAsArray() as $step) {
        $data['steps'][] = [
            'head' => $step->getHead()->accept($array),
            'body' => $step->getBody()->accept($array)
        ];
    }
    
    return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <title>Mitopaths</title>
        
        <?php $this->view('head'); ?>
        <link href="http://visjs.org/dist/vis-network.min.css" rel="stylesheet" type="text/css" />
        <style>
          .carousel-control-next {
              background: rgba(0, 0, 0, 0.5);
              right: -150px;
          }
          .carousel-control-prev {
              background: rgba(0, 0, 0, 0.5);
              left: -150px;
          }
        </style>
    </head>
    
    <body>
        <header>
            <?php $this->view('navbar'); ?>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">mitopatHs</a></li>
                    <li class="breadcrumb-item"><a href="/search?q=*&filter_type[]=mutated_pathway">Deregultaed pathways</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $pathway->getName() ?></li>
                </ol>
            </nav>
        </header>
        
        <main class="container pathway-page">
            <h2>
                <?= $pathway->getName(); ?>
                <?php if (\Mitopaths\Session::isAuthenticated() && \Mitopaths\Session::getUser()->hasRole('editor')): ?>
                <a href="/pathway/<?= str_replace(['/', '+'], ['---0', '---1'], $pathway->getName()) ?>/edit" class="btn btn-primary btn-sm float-right" title="Edit or delete this deregulated pathway">Edit</a>
                <?php endif; ?>
            </h2>
            <small class="text-muted">
                Mutation of
                <a href="/pathway/<?= $pathway->getOriginalPathway()->getName() ?>"><?= $pathway->getOriginalPathway()->getName() ?></a>. Contributor: <?= $pathway->getContributor() ?>.
            </small>
            
            <div class="d-none pathway-json">
                <?= json_encode(pathway_to_array($pathway)) ?>
            </div>
            
            
            <section class="card mb-3 mt-3">
                <h3 class="card-header">
                    Theorem
                </h3>
                <div class="card-body">
                    <p class="card-text pathway-theorem"></p>
                </div>
            </section>

            <?php if (!empty($pathway->getAttribute('information'))): ?>
            <section class="card mb-3">
                <h3 class="card-header">
                    Information
                </h3>
                <div class="card-body">
                    <?= $pathway->getAttribute('information'); ?>
                </div>
            </section>
            <?php endif; ?>
            
            <section class="card mb-3">
                <h3 class="card-header">
                    <a href="#pathway-mitochondrial-processes" data-toggle="collapse">Mitochondrial processes</a>
                </h3>
                <div id="pathway-mitochondrial-processes" class="collapse">
                    <div class="card-body">
                        <?php if (!empty($pathway->getMitochondrialProcessesAsArray())): ?>
                        <ul class="list-inline">
                            <?php foreach ($pathway->getMitochondrialProcessesAsArray() as $process): ?>
                            <li class="list-inline-item">
                                <a href="/category/<?= str_replace(['/', '+'], ['---0', '---1'], $process->getName()) ?>"><?= $process->getName() ?></a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php else: ?>
                        Not involved in any mitochondrial process.
                        <?php endif; ?>
                    </div>
                </div>
            </section>
            
            
            <section class="card mb-3">
                <h3 class="card-header">
                    <a href="#pathway-mitochondrial-steps" data-toggle="collapse">Demonstrative and biological steps</a>
                </h3>
                <div id="pathway-mitochondrial-steps" class="collapse">
                    <div class="card-body pathway-steps"></div>
                </div>
            </section>
            
            
            <section class="card mb-3">
                <div class="card-header">
                    <div class="float-right">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-secondary btn-sm pathway-dynamic-view-back">&laquo; backward</button>
                            <button type="button" class="btn btn-secondary btn-sm pathway-dynamic-view-start">start</button>
                            <button type="button" class="btn btn-secondary btn-sm pathway-dynamic-view-stop">stop</button>
                            <button type="button" class="btn btn-secondary btn-sm pathway-dynamic-view-next">forward &raquo;</button>
                        </div>
                    </div>
                    <h3>Dynamic view</h3>
                </div>
                <?php $this->view('pathway-legend'); ?>
                <div id="dynamic-view" class="card-body pathway-dynamic-view"></div>
                <div class="pathway-dynamic-view-step"></div>
            </section>

            <section class="card mb-3">
                <h3 class="card-header">
<!--
                    <div class="float-right">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-secondary btn-sm pathway-dynamic-mitolocation-back">&laquo; backward</button>
                            <button type="button" class="btn btn-secondary btn-sm pathway-dynamic-mitolocation-start">start</button>
                            <button type="button" class="btn btn-secondary btn-sm pathway-dynamic-mitolocation-stop">stop</button>
                            <button type="button" class="btn btn-secondary btn-sm pathway-dynamic-mitolocation-next">forward &raquo;</button>
                        </div>
                    </div>
-->
                    Dynamic mito-location
                </h3>
                <div class="card-body row">
                    <?php
                        $dbh = new \PDO('mysql:dbname=mitopaths;host=localhost', 'mitopaths', 'uX<z/f54m=[4x9c');
                        $sth = $dbh->prepare('SELECT type, value FROM pathway_attribute WHERE pathway_name = :pathway_name AND name LIKE "image-%" ORDER BY name');
                        $sth->execute([':pathway_name' => $pathway->getName()]);
                        $images = $sth->fetchAll();
                    ?>

                    <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel" style="margin: auto">
                      <ol class="carousel-indicators">
                        <?php for ($i = 0; $i < count($images); ++$i): ?>
                        <li data-target="#carouselExampleIndicators" data-slide-to="<?= $i ?>"></li>
                        <?php endfor; ?>
                      </ol>
                      <div class="carousel-inner">
                        <?php for ($i = 0; $i < count($images); ++$i): ?>
                        <div class="carousel-item <?php if ($i == 0) echo "active"; ?>">
                            <img class="d-block w-100" src="data:<?= $images[$i]['type'] ?>;base64,<?= base64_encode($images[$i]['value']) ?>">
                            <div class="carousel-caption d-none d-md-block">
                              <h5><?= $i + 1 ?></h5>
                            </div>
                        </div>
                        <?php endfor; ?>
                      </div>
                      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                      </a>
                    </div>
                </div>
            </section>

        </main>
        
        <?php $this->view('footer'); ?>
        
        <?php $this->view('scripts'); ?>
        
        <!-- vis graph library -->
        <?php $this->view('script', ['url' => 'https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis.min.js']); ?>
        
        <?php
        $this->view('script', ['url' => '/public/js/graph.js']);
        $this->view('script', ['url' => '/public/js/pathway-to-string.js']);
        $this->view('script', ['url' => '/public/js/pathway-to-dag.js']);
        $this->view('script', ['url' => '/public/js/pathway.js']);
        ?>
    </body>
</html>
