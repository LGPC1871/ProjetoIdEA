<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$diretorio = base_url();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="google-signin-client_id" content="482205672789-flab0s8c0o2q5844v4h1mqlgdagcmvuj.apps.googleusercontent.com">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <!--Head Scripts-->
    <?php if(isset($headScripts)): ?>
        <?php foreach($headScripts as $hscript): ?>
            <script src="<?=$hscript?>"></script>
        <?php endforeach?>
    <?php endif ?>
    <base href="<?=$diretorio?>/">
    <script type="text/javascript" src="public/js/jquery.js"></script>
    <script type="text/javascript" src="public/js/bootstrap.js"></script>
    <link rel="stylesheet" href="public/css/bootstrap/bootstrap.css">
    <!--Font Awesome-->
    <link rel="stylesheet" href="vendor/fortawesome/font-awesome/css/all.css">
    <!--Custom CSS stylesheet-->
    <link rel="stylesheet" href="public/css/custom/style.css">
    <link rel="stylesheet" href="public/css/custom/header.css">
    <link rel="stylesheet" href="public/css/custom/main.css">
    <link rel="stylesheet" href="public/css/custom/footer.css">
    
    <!--Custom Unique CSS stylesheet-->
    <?php if(isset($styles)): ?>
        <?php foreach($styles as $style_name): ?>
            <?php $href ="public/css/custom/" . $style_name ?>
            <link href="<?=$href?>" rel="stylesheet">
        <?php endforeach ?>
    <?php endif ?>

    <title>IdEA</title>
</head>
<body>