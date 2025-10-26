<?php
/*
 *  XAuthConnect integration settings
 *
 *  @package Modules\XAuthConnect
 *  @author Your Name
 *  @version 1.0.0
 *  @license MIT
 */

if (Input::exists()) {
    if (Token::check()) {
        if (isset($_POST['client_id'])) {
            Settings::set('xauthconnect_client_id', $_POST['client_id']);
        }

        if (isset($_POST['client_secret'])) {
            Settings::set('xauthconnect_client_secret', $_POST['client_secret']);
        }

        if (isset($_POST['issuer_url'])) {
            Settings::set('xauthconnect_issuer_url', $_POST['issuer_url']);
        }

        Session::flash('admin_integrations', '<div class="alert alert-success">' . $language->get('admin', 'settings_updated_successfully') . '</div>');
        Redirect::to(URL::build('/panel/integrations/xauthconnect'));
    } else {
        Session::flash('admin_integrations', '<div class="alert alert-danger">' . $language->get('general', 'invalid_token') . '</div>');
    }
}

$client_id = Settings::get('xauthconnect_client_id');
$client_secret = Settings::get('xauthconnect_client_secret');
$issuer_url = Settings::get('xauthconnect_issuer_url');

?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <?php echo $language->get('admin', 'xauthconnect_settings'); ?>
        </h6>
    </div>
    <div class="card-body">
        <form action="" method="post">
            <div class="form-group">
                <label for="client_id"><?php echo $language->get('admin', 'xauthconnect_client_id'); ?></label>
                <input type="text" name="client_id" id="client_id" class="form-control" value="<?php echo Output::getClean($client_id); ?>">
            </div>
            <div class="form-group">
                <label for="client_secret"><?php echo $language->get('admin', 'xauthconnect_client_secret'); ?></label>
                <input type="text" name="client_secret" id="client_secret" class="form-control" value="<?php echo Output::getClean($client_secret); ?>">
            </div>
            <div class="form-group">
                <label for="issuer_url"><?php echo $language->get('admin', 'xauthconnect_issuer_url'); ?></label>
                <input type="text" name="issuer_url" id="issuer_url" class="form-control" value="<?php echo Output::getClean($issuer_url); ?>">
            </div>
            <div class="form-group">
                <label for="redirect_uri"><?php echo $language->get('admin', 'xauthconnect_redirect_uri'); ?></label>
                <input type="text" id="redirect_uri" class="form-control" value="<?php echo URL::getSelfURL() . URL::build('/oauth', 'provider=xauthconnect', 'non-friendly'); ?>" readonly>
                <small class="form-text text-muted"><?php echo $language->get('admin', 'xauthconnect_redirect_uri_info'); ?></small>
            </div>
            <div class="form-group">
                <input type="hidden" name="token" value="<?php echo Token::get(); ?>">
                <input type="submit" class="btn btn-primary" value="<?php echo $language->get('general', 'submit'); ?>">
            </div>
        </form>
    </div>
</div>
