<div>
    <div>
    <?php $base_url = URL::site(NULL, TRUE);
    ?>
    </div>
    <p>Hi <?= ucfirst($name); ?>,</p>
    <p>Your profile have successfully created in KRCFM<p>
    <p>Please click the below link to activate your account</p>
    <p><a href="<?= $url; ?>?user_id=<?= $user_id; ?>"><?= $url; ?>?user_id=<?= $user_id; ?></a></p>
    <p>Regards, <br />KRCFM Team</p>
</div>