<div class="info"></div>

<div class="form-container">
    <form action="<?= base_url('auth/signup') ?>" method="post" id="signupForm">
        <?= csrf_field() ?>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= set_value('email') ?>" placeholder="Email" required pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$">

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Password" required pattern=".{8,}" title="Eight or more characters">

        <label for="cnfPassword">Confirm Password:</label>
        <input type="password" name="cnfPassword" id="cnfPassword" placeholder="Confirm Password" required pattern=".{8,}" title="Eight or more characters">

        <button type="submit">Sign Up</button>


        <p> Already have an account? <a href="<?= base_url('login') ?>">Login</a></p>
    </form>
</div>