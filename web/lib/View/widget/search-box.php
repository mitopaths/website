<form id="search-box">
    <?php foreach ($filter_type as $type): ?>
    <input type="hidden" name="filter_type[]" value="<?= $type ?>">
    <?php endforeach; ?>
    
    <?php foreach ($filter_category as $category): ?>
    <input type="hidden" name="filter_category[]" value="<?= $category ?>">
    <?php endforeach; ?>
    
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">New search:</span>
            </div>
            <input type="text" name="q" class="form-control" placeholder="Search query..." value="<?= $result['q'] ?>" required>
            <div class="input-group-append">
                <button class="btn btn-primary">Search</button>
            </div>
        </div>
    </div>
</form>
