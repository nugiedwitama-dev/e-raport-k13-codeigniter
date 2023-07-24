<main role="main" class="ml-sm-auto px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= $title; ?></h1>
  </div>
  <div class="row mb-2">
    <div class="col">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#formModalSiswa">
        <i class="fas fa-plus"></i> Tambah Data Siswa
      </button>
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
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <td>No</td>
                  <td>NIS</td>
                  <td>Nama</td>
                  <td>Kelas</td>
                  <td>Alamat</td>
                  <td>Telp</td>
                  <td><i class="fas fa-cogs"></i></td>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; foreach($siswa as $g) : ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $g['nis']; ?></td>
                    <td><?= $g['nama']; ?></td>
                    <td><?= $g['kelas']; ?></td>
                    <td><?= $g['alamat']; ?></td>
                    <td><?= $g['telp']; ?></td>
                    <td>
                      <a href="<?= base_url('admin/ubahSiswa/') . $g['id_siswa']; ?>" class="btn btn-primary">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="<?= base_url('admin/hapus_siswa/') . $g['id_siswa']; ?>" class="btn btn-danger" onclick="return confirm('Yakin Hapus ?')"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>


<div class="modal fade" id="formModalSiswa" tabindex="-1" aria-labelledby="formModalLabelSiswa" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModalLabelSiswa">Tambah Data Siswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= form_open('admin/siswa'); ?>
        <div class="form-group">
          <label for="id_siswa">ID Siswa</label>
          <input type="text" value="<?= $id_siswa ?>" name="id_siswa" id="id_siswa" readonly class="form-control">
          <small class="muted text-danger"><?= form_error('id_siswa'); ?></small>
        </div>
        <div class="form-group">
          <label for="password">Password Akses Nilai Siswa</label>
          <input type="text" name="password" id="password" class="form-control">
          <small class="muted text-danger"><?= form_error('password'); ?></small>
        </div>
        <div class="form-group">
          <label for="nis">NIS</label>
          <input type="text" name="nis" id="nis" class="form-control">
          <small class="muted text-danger"><?= form_error('nis'); ?></small>
        </div>
        <div class="form-group">
          <label for="nama">Nama Siswa</label>
          <input type="text" name="nama" id="nama" class="form-control">
          <small class="muted text-danger"><?= form_error('nama'); ?></small>
        </div>
        <div class="form-group">
          <label for="kelas">kelas</label>
          <select name="kelas" id="kelas" class="form-control">
            <option value="">-- Pilih Kelas --</option>
            <?php foreach($kelas as $k) : ?>
              <option value="<?= $k['kelas']; ?>"><?= $k['kelas']; ?></option>
            <?php endforeach; ?>
          </select>
          <small class="muted text-danger"><?= form_error('kelas'); ?></small>
        </div>
        <div class="form-group">
          <label for="alamat">Alamat</label>
          <input type="text" name="alamat" id="alamat" value="Jl Raya ..." class="form-control">
          <small class="muted text-danger"><?= form_error('alamat'); ?></small>
        </div>
        <div class="form-group">
          <label for="telp">Whats App</label>
          <input type="text" name="telp" id="telp" value="08XXX" class="form-control">
          <small class="muted text-danger"><?= form_error('telp'); ?></small>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-dark">Tambah</button>
        </div>
        <?= form_close(); ?>
      </div>
    </div>
  </div>
</div>
