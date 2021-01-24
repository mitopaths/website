<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <title>Mitopaths</title>
        
        <?php $this->view('head'); ?>
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
                    <li class="breadcrumb-item active" aria-current="page">Guide</li>
                </ol>
            </nav>
        </header>
        
        <main class="container">
            <h2>Guide</h2>
            <div class="row">
                <div class="col-md-12">
                    <p>
                        To explain how to read the logical information provided by
                        <strong>MitopatHs</strong>, we illustrate the case of the 
                        <a href="http://amigo.geneontology.org/amigo/gene_product/UniProtKB:Q8NE86" target="_blank">Uniporter pathway</a>.  
                        The biological steps leading to the formation of the <a href="/pathway/Uniplex%20Assembly">Uniplex</a>
                        complex are represented as the following steps which are the logical representation (in Zsyntax language) of the biochemical reactions really occurring:
                    </p>
                </div>

                <div class="col-md-12 text-center">
                    <img src="/public/images/example-steps.png" alt="Explanation of Uniporter's Steps" class="img-fluid">
                </div>

                <div class="col-md-12">
                  where 
                  <ul>
                    <li><strong>&amp;</strong> denotes the juxtaposition of two resources (i.e. molecules);</li>
                    <li><strong>*</strong> denotes the binding of two resources to form a complex;</li>
                    <li><strong>()</strong>, i.e. the parenthesis, are used to define complexes that contain sub-complexes, as Uniplex sub-complex (MCUR1 * MCU);</li>
                    <li><strong>⇒</strong> denotes a biological step</li>
                  </ul>
                </div>

                <div class="col-md-12">
                    <p>The steps above can be read as follows:</p>
                    <ol>
                        <li>
                            given a protein CCDC109B <strong>and</strong> (&amp;) a protein MCU, <strong>they react</strong> (⇒)
                            producing the <strong>complex</strong> (CCDC109B * MCU); the bond between the 2 proteins of the complex is represented by *;
                        </li>

                        <li>
                            given the complex (CCDC109B * MCU) <strong>and</strong> (&amp;)
                            a protein SMDT1, <strong>they react</strong> (⇒) producing
                            the complex (CCDC109B * MCU * SMDT1); each bond between the 3 proteins of the complex is represented by *;
                        </li>

                        <li>
                            the previous complex <strong>and</strong> (&amp;) MICU1 <strong>react</strong> (⇒) producing the
                            complex (CCDC109B * MCU * SMDT1 * MICU1); each bond between the 4 proteins of the complex is represented by *;
                        </li>

                        <li>
                            the previous complex <strong>and</strong> (&amp;) CHCHD4 <strong>react</strong> (⇒) producing the
                            complex (CCDC109B * MCU * SMDT1 * MICU1 * CHCHD4); each bond between the 5 proteins of the complex is represented by *;
                        </li>

                        <li>
                            the previous complex <strong>and</strong> (&amp;) MICU2 <strong>react</strong> (⇒) producing
                            the complex (CCDC109B * MCU * SMDT1 * MICU1 * MICU2 * CHCHD4); each bond between the 6 proteins of the complex is represented by *;
                        </li>

                        <li>
                            CHCHD4 separates from the previous complex (⇒) producing the complex (CCDC109B * MCU * SMDT1 * MICU1 * MICU2) together
                            with (&amp;) <strong>a residual</strong> protein CHCHD4;
                        </li>

                        <li>
                            the previous complex <strong>and</strong> (&amp;) MCUR1 <strong>react</strong> (⇒) producing
                            the complex (CCDC109B * (MCUR1 * MCU) * SMDT1 * MICU1 * MICU2),
                            which corresponds to Uniplex, each bond between the 6 proteins of the complex is represented by *, the brackets allow to represent what is bond with what.
                        </li>
                    </ol>
                </div>

                <div class="col-md-12">
                    <p>
                        The graph-based visualization (the Dynamic View) of these steps interactively
                        illustrates the pathway leading to the formation of Uniplex:
                    </p>
                </div>

                <div class="col-md-7 text-center">
                    <img src="/public/images/example-graph.png" alt="Explanation of Uniporter's Graph" class="img-fluid">
                </div>

                <div class="col-md-5">
                    <p>
                      In this dynamic view,
                    </p>

                    <ul>
                        <li>the <strong>circle</strong> denotes a protein in the initial aggregate,</li>
                        <li>the <strong>star</strong> denotes an intermediate or final complex,</li>
                        <li>the <strong>square</strong> denotes a residual protein.</li>
                    </ul>

                   <p>
                       The graph-based visualization illustrates which proteins in the initial aggregate bind to form an intermediate complex. In this view, the circle denotes a simple protein, the star denotes an intermediate or final complex, and the square denotes a residual protein. Colours denote the position of proteins and complex into the mitochondrion: red for the matrix, yellow for the internal membrane, green for the inter-membrane space, blue for the outer membrane and violet for the peri-mitochondrial space. The grey colour is reserved for unknown or irrelevant positions, while a star with multiple colours indicates a protein complex of proteins that occupy different sub-mitochondrial districts. For instance, the uppermost star in the figure corresponds to the complex produced by the 7th step (its full Zsyntax name appears when pointing the mouse over the star, and simple graph rearrangements can be done through mouse dragging). The two edges entering that star show that this complex is the result of the interaction between the aggregate obtained in the previous step and the MCUR1 protein, residing on the mitochondrial matrix.
                    </p>
                </div>

                <div class="col-md-12">
                    <p>
                        All the steps of the Uniporter pathway can be summarized
                        by the following <strong><em>biological theorem</em></strong>
                        (see [1,2,3] for details):

                        <pre><code>MCU &amp; CCDC109B &amp; SMDT1 &amp; MICU1 &amp; CHCHD4 &amp; MICU2 &amp; MICUR1 => (CCDC109B * (MCUR1 * MCU) * SMDT * MICU1 * MICU2)</code></pre>

                        The <em>premise</em> of the theorem, i.e. the
                        left hand side of the =&gt; symbol, lists all the biological
                        resources needed by the pathway, while the <em>conclusion</em>,
                        i.e. the right hand side, describes the final complex. 
                        Actually, the conclusion of the theorem should contain also all
                        the residual resources produced by the pathway, that is it
                        should be <small>Uniplex &amp; CHCHD4</small>, but we omit all the
                        residuals for simplicity, while keeping them in the graph
                        visualization.
                    </p>

                    <p>
                        <strong>NOTE:</strong> whenever multiple occurrences
                        of the same resource are needed in a pathway, the premise of
                        the corresponding theorem must explicitly list all the
                        copies. e.g. the theorem <small>P1 &amp; P1 &amp; P2 =&gt; P3</small>  
                        states that <strong>two copies of the protein </strong> P1
                        together with a single copy of protein P2 produce a single copy
                        of the protein P3, as in <a href="/pathway/Complex%20III2%20Assembly">this example (ComplexIII2 Assembly)</a>.
                    </p>

                    <p>
                      The same process has also a different visualization (<strong>Dynamic Mito-Location</strong>) which,
                      step by step, focuses the location of the molecules at stake in the proper mitochondrion compartments.
                      For example, always considering <a href="/pathway/Uniplex%20Assembly">Uniporter pathway</a>, we have (from the initial Step 0 to the final Step 6):
                    </p>
                    <?php
                        $dbh = new \PDO('mysql:dbname=mitopaths;host=localhost', 'mitopaths', 'uX<z/f54m=[4x9c');
                        $sth = $dbh->prepare('SELECT type, value FROM pathway_attribute WHERE pathway_name = :pathway_name AND name LIKE "image-%" ORDER BY name');
                        $sth->execute([':pathway_name' => 'Uniplex Assembly']);
                        $images = $sth->fetchAll();
                    ?>

                    <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel" style="margin: auto; width: 60%;">
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
            </div>
        </main>
        
        <?php $this->view('footer'); ?>
        
        <?php $this->view('scripts'); ?>
    </body>
</html>
