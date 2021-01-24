<div class="container">
    <div class="jumbotron">
        <h2 class="display-4">MitopatHs</h2>
        <p class="lead">
            The logic of mitochondria
        </p>
        
        <hr class="my-4">
        
        <p>
            MitopatHs is a database that allows <em><strong>to navigate among the <strong>biochemical pathways (PatHs) of human (H)  mitochondria (Mito)</strong>. </strong></em>
        </p>
        <p>
            The tool core is Zsyntax, a logical system that precisely and rigorously represents biochemical processes of any lenght as deductive processes. In this formal representation, biochemical transitions from an initial molecular aggregate to a final molecular aggregate are considered as logical theorems leading form an initial premise to a conclusion.
        </p>

        <div class="row">
            <div class="col-md-12">
                <p>
                    On that basis, mitochondrial pathways collected in MitopatHs are presented in two ways:
                </p>
            </div>

            <div class="col-md-6">
                <p>
                    1) <strong>as a <em>"biological theorem"</em></strong>, whose proof can be scrutinized by observing the list of biological steps involved in the pathwhay, orgnaized and encoded as logical deductions;
                </p>
            </div>

            <div class="col-md-6">
                <p>
                    2) <strong>as a (dynamically growing) graph</strong>, that allows to intuitively visualize the process of building final molecular compounds from initial molecular aggregates. There are two kind of visualizations:
                </p>
                <ul>
                  <li><strong>Dynamic View</strong> (a time visualization). It represents the successive biochemical steps from the initial molecular aggregate to the final molecular aggregate;</li>
                  <li><strong>Dynamic Mito_Location</strong> (a space visualization). It presents the same successive biochemical steps by considering the locations of the involved molecules in the mitochondrial compartments (outer membrane, matrix, inter-membrane space, inner membrane)</li>
                </ul>
            </div>


            <div class="col-md-12">
                <p>
                    In addition, given a mitochondrial pathway, MithopatHs provides information on the existing <strong>deregulated variants</strong> and on the proteins (and the genes) involved by a link to their corresponding entry on  the Gene Ontology database.
                </p>
                
                <p>
                    See <a href="/guide">The Uniporter Example</a> for a detailed explanation of mitopatHs.
                </p>
            </div>
        </div>
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="/guide" role="button">Learn more through an example</a>
        </p>
    </div>

    <p>
        MitopatHs emphasizes an operational view of <em>Zsyntax</em> for the working biologist, while a detailed formal account of the logical system can be found in:
    </p>
    <ol>
        <li>
            G. Boniolo, M. D'Agostino, P. Di Fiore. Zsyntax: a formal language for molecular biology with projected pplications in text mining and biological prediction. <i>PloS one, 5(3):e9511, 2010.</i>
        </li>

        <li>
            G. Boniolo, M. D'Agostino, M. Piazza, G. Pulcini. Adding logic to the toolbox of molecular biology. <i>European Journal for Philosophy of Science, 5(3):399–417, 10 2015.</i>
        </li>

        <li>
            F.Sestini, S.Crafa. Proof search in a context-sensitive logic for molecular biology. <i>Journal of Logic and Computation, 28(7):1565-1600, 2018.</i>
        </li>
    </ol>
</div>
