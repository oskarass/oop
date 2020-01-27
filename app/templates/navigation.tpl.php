<nav>
    <?php foreach ($data['left'] ?? [] as $field_id => $field): ?>
        <div class="left">
            <a class="link" href="<?php print $field['url'];?>"><?php print $field['title']; ?></a>
        </div>

    <?php endforeach; ?>
    <div class="right">
        <?php foreach ($data['right'] ?? [] as $field_id => $field): ?>
                <a class="link" href="<?php print $field['url'];?>"><?php print $field['title']; ?></a>
        <?php endforeach; ?>
    </div>
</nav>
