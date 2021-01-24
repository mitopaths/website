<div class="card">
    <div class="card-body">
        <dl>
            <dt>
                Lost functionalities (<?= count($mutated_protein->getLostFunctionsAsArray()) ?>):</dt>
            <dd>
                <?php if (!empty($mutated_protein->getLostFunctionsAsArray())): ?>
                <ul class="list-inline">
                    <?php foreach ($mutated_protein->getLostFunctionsAsArray() as $function): ?>
                    <li class="list-inline-item">
                        <?= $function->getName() ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <p>None known.</p>
                <?php endif; ?>
            </dd>
        
            <dt>
                Gained functionalities (<?= count($mutated_protein->getGainedFunctionsAsArray()) ?>):
            </dt>
            <dd>
                <?php if (!empty($mutated_protein->getGainedFunctionsAsArray())): ?>
                <ul class="list-inline">
                    <?php foreach ($mutated_protein->getGainedFunctionsAsArray() as $function): ?>
                    <li class="list-inline-item">
                        <?= $function->getName() ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <p>None known</p>
                <?php endif; ?>
            </dd>
        
            <dt>
                Associated pathologies (<?= count($mutated_protein->getPathologiesAsArray()) ?>):
            </dt>
            <dd>
                <?php if (!empty($mutated_protein->getPathologiesAsArray())): ?>
                <ul class="list-inline">
                    <?php foreach ($mutated_protein->getPathologiesAsArray() as $pathology): ?>
                    <li class="list-inline-item">
                        <?= $pathology->getName() ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <p>None known</p>
                <?php endif; ?>
            </dd>

            <?php if (!empty($mutated_protein->getAttributesAsArray())): ?>
            <?php foreach ($mutated_protein->getAttributesAsArray() as $key => $value): ?>
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

