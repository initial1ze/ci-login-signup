<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('public/style.css') ?>">
    <title>Login</title>
</head>

<body>
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('failure')) : ?>
        <div class="failure"><?= session()->getFlashdata('failure') ?></div>
    <?php endif; ?>

    <?php $errors = validation_errors(); ?>
    <?php if (!empty($errors)) : ?>
        <div>
            <?php foreach ($errors as $error) : ?>
                <div class="failure"><?= esc($error) ?></div>
            <?php endforeach ?>
        </div>
    <?php endif; ?>

    <div class="form-container">
        <form action="<?= base_url('auth/login') ?>" method="post">
            <?= csrf_field() ?>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?= set_value('email') ?>" placeholder="Email" required pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$">
            <!-- <br> -->
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Password" required pattern=".{8,}" title="Eight or more characters">
            <!-- <br> -->
            <button type="submit">Login</button>

            <p> Don't have an account? <a href="<?= base_url('signup') ?>">Sign Up</a></p>
        </form>
    </div>

</body>

</html>