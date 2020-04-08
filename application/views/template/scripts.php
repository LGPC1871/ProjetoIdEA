<?php if(isset($scripts)): ?>
    <?php foreach($scripts as $script_name): ?>
        <?php $src = base_url() . "public/js/custom/" . $script_name ?>
        <script src="<?=$src?>"></script>
    <?php endforeach ?>
<?php endif ?>