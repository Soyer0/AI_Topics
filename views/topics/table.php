<button id="addTopicBtn" class="btn btn-custom">
    <i class="fas fa-plus"></i> Add Topic
</button>

<?php if (!empty($columns)): ?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <?php foreach ($columns as $label): ?>
                <th><?= htmlspecialchars($label) ?></th>
            <?php endforeach; ?>
            <th>Options</th>
        </tr>
        </thead>
        <tbody id="topicTableBody">
        <?php if (!empty(array_filter($topics))): ?>
            <?php foreach ($topics as $topic): ?>
                <?php
                $rowClass = ((int)$topic->active === 1) ? 'table-success' : 'table-danger';
                ?>
                <tr class="clickable-row <?= $rowClass ?>" data-topic_id="<?= $topic->id ?>">
                    <?php foreach ($columns as $column): ?>
                        <td class="<?= htmlspecialchars($column) ?>">
                            <?php
                            $value = $topic->$column ?? null;
                            echo $value !== null && trim((string)$value) !== '' ? htmlspecialchars((string)$value) : '-';
                            ?>
                        </td>
                    <?php endforeach; ?>
                    <td>
                        <?php if (!$topic->active): ?>
                            <button class="btn btn-sm btn-success activate-btn" title="Activate">
                                <i class="fas fa-check text-white"></i>
                            </button>
                        <?php else: ?>
                            <button class="btn btn-sm btn-danger deactivate-btn" title="Deactivate">
                                <i class="fas fa-times text-white"></i>
                            </button>
                        <?php endif; ?>
                        <button class="btn btn-sm btn-secondary delete-btn" title="Delete">
                            <i class="fas fa-trash text-white"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
<?php endif; ?>

<script>
    window.topicColumns = <?= json_encode($columns) ?>;
</script>