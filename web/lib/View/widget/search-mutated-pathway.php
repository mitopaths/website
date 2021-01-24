<?php
$name = $item['name'];
$plain_name = $item['name'];
if (array_key_exists('_highlighting', $item)
    && array_key_exists('name', $item['_highlighting'])
    && !empty($item['_highlighting']['name'])):
    $name = $item['_highlighting']['name'][0];
endif;

$categories = [];
if (array_key_exists('category', $item)):
    foreach ($item['category'] as $category_name):
       $highlighted_name = $category_name;
        if (array_key_exists('category', $item['_highlighting'])):
            foreach ($item['_highlighting']['category'] as $test):
                if (strpos($test, $category_name) !== false) {
                    $highlighted_name = $test;
                    break;
                }
            endforeach;
        endif;

        $categories[] = '<a href="/category/' . $category_name . '">' . $highlighted_name . '</a>';
    endforeach;
endif;

$original = $item['original_pathway'];
if (array_key_exists('_highlighting', $item)
    && array_key_exists('original_pathway', $item['_highlighting'])
    && !empty($item['_highlighting']['original_pathway'])):
    $original = $item['_highlighting']['original_pathway'][0];
endif;
?>
<article class="mb-3">
    <h4 class="mb-0">
        <a href="/pathway/<?= str_replace(['/', '+'], ['---0', '---1'], $plain_name) ?>"><?= $name ?></a>
    </h4>
    <small class="text-muted">type: deregulated pathway, mutation of <a href="/pathway/<?= $item['original_pathway'] ?>"><?= $original ?></a>, <?= count($item['steps']) ?> biological steps.</small>
    <?php if (!empty($categories)): ?>
    <small class="text-muted">
        Involved in: <?= implode(', ', $categories); ?>.
    </small>
    <?php endif; ?>
    <p><?= $item['theorem'] ?></p>
</article>
