<?php
if (in_array('pathway', $filter_type)
 || in_array('mutated_pathway', $filter_type)
):
?>
<form id="search-panel-form-categories" class="card text-white bg-dark mb-3">
    <div class="card-header">Filter pathways by mitochondrial process</div>
    <div class="card-body">
        <input type="hidden" name="q" value="<?= $result['q'] ?>">
        <?php foreach ($filter_type as $type): ?>
        <input type="hidden" name="filter_type[]" value="<?= $type ?>">
        <?php endforeach; ?>
        
        
        <?php foreach ($result['facet_fields']['category_facet'] as $category => $count): ?>
        <div class="form-check">
            <input type="checkbox" name="filter_category[]" value="<?= $category ?>" id="search-panel-form-categories-<?= $category ?>" class="form-check-input" <?= in_array($category, $filter_category) ? 'checked' : '' ?>>
            <label class="form-check-label" for="search-panel-form-categories-<?= $category ?>">
                <?= $category . ": " . $count ?>
            </label>
        </div>
        <?php endforeach; ?>
        
        
    </div>
    <div class="card-footer text-right">
        <button class="btn btn-light btn-sm">Apply filter</button>
    </div>
</form>
<?php endif; ?>
