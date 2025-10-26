<?php
/*
 *  XAuthConnect integration panel page
 *
 *  @package Modules\XAuthConnect
 *  @author Serhii Cherneha
 *  @version 1.0.0
 *  @license MIT
 */

define('PAGE', 'panel_integrations');
define('PARENT_PAGE', 'panel_integrations');
define('PANEL_PAGE', 'xauthconnect');

$page_title = $language->get('admin', 'xauthconnect');
require_once(ROOT_PATH . '/core/templates/backend_init.php');

if (!$user->handlePanelPageLoad('admincp.xauthconnect')) {
    require_once(ROOT_PATH . '/403.php');
    die();
}

if (Session::exists('admin_integrations')) {
    $success = Session::flash('admin_integrations');
}

// Load modules/XAuthConnect/includes/admin_integrations/xauthconnect.php
require_once(ROOT_PATH . '/modules/XAuthConnect/includes/admin_integrations/xauthconnect.php');

$smarty->assign(
    [
        'PARENT_PAGE' => PARENT_PAGE,
        'PANEL_PAGE' => PANEL_PAGE,
        'XAUTHCONNECT_SETTINGS' => $language->get('admin', 'xauthconnect_settings'),
        'BACK' => $language->get('general', 'back'),
        'BACK_LINK' => URL::build('/panel/integrations'),
        'SUBMIT' => $language->get('general', 'submit'),
        'TOKEN' => Token::get(),
        'SUCCESS' => $success ?? null,
        'ERRORS' => $errors ?? null,
    ]
);

$template->on  = 'integrations';

$template->display('integrations/xauthconnect.tpl');
