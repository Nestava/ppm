<?php
require '../../vendor/autoload.php';
include '../connect.php';

use Dompdf\Dompdf;

$id = $_GET['id'];

$cariPengaduan = mysqli_query($conn, "SELECT * FROM pengaduan WHERE id_pengaduan='$id'");
$pengaduan = mysqli_fetch_assoc($cariPengaduan);

$cariPelapor = mysqli_query($conn, "SELECT * FROM masyarakat WHERE nik='" . $pengaduan['nik'] . "'");
$pelapor = mysqli_fetch_assoc($cariPelapor);

$cariTanggapan = mysqli_query($conn, "SELECT * FROM tanggapan WHERE id_pengaduan='$id'");
$tanggapan = mysqli_fetch_assoc($cariTanggapan);

$cariTanggal = $tanggapan['tgl_tanggapan'];

$cariPetugas = mysqli_query($conn, "SELECT * FROM petugas WHERE id_petugas='" . $tanggapan['id_petugas'] . "'");
$petugas = mysqli_fetch_assoc($cariPetugas);

$html = '
<h2 style="text-align: center;">Laporan Pengaduan</h2>
<hr>
<h4>Detail Pengaduan</h4>
<table>
    <tr><td><strong>ID Pengaduan</strong></td><td>: ' . $pengaduan['id_pengaduan'] . '</td></tr>
    <tr><td><strong>Tanggal Pengaduan</strong></td><td>: ' . $pengaduan['tgl_pengaduan'] . '</td></tr>
    <tr><td><strong>Status</strong></td><td>: ' . ucfirst($pengaduan['status']) . '</td></tr>
</table>
<br>
<h4>Identitas Pelapor</h4>
<table>
    <tr><td><strong>NIK</strong></td><td>: ' . $pelapor['nik'] . '</td></tr>
    <tr><td><strong>Nama</strong></td><td>: ' . $pelapor['nama'] . '</td></tr>
    <tr><td><strong>Username</strong></td><td>: ' . $pelapor['username'] . '</td></tr>
    <tr><td><strong>No. Telepon</strong></td><td>: ' . $pelapor['telp'] . '</td></tr>
</table>
<br>
<h4>Isi Laporan</h4>
<p>' . nl2br($pengaduan['isi_laporan']) . '</p>
<br>
<h4>Tanggapan</h4>
<p>' . nl2br($tanggapan['tanggapan']) . '</p>
<br>
<h4>Ditanggapi Oleh</h4>
<p>' . $petugas['nama_petugas'] . '</p>
<br>
<h4>Ditanggapi Pada Tanggal</h4>
<p>' . $cariTanggal . '</p>
';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream("laporan_pengaduan_" . $id . ".pdf", array("Attachment" => false));
exit;
