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
                        <h3>DEFINIR SENHA</h3>
                        <hr />
                        Defina sua senha:
                    </div>
                    <div class="form-group text-center">
                        <div class="helper no-error">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" class="form-control" name="senha" id="password" placeholder="Digite sua senha">
                    </div>
                    <div class="form-group">
                        <label for="confirma">Confirmar Senha</label>
                        <input type="password" class="form-control" name="confirma" id="passwordConfirm" placeholder="Confirme sua Senha">
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary" name="submit" id="btnSubmit">Enviar Senha</button>
                        <small id="passwordInfo" class="form-text text-muted"><a href="<?=$diretorio?>user/login">VOLTAR</a></small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>