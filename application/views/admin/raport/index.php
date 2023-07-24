<div class="container-fluid">
    <form action="<?= base_url('admin')?>/raport_set" method="post">
        <div class="form-group">
            <label for="exampleDataList3" class="form-label">Siswa</label>
            <input class="" name="id_siswa" list="datalistOptions" id="exampleDataList3" placeholder="Pilih siswa...">
            <?= form_error('id_siswa','<div class="text-danger small ml-3">','</div>'); ?>
        <datalist id="datalistOptions">
            <?php foreach ($siswa as $sis) : ?>
            <option value="<?= $sis->id_siswa ?>"><?= $sis->id_siswa ?> - <?= $sis->nama ?></option>
            <?php endforeach; ?>
        </datalist>
        <div class="form-group">
            <label for="smt" class="form-label">Tahun Ajaran / Semester</label>
            <select name="smt" id="smt" class="">
                <option value=""></option>
                <?php foreach ($semester as $smt) : ?>
                    <option value="<?= $smt['thn_ajaran']?>"><?= $smt['thn_ajaran']?> - <?= $smt['semester']?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="form-group">
            <button class="btn btn-primary" type="submit">Lihat Raport</button>
        </div>
        </div>
    </form>
</div>