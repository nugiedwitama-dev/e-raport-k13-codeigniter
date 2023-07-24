<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            Form Update User Akses
                        </h4>
                    </div>
                    <div class="card-body">
                        <?= $this->session->flashdata('message'); ?>
                        <?php foreach ($user_akses as $ua) 
                        {
                            ?>
                        <form action="<?= base_url('admin/update_user_akses_aksi'); ?>" method="post" accept-charset="utf-8">
                        <div class="row form-group">
                                <label class="col-md-3 text-md-right font-weight-bold" for="name">Nama</label>
                                <div class="col-md-9">
                                    <input type="hidden" name="id" value="<?= $ua->id?>">
                                    <input name="name" id="current_password" value="<?= $ua->name ?>" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-3 text-md-right font-weight-bold" for="email">Email</label>
                                <div class="col-md-9">
                                    <input name="email" id="email"value="<?= $ua->email ?>" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-3 text-md-right font-weight-bold" for="alamat">Alamat</label>
                                <div class="col-md-9">
                                    <input name="alamat" id="new_password2" value="<?= $ua->alamat ?>" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-3 text-md-right font-weight-bold" for="no_telp">Nomor Telepon</label>
                                <div class="col-md-9">
                                    <input name="no_telp" id="new_password2" value="<?= $ua->no_telp ?>" type="text" class="form-control">
                                </div>
                            </div>
                            
                            <!-- <div class="row form-group">
                                <label class="col-md-3 text-md-right font-weight-bold" for="no_telp">Level</label>
                                    <input type="radio" id="role_id" name="role_id" class="form-control" value="<?= $ua->role_id ?>"> Admin<br>
                                    <input type="radio" id="role_id" name="role_id" class="form-control" value="<?= $ua->role_id ?>"> Guru<br>
                                </div>
                            </div> -->
                            
                            <div class="row form-group">
                                <label class="col-md-3 text-md-right font-weight-bold" for="password">Password User</label>
                                <div class="col-md-9">
                                    <input name="password" id="new_password2" placeholder="Masukkan password baru..." type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-9 offset-md-3">
                                    <button type="submit" class="btn btn-primary" style="background-color: navy;">Update User Akses</button>
                                </div>
                            </div>
                        </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>