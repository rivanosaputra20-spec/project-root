<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Home - Berita</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f4f6f9;
        }

        h1 {
            text-align: center;
        }

        .welcome {
            text-align: center;
            margin-bottom: 20px;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .card {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }

        .card-body {
            padding: 15px;
        }

        .card h3 {
            margin: 0 0 10px;
        }

        .card p {
            font-size: 14px;
            color: #555;
        }

        .btn {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 12px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 13px;
        }
    </style>
</head>
<body>

<h1>Portal Berita Kampus</h1>

<?php if(isset($nama)): ?>
    <div class="welcome">
        <h3>Selamat datang, <?= esc($nama); ?> 👋</h3>
    </div>
<?php endif; ?>

<div class="container">

    <?php for($i=1; $i<=5; $i++): ?>
    <div class="card">
        <img src="https://picsum.photos/400/200?random=<?= $i ?>" alt="Berita">

        <div class="card-body">
            <h3>Judul Berita <?= $i ?></h3>
            <p>
                Ini adalah ringkasan singkat berita ke-<?= $i ?>.
                Berisi informasi terbaru seputar kegiatan kampus.
            </p>
            <a href="#" class="btn">Baca Selengkapnya</a>
        </div>
    </div>
    <?php endfor; ?>

</div>

</body>
</html>
