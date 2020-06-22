<?php if(isset($scripts)): ?>
    <?php foreach($scripts as $script_name): ?>
        <?php if(filter_var($script_name, FILTER_VALIDATE_URL)): ?>
            <script src="<?=$script_name?>"></script>
        <?php else: ?>
            <?php $src = base_url() . "public/js/custom/" . $script_name ?>
            <script src="<?=$src?>"></script>
        <?php endif ?>
    <?php endforeach ?>
<?php endif ?>