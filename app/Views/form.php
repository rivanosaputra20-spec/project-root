<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #3498db;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Form Login</h2>

    <form action="<?= base_url('process') ?>" method="post">
        <label>NIM</label>
        <input type="text" name="nim" required>

        <label>Email</label>
        <input type="email" name="email" required>

         <label>Password</label>
        <input type="password" name="password" required>
        

        

        <button type="submit">Masuk</button>
    </form>
</div>

</body>
</html>
