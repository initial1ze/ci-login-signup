<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('public/style.css') ?>">
    <title>Dashboard</title>
</head>

<body>
    <div class="dashboard">
        <h1>Welcome <?= $user['email'] ?></h1>
        <a href="<?= base_url('logout') ?>" class="logout-btn">Logout</a>
    </div>
</body>

</html>