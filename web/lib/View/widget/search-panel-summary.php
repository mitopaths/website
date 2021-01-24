<div class="card mb-3">
    <div class="card-header">
        Result summary
    </div>
    <div class="card-body">
        <p class="card-text"><?= $result['results'] ?> results:</p>
        <ul>
            <?php foreach ($result['facet_fields']['type_facet'] as $type => $count): ?>
            <?php if ($count > 0): ?>
            <li><?= str_replace(['mutated protein', 'mutated pathway'], ['protein variant', 'deregulated pathway'], str_replace("_", " ", $type)) . ": " . $count ?></li>
            <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
