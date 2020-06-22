<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$diretorio = base_url();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="google-signin-client_id" content="482205672789-flab0s8c0o2q5844v4h1mqlgdagcmvuj.apps.googleusercontent.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!--Head Scripts-->
    <?php if(isset($headScripts)): ?>
        <?php foreach($headScripts as $hscript): ?>
            <script src="<?=$hscript?>"></script>
        <?php endforeach?>
    <?php endif ?>
    <base href="<?=$diretorio?>/" />
    <!--JQuery-->
    <script type="text/javascript" src="vendor/components/jquery/jquery.js"></script>
    <!--Bootstrap-->
    <script type="text/javascript" src="vendor/twbs/bootstrap/dist/js/bootstrap.js"></script>
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.css" />
    <!--Font Awesome-->
    <link rel="stylesheet" href="vendor/fortawesome/font-awesome/css/all.css" />
    <!--Head CSS-->
    <?php if(isset($styles)): ?>
        <?php foreach($styles as $style_name): ?>
            <?php $href ="public/css/custom/" . $style_name ?>
            <link href="<?=$href?>" rel="stylesheet" />
        <?php endforeach ?>
    <?php endif ?>
    <link rel="stylesheet" href="public/css/template/style.css" />
    <link rel="stylesheet" href="public/css/template/header.css" />
    <link rel="stylesheet" href="public/css/template/main.css" />
    <link rel="stylesheet" href="public/css/template/footer.css" />
    
    <link rel="shortcut icon" href="public/images/favicon.ico" />
    <title>IdEA</title>
</head>
<body>