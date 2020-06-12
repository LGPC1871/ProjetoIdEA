<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$diretorio = base_url();
$session_data = $this->session->userdata();
$userModel = unserialize($session_data["userData"]);
$userAddInfo = $session_data["addInfo"];
?>
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-5 col-md-6 col-sm-8 col-10 text-center">
                <h1>User Profile</h1>
                <hr>
                <?php echo var_dump($userModel) ?>
            </div>
        </div>
        <div>
            <img src="<?=$userAddInfo["picture"]?>" alt="">
        </div>
        <div class="row justify-content-center">
            <a href="<?=$diretorio?>user/endSession" class="btn btn-danger">Sair</a>
        </div>
    </div>
</main>