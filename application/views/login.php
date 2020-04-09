<main>
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-5 col-md-6 col-sm-8 col-10" id="titulo">
                <h1>Login</h1>
                <hr>
                <p>Para entrar na área restrita é necessário fazer login</p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-8 col-10" id="div-form">
                <!--Mensagem de sucesso/erro aqui?-->
                <form action="" method="post" id="loginForm">
                    <div class="form-group text-center">
                        <h2>Entrar</h2>
                        <hr>
                    </div>
                    <div class="form-group text-center">
                        <div class="login-helper no-error">
                            <span class="help-block"><i class="fas fa-info-circle fa-lg"></i> Insira suas Credenciais de Administrador</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="nome" placeholder="Digite seu nome de usuário">
                    </div>
                    <div class="form-group">
                        <label for="password">Senha</label>
                        <input type="password" class="form-control" name="password" id="senha" aria-describedby="passwordInfo" placeholder="Digite sua senha">
                        <small id="passwordInfo" class="form-text text-muted">Não compartilhe sua senha com ninguém</small>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary" name="loginSubmit" id="botaoLogin" value="login">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>