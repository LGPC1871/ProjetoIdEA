<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$diretorio = base_url();
?>
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 col-10" id="div-form">
                <form action="" method="post" id="form">
                    <div class="form-group text-center">
                        <h3>ENTRAR</h3>
                        <hr />
                    </div>
                    <div class="form-group text-center">
                        <div class="helper no-error">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <small id="passwordInfo" class="form-text text-muted">É necessário se autenticar antes de continuar</small>
                        Escolha uma forma de autenticação:
                    </div>
                    <div class="form-group text-center">
                        <div class="g-signin2" data-onsuccess="onSignIn" data-longtitle="true" data-theme="dark" id="botaoLoginGoogle" ></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>