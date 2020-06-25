<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<main class="flex-fill d-flex justify-content-center">
    <div class="d-flex flex-column p-4">
        <div class="text-center text-uppercase mt-4 mb-4">
            <h2>PROFILE</h2>
        </div>
        <div class="d-flex flex-column">
            <div class="align-self-center">
                <img id="picture" class="rounded-circle" src="teste" alt="">
            </div>
            <div class="align-self-center text-center">
                TESTE
            </div>
            <div class="align-self-center text-center text-muted">
                <small>TESTE</small>
            </div>
            <a href="<?=$diretorio?>login/endSession" class="align-self-center text-center btn btn-danger m-2">
                SAIR
            </a>
        </div>
        <div class="mt-4">
            <ul class="nav nav-tabs justify-content-center">
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#participante" role="tab" aria-controls="3" aria-selected="true">TESTE</a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade" id="participante" role="tabpanel" aria-labelledby="tab-participante">TESTE</div>
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