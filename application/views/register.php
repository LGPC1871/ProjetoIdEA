<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$diretorio = base_url();
?>
<main>
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-md-5" id="titulo">
                <h1>Cadastro</h1>
                <hr />
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-11 col-sm-12 col-11" id="div-form">
            <form action="" method="post" id="form">
                <div class="form-group text-center">
                    <h2>FORMULÁRIO DE CADASTRO</h2>
                    <hr />
                    <div class="helper no-error">
                        <span class="help-block">Preencha todos os campos</span>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-6">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" name="Nome" id="firstName" placeholder="Digite seu nome">
                    </div>
                    <div class="form-group col-6">
                        <label for="sobrenome">Sobrenome</label>
                        <input type="text" class="form-control" name="Sobrenome" id="lastName" placeholder="Digite seu sobrenome">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-12">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="Email" id="email" placeholder="Digite seu email">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-6">
                        <label for="password">Senha</label>
                        <input type="password" class="form-control" name="Senha" id="password" placeholder="Digite uma senha">
                    </div>
                    <div class="form-group col-6">
                        <label for="passwordConfirm">Confirmar Senha</label>
                        <input type="password" class="form-control" name="Senha2" id="passwordConfirm" placeholder="Confirme sua senha">
                    </div>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary" name="submit" id="btnSubmit">Cadastrar</button>
                    <small id="passwordInfo" class="form-text text-muted">Já está registrado? <a href="<?=$diretorio?>user/login">clique aqui</a>.</small>
                </div>
            </form>
            </div>
        </div>
    </div>
</main>