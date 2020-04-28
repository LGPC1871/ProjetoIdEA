<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$diretorio = base_url();
?>
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
                    <hr />
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?=$diretorio?>user">Conta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=$diretorio?>user/register">Cadastrar</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>