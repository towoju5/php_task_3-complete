<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<items>
    <?php foreach ($items as $item): ?>
        <item>
            <id><?php echo $item->id; ?></id>
            <create_at><?php echo $item->create_at; ?></create_at>
            <widget_name><?php echo $item->widget_name; ?></widget_name>
            <browser_type><?php echo $item->browser_type; ?></browser_type>
        </item>
    <?php endforeach; ?>
</items>
