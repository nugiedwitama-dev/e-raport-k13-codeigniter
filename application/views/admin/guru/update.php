<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= $title; ?></h1>
  </div>
  <div class="row mb-2">
    <div class="col-md-6">
      <?php if(validation_errors()) : ?>
        <div class="alert alert-danger" role="alert"><?= validation_errors(); ?></div>
      <?php endif; ?>
      <?= $this->session->flashdata('pesan'); ?>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md">
          <?= form_open('admin/ubahDataGuru'); ?>
          <input type="hidden" name="id_guru" id="id_guru" value="<?= $guru['id_guru']; ?>">
          <div class="form-group">
            <label for="nama">Nama Guru</label>
            <input type="text" name="nama" id="nama" value="<?= $guru['nama_guru']; ?>" class="form-control">
            <small class="muted text-danger"><?= form_error('nama'); ?></small>
          </div>
          <div class="form-group">
            <label for="whatsapp">Whatsapp</label>
            <input type="text" name="whatsapp" id="whatsapp" value="<?= $guru['whatsapp']; ?>" class="form-control">
            <small class="muted text-danger"><?= form_error('whatsapp'); ?></small>
          </div>
          <div class="form-group">
            <a href="<?= base_url('admin/guru'); ?>" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-dark">Ubah</button>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</main>