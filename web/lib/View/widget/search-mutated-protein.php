<?php
$name = $item['name'];
if (array_key_exists('_highlighting', $item)
    && array_key_exists('name', $item['_highlighting'])
    && !empty($item['_highlighting']['name'])):
    $name = $item['_highlighting']['name'][0];
endif;

$description = $item['description'];
if (array_key_exists('_highlighting', $item)
    && array_key_exists('description', $item['_highlighting'])
    && !empty($item['_highlighting']['description'])):
    $description = $item['_highlighting']['description'][0];
endif;

$original = $item['original_protein'];
if (array_key_exists('_highlighting', $item)
    && array_key_exists('original_protein', $item['_highlighting'])
    && !empty($item['_highlighting']['original_protein'])):
    $original = $item['_highlighting']['original_protein'][0];
endif;
?>
<article class="mb-3">
    <h4 class="mb-0">
        <a href="/molecule/<?= $item['name'] ?>"><?= $name ?></a>
    </h4>
    <small class="text-muted">type: protein variant, mutation of: <a href="/molecule/<?= $item['original_protein'] ?>"><?= $original ?>.</a></small>
    <p><?= $description ?></p>
</article>
