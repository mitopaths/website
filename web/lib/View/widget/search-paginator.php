<?php
$page = $result['page'];
$first_page = 0;
$last_page = ceil($result['results'] / $result['page_size']) - 1;

$is_first_page = $page === $first_page;
$is_last_page = $page == $last_page;

$previous_page = max($page - 1, $first_page);
$next_page = min($page + 1, $last_page);

$from_page = max($page - 5, $first_page);
$to_page = min($from_page + 10, $last_page);

function page_url($page_number) {
    $parameters = $_REQUEST;

    $parameters['page'] = $page_number;
    return http_build_query($parameters);
}
?>
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-end">
        <li class="page-item <?= $is_first_page ? 'disabled' : '' ?>">
            <a class="page-link" href="/search?<?= page_url($previous_page) ?>">&laquo;</a>
        </li>

        <?php for ($i = $from_page; $i <= $to_page; ++$i): ?>
        <li class="page-item <?= $i == $result['page'] ? 'active' : '' ?>"><a class="page-link" href="/search?<?= page_url($i) ?>"><?= ($i + 1) ?></a></li>
        <?php endfor; ?>

        <li class="page-item <?= $is_last_page ? 'disabled' : '' ?>">
            <a class="page-link" href="/search?<?= page_url($next_page) ?>">&raquo;</a>
        </li>
    </ul>
</nav>