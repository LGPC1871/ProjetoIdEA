<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Language" content="pt-br">
    <meta charset="UTF-8">
    <meta name="google-signin-client_id" content="482205672789-flab0s8c0o2q5844v4h1mqlgdagcmvuj.apps.googleusercontent.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Styles-->
    <?php if(isset($styles)): ?>
        <?php foreach($styles as $style_name): ?>
            <?php $href =$diretorio . "public/css/custom/" . $style_name ?>
            <link href="<?=$href?>" rel="stylesheet" />
        <?php endforeach ?>
    <?php endif ?>
    <link rel="stylesheet" href="<?=$diretorio?>public/css/template/body.css" />
    <link rel="stylesheet" href="<?=$diretorio?>public/css/template/header.css" />
    <link rel="stylesheet" href="<?=$diretorio?>public/css/template/main.css" />
    <link rel="stylesheet" href="<?=$diretorio?>public/css/template/footer.css" />
    <!--Bootstrap-->
    <link rel="stylesheet" href="<?=$diretorio?>vendor/twbs/bootstrap/dist/css/bootstrap.css" />
    <!--Font Awesome-->
    <link rel="stylesheet" href="<?=$diretorio?>vendor/fortawesome/font-awesome/css/all.css" />
    <!--Scripts-->
    <?php if(isset($head_scripts)): ?>
        <?php foreach($head_scripts as $hscript): ?>
            <script src="<?=$hscript?>"></script>
        <?php endforeach?>
    <?php endif ?>
    <script type="text/javascript">
        const BASE_URL = "<?php echo base_url();?>";
    </script>
    <!--JQuery-->
    <script type="text/javascript" src="<?=$diretorio?>vendor/components/jquery/jquery.js"></script>
    <!--Bootstrap-->
    <script type="text/javascript" src="<?=$diretorio?>vendor/twbs/bootstrap/dist/js/bootstrap.js"></script>

    <link rel="shortcut icon" href="<?=$diretorio?>public/images/favicon.ico" />
    <title>IdEA</title>
</head>