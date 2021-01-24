<form id="search-panel-form" class="card text-white bg-dark mb-3">
    <div class="card-header">Filter by type</div>
    <div class="card-body">
        <input type="hidden" name="q" value="<?= $result['q'] ?>">
        <?php foreach ($filter_category as $category): ?>
        <input type="hidden" name="filter_category[]" value="<?= $category ?>">
        <?php endforeach; ?>
        
        <div class="form-check">
            <input type="checkbox" name="filter_type[]" value="protein" id="search-panel-form-proteins" class="form-check-input" <?= in_array('protein', $filter_type) ? 'checked' : '' ?>>
            <label class="form-check-label" for="search-panel-form-proteins">
                Proteins
            </label>
        </div>
        
        <div class="form-check">
            <input type="checkbox" name="filter_type[]" value="mutated_protein" id="search-panel-form-mutated-proteins" class="form-check-input" <?= in_array('mutated_protein', $filter_type) ? 'checked' : '' ?>>
            <label class="form-check-label" for="search-panel-form-mutated-proteins">
                Protein variants
            </label>
        </div>
        
        <div class="form-check">
            <input type="checkbox" name="filter_type[]" value="pathway" id="search-panel-form-pathway" class="form-check-input" <?= in_array('pathway', $filter_type) ? 'checked' : '' ?>>
            <label class="form-check-label" for="search-panel-form-pathway">
                Pathways
            </label>
        </div>
        
        <div class="form-check">
            <input type="checkbox" name="filter_type[]" value="mutated_pathway" id="search-panel-form-mutated-pathways" class="form-check-input" <?= in_array('mutated_pathway', $filter_type) ? 'checked' : '' ?>>
            <label class="form-check-label" for="search-panel-form-mutated-pathways">
                Deregulated pathways
            </label>
        </div>
        
        <div class="form-check">
            <input type="checkbox" name="filter_type[]" value="category" id="search-panel-form-categories" class="form-check-input" <?= in_array('category', $filter_type) ? 'checked' : '' ?>>
            <label class="form-check-label" for="search-panel-form-categories">
                Mitochondrial processes
            </label>
        </div>
        
    </div>
    <div class="card-footer text-right">
        <button class="btn btn-light btn-sm">Apply filter</button>
    </div>
</form>
