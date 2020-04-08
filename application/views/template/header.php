<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$diretorio = base_url();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <script type="text/javascript" src="<?=$diretorio?>/public/js/jquery.js"></script>
    <script type="text/javascript" src="<?=$diretorio?>/public/js/bootstrap.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=$diretorio?>/public/css/bootstrap/bootstrap.css">
    <!--Font Awesome-->
    <script src="https://kit.fontawesome.com/09f0e3d5de.js" crossorigin="anonymous"></script>
    <!--Custom CSS stylesheet-->
    <link rel="stylesheet" href="<?=$diretorio?>/public/css/custom/style.css">
    <!--<link rel="stylesheet" href="<?=$diretorio?>/public/css/custom/login.css">-->
    <link rel="stylesheet" href="<?=$diretorio?>/public/css/custom/header.css">
    <link rel="stylesheet" href="<?=$diretorio?>/public/css/custom/main.css">
    <link rel="stylesheet" href="<?=$diretorio?>/public/css/custom/footer.css">
    <!--Custom Unique CSS stylesheet-->
    <?php if(isset($styles)): ?>
        <?php foreach($styles as $style_name): ?>
            <?php $href = base_url() . "public/css/custom/" . $style_name ?>
            <link href="<?=$href?>" rel="stylesheet">
        <?php endforeach ?>
    <?php endif ?>

    <title>IdEA</title>
</head>
<body>
    <!--Navigation-->
    <header>
        <nav class="navbar navbar-expand-sm navbar-light bg-dark">      
            <div class="container" id="navbar-div">
                
                <a href="<?=$diretorio?>main" class="navbar-brand" id="logo">
                    <div id="logo-div">
                        <img src="<?=$diretorio?>/public/images/logo.svg" alt="Logo Principal">
                    </div>              
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation" id="botao-navbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse bg-dark ml-auto" id="menu">
                    <hr>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?=$diretorio?>eventos" >Eventos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=$diretorio?>Admin" >Área Restrita</a>
                        </li>
                    </ul>
                </div>

            </div>
        </nav>
    </header>