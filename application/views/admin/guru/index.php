<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= $title; ?></h1>
  </div>
  <div class="row mb-2">
    <div class="col-md-6">
    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#formModalSiswa">
        <i class="fas fa-plus"></i> Tambah Data Guru
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
                  <td>Nama Guru</td>
                  <td>Whatsapp</td>
                  <td><i class="fas fa-cogs"></i></td>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; foreach($guru as $g) : ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $g['nama_guru']; ?></td>
                    <td><?= $g['whatsapp']; ?></td>
                    <td>
                      <a href="<?= base_url('admin/sendwa/') . $g['id_guru']; ?>" class="btn btn-success">
                        <i class="fas fa-bell"></i>
                      </a>
                      <a href="<?= base_url('admin/ubahGuru/') . $g['id_guru']; ?>" class="btn btn-primary">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="<?= base_url('admin/guru_delete/') . $g['id_guru']; ?>" class="btn btn-danger" onclick="return confirm('Yakin Hapus ?')"><i class="fas fa-trash"></i></a>
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

<!-- Modal -->
<div class="modal fade" id="formModalSiswa" tabindex="-1" aria-labelledby="formModalLabelSiswa" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModalLabelSiswa">Tambah Data Guru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= form_open('admin/guru'); ?>
        <div class="form-group">
          <label for="nama">Nama Guru</label>
          <input type="text" name="nama" id="nama" class="form-control">
          <small class="muted text-danger"><?= form_error('nama'); ?></small>
        </div>
        <div class="form-group">
          <label for="whatsapp">Whatsapp</label>
          <input type="text" name="whatsapp" id="whatsapp" class="form-control">
          <small class="muted text-danger"><?= form_error('whatsapp'); ?></small>
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