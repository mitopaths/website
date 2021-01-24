<div class="card">
    <div class="card-body">
        <dl>
            <dt>
                Mutations (<?= count($mutations) ?>):
            </dt>
            <dd>
                <?php if (!empty($mutations)): ?>
                <ul class="list-inline">
                    <?php foreach ($mutations as $mutation): ?>
                    <li class="list-inline-item">
                        <a href="/molecule/<?= $mutation['name'] ?>"><?= $mutation['name'] ?></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                None known.
                <?php endif; ?>
            </dd>

            <?php if (!empty($protein->getAttributesAsArray())): ?>
            <?php foreach ($protein->getAttributesAsArray() as $key => $value): ?>
            <dt><?= $key ?></dt>
            <dd>
                <?php if (filter_var($value, FILTER_VALIDATE_URL)): ?>
                <a href="<?= $value ?>" target="_blank"><?= $value ?></a>
                <?php else: ?>
                <?= $value ?>
                <?php endif; ?>
            </dd>
            <?php endforeach; ?>
            <?php endif; ?>
        </dl>
    </div>
</div>

