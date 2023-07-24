<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5 col-lg-5 mx-auto">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <img src="<?php echo base_url() ?>assets/img/logo.png" class="w-25 px-7 mb-3">
                            <h1 class="h4 text-gray-900 mb-4">E-Raport PKBM Budi Utama</h1>
                            <h4 class="h4 text-primary my-3">Register</h4>
                        </div>
                        <form class="user m-auto pt-3" method="post" action="<?= base_url('auth/register'); ?>">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Masukkan Nama Anda" value="<?= set_value('name'); ?>">
                                <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Masukkan Alamat Email" value="<?= set_value('email'); ?>">
                                <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Password">
                                    <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Ulang Password">
                                </div>
                            </div>
                            <hr class="pt-3">
                            <button type="submit" class="btn btn-primary btn-user btn-block" style="background-color: navy;">
                                Registrasi Akun
                            </button>
                        </form>
                        <div class="text-center pt-3">
                            <a class="small" href="<?= base_url('auth'); ?>"> Sudah punya akun? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>