<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style>
        body {
            font-family: Arial;
            background: #f5f6fa;
            padding: 40px;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
            background: #2c3e50;
            color: white;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: white;
            background: #3498db;
            padding: 8px 15px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1><?= $title ?></h1>

    <table>
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

    <a href="/">⬅ Kembali ke Home</a>
</div>

</body>
</html>
