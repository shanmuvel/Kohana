<div>
    <div>
    <?php $base_url = URL::site(NULL, TRUE);
    $name = strstr($email, '@', true);
    ?>
    </div>
    <p>Hi <?= ucfirst($name); ?>,</p>
    <p>Welcome to KRCFM, You have successfully registered in KRCFM<p>
    <p>Please follow the below steps to complete your registration process</p>
    <p>Step1: Go to this page <a href="<?= $url; ?>?user_id=<?= $user_id; ?>"><?= $url; ?>?user_id=<?= $user_id; ?></a></p>
    <p>Step2: Enter the below code<br /><br />
        Registration Code: <strong><?= $registration_code; ?></strong></p><br />
    <p>Regards, <br />KRCFM Team</p>
</div>