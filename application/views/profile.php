<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$diretorio = base_url();
?>
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-5 col-md-6 col-sm-8 col-10 text-center">
                <h1>User Profile</h1>
                <hr>
            </div>
        </div>
        <div class="row justify-content-center">
            <a href="<?=$diretorio?>user/destroySession" class="btn btn-danger">Sair</a>
        </div>
    </div>
</main>