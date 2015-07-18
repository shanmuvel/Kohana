 <h2>Detail for  user "<?= $user->email; ?>"</h2>

<ul>
            <li>Email: <?= $user->email; ?></li>
            <li>Number of logins: <?= $user->logins; ?></li>
            <li>Last Login: <?= Date::fuzzy_span($user->last_login); ?></li>
</ul>

<?= HTML::anchor('user/logout', 'Logout'); ?>