<div class="info">
    <?php if ($registrationSuccess) : ?>
        <p class="success">Registration Successful!</p>
    <?php endif; ?>
    <?php if ($logoutSuccess) : ?>
        <p class="success">Logout Successful!</p>
    <?php endif; ?>
</div>

<div class="form-container">
    <form action="<?= base_url('auth/login') ?>" method="post" id="loginForm">
        <?= csrf_field() ?>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= set_value('email') ?>" placeholder="Email" required pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Password" required pattern=".{8,}" title="Eight or more characters">
        <button type="submit">Login</button>
        <p> Don't have an account? <a href="<?= base_url('signup') ?>">Sign Up</a></p>
    </form>
</div>