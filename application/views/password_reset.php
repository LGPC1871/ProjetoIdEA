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
                        <h3>RECUPERAR SENHA</h3>
                        <hr />
                        Um link para resetar sua senha será enviado para seu email:
                    </div>
                    <div class="form-group text-center">
                        <div class="helper no-error">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="Email" id="email" placeholder="Digite seu email">
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary" name="submit" id="btnSubmit">Enviar Email</button>
                        <small id="passwordInfo" class="form-text text-muted"><a href="<?=$diretorio?>user/login">VOLTAR</a></small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>