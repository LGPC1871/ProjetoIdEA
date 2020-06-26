<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<main class="flex-fill d-flex justify-content-center">
    <div class="d-flex flex-column p-4">
        <div class="text-center text-uppercase mt-4">
            <h2>PERFIL</h2>
        </div>
        <div class="d-flex flex-column">
            <div class="align-self-center">
                <?php if(isset($thirdData['picture'])): ?>
                    <img id="picture" class="rounded-circle" src="<?=$thirdData['picture']?>" alt="">
                <?php else:?>
                    <img id="picture" class="rounded-circle" src="<?=$diretorio?>/public/images/user/user-icon.svg" alt="">
                <?php endif ?>
            </div>
            <div class="align-self-center text-center">
                <span id="nome">
                    <h3>
                        <?=$pessoa->getNomeCompleto()?>
                    </h3>
                </span>
            </div>
            <div class="align-self-center text-center text-muted">
                <span id="email" class="text-muted">
                    <h5>
                        <?=$pessoa->getEmail()?>
                    </h5>
                </span>
            </div>
            <a href="<?=$diretorio?>login/endSession" class="align-self-center text-center btn btn-danger m-2">
                SAIR
            </a>
        </div>
        <?php if(isset($privilegios)): ?>
        <div class="mt-4">
            <ul class="nav nav-tabs justify-content-center">
                <?php foreach($privilegios as $privilegio): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#<?=$privilegio?>" role="tab" aria-controls="3" aria-selected="true"><?=$privilegio?></a>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
        <div class="tab-content">
            <?php foreach($privilegios as $privilegio): ?>
                <div class="tab-pane fade" id="<?=$privilegio?>" role="tabpanel" aria-labelledby="tab-participante"><?=$privilegio?></div>
            <?php endforeach ?>
        </div>
        <?php endif ?>
    </div>
    <!--No display-->
    <div id="tab-loading" class="d-none">
        <div class="d-flex text-center justify-content-center mt-4 text-muted">
            <span class="spinner-border spinner-border-sm align-self-center" role="status" aria-hidden="true"></span>
            <span class="align-self-center">&nbsp Carregando...</span>
        </div>
    </div>
</main>