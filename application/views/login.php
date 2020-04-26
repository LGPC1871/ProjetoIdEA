<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$diretorio = base_url();
?>
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 col-10" id="div-form">
                <form action="" method="post" id="loginForm">
                    <div class="form-group text-center">
                        <h3>ENTRAR</h3>
                        <hr>
                        <div class="g-signin2" data-onsuccess="onSignIn" data-longtitle="true" data-theme="dark" id="botaoLoginGoogle">Google Login</div>
                    </div>
                    <div class="form-group text-center">
                        <h6>OU</h6>
                        <div class="login-helper no-error">
                            <span class="help-block">Insira suas Credenciais</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Digite seu email">
                    </div>
                    <div class="form-group">
                        <label for="password">Senha</label>
                        <input type="password" class="form-control" name="password" id="senha" aria-describedby="passwordInfo" placeholder="Digite sua senha">
                        <small id="passwordInfo" class="form-text text-muted">Não compartilhe sua senha com ninguém</small>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary" name="loginSubmit" id="botaoLogin" value="login">Entrar</button>
                        <small id="passwordInfo" class="form-text text-muted">Não está registrado? <a href="<?=$diretorio?>user/register">clique aqui</a>.</small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>