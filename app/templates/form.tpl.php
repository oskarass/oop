<form <?php print html_attr(($form['attr'] ?? []) + ['method' => 'POST']); ?>>

    <?php foreach ($form['fields'] ?? [] as $field_id => $field): ?>
    <div>
        <label>
            <span class="label">
                <?php print $field['label'];?>
            </span>
            <input <?php print html_attr(
                ($field['extra']['attr'] ?? []) +
                [
                    'name' => $field_id,
                    'type' => $field['type'],
                    'value' => $field['value'] ?? '',
                ]);
            ?>>
            <?php if (isset($field['error'])): ?>
                <span class="error"><?php print $field['error']; ?></span>
            <?php endif; ?>
        </label>
    </div>
    <?php endforeach; ?>

    <?php foreach ($form['buttons'] ?? [] as $button_id => $button): ?>
    <div>
        <button
            <?php print html_attr(
            $button['extra']['attr'] ?? [] +
            [
                'name' => 'action',
                'value' => $button_id,
            ]);
        ?>>
        <?php print $button['title']; ?>
        </button>
    </div>
    <?php endforeach; ?>

    <?php if(isset($form['message'])) : ?>
        <div>
            <h2><?php print $form['message']; ?></h2>
        </div>
    <?php endif; ?>

</form>
