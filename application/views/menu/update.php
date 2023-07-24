<div class="container-fluid">
    <div class="alert alert-success" role="alert">
        <i class="fas fa-university"></i> Form  Update Menu
    </div>
    <?= $this->session->flashdata('message')?>
    <?php foreach($menu as $m) : ?>
    <?= form_open_multipart('menu/update_aksi'); ?>            
        <div class="form-group">
        <input type="hidden" name="id" value="<?= $m->id ?>">
        <label>Menu</label>
        <input type="text" name="menu" class="form-control" value="<?= $m->menu ?>">
        <?= 
        form_error('menu','<div class="text-danger small ml-3">','</div>')?>
        </div>
        </div>
        <button type="submit" class="btn btn-primary btn-lg mb-lg-5 ml-3">Update</button>
        <br><br>
        <?php form_close(); ?>
        <?php endforeach; ?>
</div>
