<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<main class="flex-fill d-flex align-items-center">
    <div class="flex-fill d-flex flex-column">
        <div class="border border-gray rounded d-flex align-self-center p-4">
            <form class="flex-fill d-flex flex-column" method="post">
                <div class="form-group text-center">
                    <h3>ENTRAR</h3>
                    <hr />
                </div>
                <div class="form-group text-center">
                    <small id="passwordInfo" class="form-text text-muted">É necessário se autenticar antes de continuar</small>
                    Escolha uma forma de autenticação:
                </div>
                <div class="form-group text-center justify-content-center">
                    <div class="g-signin2 d-flex justify-content-center" data-onsuccess="googleSignIn" data-longtitle="true" data-theme="dark" id="botaoLoginGoogle" ></div>
                </div>
            </form>    
        </div>
    </div>
</main>