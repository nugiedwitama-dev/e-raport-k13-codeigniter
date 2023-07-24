<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            Form Ubah Password
                        </h4>
                    </div>
                    <div class="card-body">
                        <?= $this->session->flashdata('message'); ?>
                        <form action="<?= base_url('user/ubahpassword'); ?>" method="post" accept-charset="utf-8">
                            <div class="row form-group">
                                <label class="col-md-3 text-md-right" for="current_password">Password Lama</label>
                                <div class="col-md-9">
                                    <input name="current_password" id="current_password" type="password" class="form-control">
                                    <?= form_error('current_password', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row form-group">
                                <label class="col-md-3 text-md-right" for="new_password1">Password Baru</label>
                                <div class="col-md-9">
                                    <input name="new_password1" id="new_password1" type="password" class="form-control">
                                    <?= form_error('new_password1', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-3 text-md-right" for="new_password2">Konfirmasi Password</label>
                                <div class="col-md-9">
                                    <input name="new_password2" id="new_password2" type="password" class="form-control">
                                    <?= form_error('new_password2', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-9 offset-md-3">
                                    <button type="submit" class="btn btn-primary" style="background-color: navy;">Ubah Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

</div>