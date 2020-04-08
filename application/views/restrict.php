<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<main>
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-md-5" id="titulo">
                <h1>Área Restrita do Operador</h1>
                <hr>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <a href="<?=base_url('admin/logout')?>">
                    <button class="btn btn-danger">Sair</button>
                </a>
            </div>
        </div>
    </div>
</main>