<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<main class="flex-fill d-flex justify-content-center">
    <div class="d-flex flex-column p-4">
        <div class="text-center text-uppercase p-4">
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
                        <a class="nav-link active" href="#">Participar</a>
                    </li>
                <?php endif ?>
                <?php if($privilegio->getId() <= 2): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Palestrar</a>
                    </li>
                <?php endif ?>
                <?php if($privilegio->getId() == 1): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Administrar</a>
                    </li>
                <?php endif ?>
            
                <!--<li class="nav-item">
                    <a class="nav-link active" href="#">TESTE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">TESTE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">TESTE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">TESTE</a>
                </li>-->
            </ul>
        </div>
    </div>

</main>