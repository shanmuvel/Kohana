 <h2>Create a New User</h2>
<? if ($message) : ?>
            <h3 class="message">
                        <?= $message; ?>
            </h3>
<? endif; ?>

<?= Form::open('user/create'); ?>
<?= Form::label('email', 'Email Address'); ?>
<?= Form::input('email', HTML::chars(Arr::get($_POST, 'email'))); ?>

<?= Form::label('password', 'Password'); ?>
<?= Form::password('password'); ?>

<?= Form::label('password_confirm', 'Confirm Password'); ?>
<?= Form::password('password_confirm'); ?>

<?= Form::submit('create', 'Create New User'); ?>
<?= Form::close(); ?>