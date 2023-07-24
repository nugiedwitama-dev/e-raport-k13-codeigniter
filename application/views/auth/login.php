<div class="cover" style="background-image:url(assets/img/pkbm.jpg);
    background-size: cover;
    height: 100vh;">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-lg-5 col-xl-5">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="<?php echo base_url() ?>assets/img/logo.png" class="w-25 px-7 mb-3">
                                        <h1 class="h4 text-gray-900 mb-3">E-Raport PKBM Budi Utama</h1>
                                        <h4 class="h4 text-primary my-3">Login</h4>
                                    </div>
                                    <div class="text-center pt-3">
                                        <a href="<?= base_url('welcome'); ?>"> Siswa? Lihat Nilai Sekarang!</a>
                                    </div>

                                    <?= $this->session->flashdata('message'); ?>

                                    <form class="user m-auto pt-3" method="post" action="<?= base_url('auth'); ?>">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Masukkan Alamat Email" value="<?= set_value('email'); ?>">
                                            <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                            <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                                        </div>
                                        <hr class="pt-3">
                                        <button type="submit" class="btn btn-primary btn-user btn-block" style="background-color: navy;">
                                            Login
                                        </button>
                                    </form>
                                    <div class="text-center pt-3">
                                        <a class="small" href="<?= base_url('auth/register'); ?>"> Belum punya akun? Registrasi!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>