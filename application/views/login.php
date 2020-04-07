<main>
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-5 col-md-6 col-sm-8 col-10" id="titulo">
                <h1>Login</h1>
                <hr>
                <p>Formulário de Login para o Operador</p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-5 col-md-6 col-sm-8 col-10" id="div-form">
                <form action="<?=base_url()?>user_authentication">
                    <div class="form-group text-center">
                        <h2>Entrar</h2>
                        <hr>
                    </div>
                    <div class="form-group">
                        <label for="username">Usuário</label>
                        <input type="username" class="form-control" id="username"  placeholder="Digite seu nome de usuário">
                    </div>
                    <div class="form-group">
                        <label for="password">Senha</label>
                        <input type="password" class="form-control" id="password" aria-describedby="passwordInfo" placeholder="Digite sua senha">
                        <small id="passwordInfo" class="form-text text-muted">Não compartilhe sua senha com ninguém</small>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>