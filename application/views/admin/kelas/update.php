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
          
          <?= form_open('admin/ubahDataKelas'); ?>
          <input type="hidden" name="kelas" id="kelas" value="<?= $guruWali['kelas']; ?>">
          <div class="form-group">
            <label for="kelas">Kelas</label>
            <input type="text" name="kelas" id="kelas" class="form-control" value="<?= $guruWali['kelas']; ?>" readonly>
            <small class="muted text-danger"><?= form_error('kelas'); ?></small>
          </div>
          <div class="form-group">
            <label for="nama">Nama Guru</label>
            <select name="nama" id="nama" class="form-control">
              <option value="">-- Pilih Guru --</option>
              <?php foreach($guru as $g) : ?>
                <?php if($g['id_guru'] == $guruWali['id_guru']) : ?>
                <option value="<?= $g['id_guru']; ?>" selected><?= $g['nama_guru']; ?></option>
                <?php else : ?>
                  <option value="<?= $g['id_guru']; ?>"><?= $g['nama_guru']; ?></option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>
            <small class="muted text-danger"><?= form_error('nama'); ?></small>
          </div>
          <div class="form-group">
            <a href="<?= base_url('admin/kelas'); ?>" class="btn btn-secondary" data-dismiss="modal">Kembali</a>
            <button type="submit" class="btn btn-dark">Ubah</button>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</main>