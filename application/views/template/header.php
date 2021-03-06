<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if($this->session->userdata("logged")){
    $cabecalho = array(
        'nome' => $this->session->userdata("nome"),
        'foto' => $this->session->userdata("thirdData")['picture']
    );
}

?>
<body>
<div id="body-flex" class="d-flex flex-column">
    <header>
        <div class="d-flex flex-column">
            <div id="header" class="d-flex flex-column flex-sm-row">
                <div id="logo" class="p-2 d-flex mr-sm-auto">
                    <div class="text-center align-self-stretch flex-fill">
                        <img src="<?=$diretorio?>public/images/unicamp-logo-dark.svg" alt="logo unicamp">
                    </div>
                    <div class="text-center align-self-stretch flex-fill">
                        <img src="<?=$diretorio?>public/images/logo_idea.png" alt="logo unicamp">
                    </div>
                </div>
                <div id="profile-header" class="p-2 d-flex justify-content-center align-self-center align-items-center ml-sm-auto">
                    <?php if(isset($cabecalho)): ?>
                        <!--USUARIO LOGADO-->
                        <a class="d-flex align-items-center"href="<?=$diretorio?>profile">
                            <img class="rounded-circle" src="<?=$cabecalho['foto']?>" alt="">
                            &nbsp
                            <span><?=$cabecalho['nome']?></span>
                        </a>
                    <?php else:?>
                        <a href="<?=$diretorio?>login"><i class="far fa-user-circle fa-lg"></i>&nbsp ENTRAR</a>
                    <?php endif ?>
                </div>
            </div>
            <div id="header-nav" class="d-flex flex-column">
                <nav class="col-12 navbar navbar-expand-md navbar-dark bg-dark">
                    <div class="container-fluid justify-content-center">
                        <div class="row justify-content-center">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
                                <ul class="navbar-nav text-center">
                                    <li class="nav-item active">
                                        <a class="nav-link" href="<?=$diretorio?>">HOME <span class="sr-only">(current)</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>