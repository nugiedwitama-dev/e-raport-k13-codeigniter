<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            Form Update Submenu
                        </h4>
                    </div>
                    <div class="card-body">
                        <?= $this->session->flashdata('message'); ?>
                        <?php foreach ($submenu as $sm) 
                        {
                            ?>
                        <form action="<?= base_url('menu/update_submenu_aksi'); ?>" method="post" accept-charset="utf-8">
                        <div class="row form-group">
                                <label class="col-md-3 text-md-right" for="title">Title</label>
                                <div class="col-md-9">
                                    <input type="hidden" name="id" value="<?= $sm->id?>">
                                    <input name="title" id="current_password" value="<?= $sm->title ?>" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-3 text-md-right" for="menu_id">Menu</label>
                                <div class="col-md-9">
                                    <input name="menu_id" id="menu_id"value="<?= $sm->menu_id ?>" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-3 text-md-right" for="url">Url</label>
                                <div class="col-md-9">
                                    <input name="url" id="new_password2" value="<?= $sm->url ?>" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-3 text-md-right" for="icon">Icon</label>
                                <div class="col-md-9">
                                    <input type="hidden" name="is_active" value="1">
                                    <input name="icon" id="new_password2" value="<?= $sm->icon ?>" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-9 offset-md-3">
                                    <button type="submit" class="btn btn-primary" style="background-color: navy;">Update Submenu</button>
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