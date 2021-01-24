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
?>
<article class="mb-3">
    <h4 class="mb-0">
        <a href="/category/<?= str_replace(['/', '+'], ['---0', '---1'], $item['name']) ?>"><?= $name ?></a>
    </h4>
    <small class="text-muted">type: category.</small>
    <p><?= $description ?></p>
</article>
