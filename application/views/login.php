<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-5 col-md-6 col-sm-8 col-10 text-center">
                <h1>Entrar</h1>
                <hr>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 col-10" id="div-form">
                <!--Mensagem de sucesso/erro aqui?-->
                <form action="" method="post" id="loginForm">
                    <div class="form-group text-center">
                        <h2>Entrar</h2>
                        <hr>
                        <div class="g-signin2" data-onsuccess="onSignIn" data-longtitle="true" data-theme="dark">Google Login</div>
                    </div>
                    <div class="form-group text-center">
                        <div class="login-helper no-error">
                            <span class="help-block"><i class="fas fa-info-circle fa-lg"></i> Insira suas Credenciais</span>
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
                        <small id="passwordInfo" class="form-text text-muted">Não está registrado? <a href="">clique aqui</a>.</small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>