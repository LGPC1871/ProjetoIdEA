<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<main class="flex-fill d-flex justify-content-center">
    <div class="d-flex flex-column p-4">
        <div class="text-center text-uppercase mt-4 mb-4">
            <h2>área do <?=$privilegio->getNome()?></h2>
        </div>
        <div class="d-flex flex-column">
            <div class="align-self-center">
                <img id="picture" class="rounded-circle" src="<?=$thirdInfo["picture"]?>" alt="">
            </div>
            <div class="align-self-center text-center">
                <?=$pessoa->getNome() . " " . $pessoa->getSobrenome()?>
            </div>
            <div class="align-self-center text-center text-muted">
                <small><?=$pessoa->getEmail()?></small>
            </div>
            <a href="<?=$diretorio?>user/endSession" class="align-self-center text-center btn btn-danger m-2">
                SAIR
            </a>
        </div>
        <div class="mt-4">
            <ul class="nav nav-tabs justify-content-center">
                <?php if($privilegio->getId() <= 3): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#participante" role="tab" aria-controls="3" aria-selected="true">Participar</a>
                    </li>
                <?php endif ?>
                <?php if($privilegio->getId() <= 2): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#palestrante" role="tab" aria-controls="2" aria-selected="false">Palestrar</a>
                    </li>
                <?php endif ?>
                <?php if($privilegio->getId() == 1): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#administrador" role="tab" aria-controls="1" aria-selected="false">Administrar</a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
        <div class="tab-content">
            <?php if($privilegio->getId() <= 3): ?>
                <div class="tab-pane fade" id="participante" role="tabpanel" aria-labelledby="tab-participante"></div>
            <?php endif ?>
            <?php if($privilegio->getId() <= 2): ?>
                <div class="tab-pane fade" id="palestrante" role="tabpanel" aria-labelledby="tab-palestrante"></div>
            <?php endif ?>
            <?php if($privilegio->getId() == 1): ?>
                <div class="tab-pane fade" id="administrador" role="tabpanel" aria-labelledby="tab-administrador"></div>
            <?php endif ?>
        </div>
    </div>
    <!--No display-->
    <div id="tab-loading" class="d-none">
        <div class="d-flex text-center justify-content-center mt-4 text-muted">
            <span class="spinner-border spinner-border-sm align-self-center" role="status" aria-hidden="true"></span>
            <span class="align-self-center">&nbsp Carregando...</span>
        </div>
    </div>
</main>