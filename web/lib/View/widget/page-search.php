<form action="/search" method="GET" id="main-search-form" class="justify-content-center align-self-center mx-auto">
    <img src="/public/images/logo.png" alt="mitopatHs" class="main-logo mx-auto">
    <h1>mitopatHs <small>&ndash; The logic of mitochondria</small></h1>
    
    <div class="input-group mb-3">
        <input type="text" name="q" id="search-query" class="form-control" placeholder="" required="required">
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </div>

    <div class="form-check form-check-inline">
        Filter by:
    </div>

    <div class="form-check form-check-inline">
        <input type="checkbox" name="search_proteins" id="search-proteins" class="form-check-input" value="true" checked="checked">
        <label class="form-check-label" for="search-proteins" data-toggle="tooltip" data-placement="bottom" title="Find proteins and protein variants matching given query">
            Proteins
        </label>
    </div>

    <div class="form-check form-check-inline">
        <input type="checkbox" name="search_pathways" id="search-pathways" class="form-check-input" value="true" checked="checked">
        <label class="form-check-label" for="search-pathways" data-toggle="tooltip" data-placement="bottom" title="Find pathways and deregulated pathways matching given query">
            Pathways
        </label>
    </div>

    <div class="form-check form-check-inline">
        <input type="checkbox" name="search_processes" id="search-processes" class="form-check-input" value="true" checked="checked">
        <label class="form-check-label" for="search-processes" data-toggle="tooltip" data-placement="bottom" title="Find mitochondrial processes matching given query">
            Mitochondrial processes
        </label>
    </div>

    <div class="form-check form-check-inline">
        <a href="/browse" data-toggle="tooltip" data-placement="bottom" title="See all available pathways and deregulated pathways">or see all available pathways</a>
    </div>

    <div class="form-check form-check-inline">
        <a href="/categories" data-toggle="tooltip" data-placement="bottom" title="See all available mitochondrial processes">or see all available processes</a>
    </div>

    <div class="form-check form-check-inline">
        <a href="/search?q=*&search_proteins=true&filter_type%5B%5D=protein&filter_type%5B%5D=mutated_protein" data-toggle="tooltip" data-placement="bottom" title="See all available proteins">or see all available proteins</a>
    </div>
</form>
