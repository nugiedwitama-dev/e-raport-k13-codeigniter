<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= $title; ?></h1>
  </div>
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md">
          <?= form_open(''); ?>
          <input type="hidden" name="id_siswa" readonly value="<?= $siswa['id_siswa']; ?>">
          <div class="form-group">
            <label for="nis">NIS</label>
            <input type="text" name="nis" id="nis" class="form-control" value="<?= $siswa['nis']; ?>">
            <small class="muted text-danger"><?= form_error('nis'); ?></small>
          </div>
          <div class="form-group">
            <label for="password">Password Akses Nilai Siswa</label>
            <input type="text" name="password" id="password" class="form-control">
            <small class="muted text-danger"><?= form_error('password'); ?></small>
        </div>
          <div class="form-group">
            <label for="nama">Nama Siswa</label>
            <input type="text" name="nama" id="nama" class="form-control"value="<?= $siswa['nama']; ?>">
            <small class="muted text-danger"><?= form_error('nama'); ?></small>
          </div>
          <div class="form-group">
            <label for="kelas">Kelas</label>
            <select name="kelas" id="kelas" class="form-control">
              <option value="">-- Pilih Kelas --</option>
              <?php foreach($kelas as $k) : ?>
                <?php if($k['kelas'] == $siswa['kelas']) : ?>
                <option value="<?= $k['kelas']; ?>" selected><?= $k['kelas']; ?></option>
                <?php else : ?>
                  <option value="<?= $k['kelas']; ?>"><?= $k['kelas']; ?></option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>
            <small class="muted text-danger"><?= form_error('kelas'); ?></small>
          </div>
          <div class="form-group">
            <label for="tahun_ajaran">Alamat</label>
            <input type="text" name="alamat" id="alamat" value="<?= $siswa['alamat']; ?>" class="form-control">
            <small class="muted text-danger"><?= form_error('alamat'); ?></small>
          </div>
          <div class="form-group">
            <label for="biaya">Telp</label>
            <input type="number" name="telp" id="telp" value="<?= $siswa['telp']; ?>" class="form-control">
            <small class="muted text-danger"><?= form_error('telp'); ?></small>
          </div>
          <div class="form-group">
            <a href="<?= base_url('admin/siswa'); ?>" class="btn btn-secondary" data-dismiss="modal">Close</a>
            <button type="submit" class="btn btn-dark">Ubah</button>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</main>

