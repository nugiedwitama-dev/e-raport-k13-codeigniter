<style>
    .container-fluid{
        background-color: #000;
        text: #fff;
    }
	@media print {
		.no-print{display: none;}
	}
</style>
<div class="container-fluid">
<p style="font-size: 20px;" class="align-left"> No Raport : <?= $cover['id_siswa']?></p>
<br> <br>
<center>
<br>
    <p>
        <img src="<?= base_url()?>assets/img/garuda.jpeg" alt="">
    </p>
    <br> <br> <br> <br>
    
    <p style="font-size: 28px;"><strong>LAPORAN <br>
    HASIL BELAJAR PESERTA DIDIK <br>
    KESETARAAN SMP (PAKET B) <br>
    Tingkat 3 / Setara Kelas <?= $cover['kelas']?></strong></p> <br> <br> <br> <br>
    <p>
        <img src="<?= base_url()?>assets/img/cover_pkbm.jpeg" alt="">
    </p>
    <br> <br> <br> <br>
    <p style="font-size: 20px;">Nama Peserta Didik</p>
    <strong>
        <p style="font-size: 28px;"><?= $cover['nama']?></p>
        <p>No Induk dan NISN : <?= $cover['nis'] ?> / 111</p>
    </strong>
    <br>
    <br>
    <strong>
        <br> <br> <br> <br>
        <p style="font-size: 28px;">PKBM BUDI UTAMA</p>
    </strong>
    <p style="font-size: 20px;">jl. Raya Desa Tambaksari RT03/III, Jawa Tengah <br>
       Telepon : 85647953300 e-Mail: pkbm.budiutama12@gmail.com <br>
       Website: pkbmbudiutama.sch.id</p> <br> <br>
    <p>
         <br> <br> <br> <br>
        <img src="<?= base_url()?>assets/img/garuda.jpeg" alt="">
    </p>
    <br> <br> <br> <br> <br>
    <strong>        
        <p style="font-size: 28px;">LAPORAN <br>
        HASIL BELAJAR PESERTA DIDIK <br>
        KESETARAAN SMP (PAKET B) <br>
        Tingkat 3 / Setara Kelas <?= $cover['kelas']?></p> <br>
    </strong>
</center>
<br> <br> <br>
<p style="font-size: 20px;">Nama Lembaga     : PKBM BUDI UTAMA</p>
<p style="font-size: 20px;">NPSN             : P9980007</p>
<p style="font-size: 20px;">Alamat           : Jl. Raya Desa Tambaksari RT03/III</p>
<p style="font-size: 20px;">Kode Pos         : 53182</p>
<p style="font-size: 20px;">Desa/Kelurahan   : Tambaksari</p>
<p style="font-size: 20px;">Kecamatan        : Kembaran</p>
<p style="font-size: 20px;">Kabupaten/kota   : Banyumas</p>
<p style="font-size: 20px;">Provinsi         : Jawa Tengah</p>
<p style="font-size: 20px;">Email            : pkbmedukasi@gmail.com</p>
<p style="font-size: 20px;">Website          : -</p>
<br> <br> <br> <br> <br>
<center>
        <strong>
            <br> <br> <br> <br> <br>
            <p style="font-size: 28px;">PKBM BUDI UTAMA</p>
        </strong>
        <p style="font-size: 20px;">jl. Raya Desa Tambaksari RT03/III, Jawa Tengah <br>
           Telepon : 85647953300 e-Mail: pkbm.budiutama12@gmail.com <br>
           Website: pkbmbudiutama.sch.id</p>
</center>
</div>

<script>
	window.print();
</script>