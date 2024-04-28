<?php
$todos = [];

if (file_exists('todo.txt')) {
    $file = file_get_contents('todo.txt');
    $todos = json_decode($file, true);
}

if (isset($_POST['todo'])) {
    $data = $_POST['todo'];
    $todos[] = [
        'todo' => $data,
        'status' => 0
    ];
    simpanData($todos);
}

if (isset($_GET['status'])) {
    $todos[$_GET['key']]['status'] = $_GET['status'];
    simpanData($todos);
}

if (isset($_GET['hapus'])) {
    unset($todos[$_GET['key']]);
    simpanData($todos);
}

function simpanData($todos)
{
    $daftar_belanja = json_encode($todos);
    file_put_contents('todo.txt', $daftar_belanja);
    header('location:index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-do App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 30%;
            max-width: 800px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            text-decoration: underline;
            margin-bottom: 40px;
        }

        form {
            margin-bottom: 20px;
            align-items: center;
        }

        label {
            font-weight: bold;
        }

        input[type="text"] {
            margin-top: 8px;
            width: 70%;
            margin-right: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 8px 15px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        input[type="checkbox"] {
            margin-right: 10px;
        }

        del {
            color: #999;
        }

        a {
            color: #f44336;
            text-decoration: none;
            margin-left: 10px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Simple To-do App</h1>
        <form action="" method="POST">
            <label for="todo">Daftar Kegiatan Hari ini</label>
            <input type="text" name="todo" id="todo">
            <button type="submit">Simpan</button>
        </form>
        <ul>
            <?php foreach ($todos as $key => $value) : ?>
                <li>
                    <input type="checkbox" name="todo" onclick="window.location.href='index.php?status=<?php echo ($value['status'] == 1) ? '0' : '1'; ?>&key=<?php echo $key; ?>'" <?php if ($value['status'] == 1) echo 'checked' ?>>
                    <label>
                        <?php
                        if ($value['status'] == 1) {
                            echo '<del>' . $value['todo'] . '</del>';
                        } else {
                            echo $value['todo'];
                        }
                        ?>
                    </label>
                    <a href="index.php?hapus=1&key=<?php echo $key; ?>" onclick="return confirm('Apakah Anda Yakin akan menghapus data ini?')">hapus</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>

</html>