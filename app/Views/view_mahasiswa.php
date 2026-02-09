<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
</head>
<body>

<h1><?= $title ?></h1>

<table border="1" cellpadding="8">
    <tr>
        <th>Nama</th>
        <th>NIM</th>
        <th>Program Studi</th>
    </tr>

    <?php foreach ($mahasiswa as $mhs): ?>
    <tr>
        <td><?= $mhs['nama']; ?></td>
        <td><?= $mhs['nim']; ?></td>
        <td><?= $mhs['prodi']; ?></td>
    </tr>
    <?php endforeach; ?>

</table>

</body>
</html>
