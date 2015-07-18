 <h2>Login</h2>
<? if ($message) : ?>
            <h3 class="message">
                        <?= $message; ?>
            </h3>
<? endif; ?>

<?= Form::open('user/login'); ?>
<?= Form::label('username', 'User name'); ?>
<?= Form::input('username', HTML::chars(Arr::get($_POST, 'username'))); ?>
<?= Form::label('password', 'Password'); ?>
<?= Form::password('password'); ?>
<?= Form::submit('login', 'Login'); ?>
<?= Form::close(); ?>
<p>Or <?= HTML::anchor('user/create', 'create a new account'); ?></p>