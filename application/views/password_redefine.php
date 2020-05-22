<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$diretorio = base_url();

$selector = $this->input->get("selector");
$validator = $this->input->get("validator");
?>
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 col-10" id="div-form">
                <form action="" method="post" id="form">
                    <div class="form-group text-center">
                        <h3>REDEFINIR SENHA</h3>
                        <hr />
                    <div class="form-group text-center">
                        <div class="helper no-error">
                            <span class="help-block"></span>
                        </div>
                    </div>
                        Digite sua nova senha:
                    </div>
                    <input type="hidden" name="selector" value="<?=$selector?>">
                    <input type="hidden" name="validator" value="<?=$validator?>">
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" class="form-control" name="senha" id="password" placeholder="Digite sua senha">
                    </div>
                    <div class="form-group">
                        <label for="confirma">Confirmar Senha</label>
                        <input type="password" class="form-control" name="confirma" id="passwordConfirm" placeholder="Confirme sua Senha">
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary" name="submit" id="btnSubmit">
                            Redefinir
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>