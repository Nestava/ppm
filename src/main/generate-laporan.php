<?php
require '../../vendor/autoload.php';
include '../connect.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

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

$gambarPath = realpath(__DIR__ . '/../assets/img/' . $pengaduan['foto']);

if (file_exists($gambarPath)) {
    $type = pathinfo($gambarPath, PATHINFO_EXTENSION);
    $data = file_get_contents($gambarPath);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
} else {
    $base64 = '';
}


$html = '
<h2 style="text-align: center;">Laporan Pengaduan</h2>
<hr>
<h4 style="text-align: center;">Detail Pengaduan</h4>
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
<div style="page-break-before: always;"></div>
<h4 style="text-align: center;">Detail Tanggapan</h4>
<table>
    <tr><td><strong>ID Tanggapan</strong></td><td>: ' . $tanggapan['id_tanggapan'] . '</td></tr>
    <tr><td><strong>Tanggal Tanggapan</strong></td><td>: ' . $tanggapan['tgl_tanggapan'] . '</td></tr>
</table>
<br>
<h4>Identitas Penanggap</h4>
<table>
    <tr><td><strong>ID Petugas</strong></td><td>: ' . $petugas['id_petugas'] . '</td></tr>
    <tr><td><strong>Nama</strong></td><td>: ' . $petugas['nama_petugas'] . '</td></tr>
    <tr><td><strong>Username</strong></td><td>: ' . $petugas['username'] . '</td></tr>
    <tr><td><strong>No. Telepon</strong></td><td>: ' . $petugas['telp'] . '</td></tr>
</table>
<br>
<h4>Isi Tanggapan</h4>
<p>' . nl2br($tanggapan['tanggapan']) . '</p>
<div style="page-break-before: always;"></div>
<h4 style="text-align: center;">Lampiran</h4>
<div style="text-align: center;">
    <img style="width: 300px;" src="' . $base64 . '">
</div>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream("laporan_pengaduan_" . $id . ".pdf", array("Attachment" => false));

exit;