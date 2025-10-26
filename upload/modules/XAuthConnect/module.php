<?php
/**
 * NamelessMC XAuthConnect Module
 *
 * @author Serhii Cherneha
 * @version 1.0.0
 * @license CSSM Unlimited License v2.0 (CSSM-ULv2)
 */

class XAuthConnect_Module extends Module {

    private Language $_language;

    public function __construct(Language $language, Pages $pages, Endpoints $endpoints) {
        $this->_language = $language;

        $name = 'XAuthConnect Integration';
        $author = '<a href="https://github.com/ChernegaSergiy" target="_blank" rel="nofollow noopener">Serhii Cherneha</a>';
        $module_version = '1.0.0';
        $nameless_version = '2.2.3'; // Assuming NamelessMC 2.2.3

        parent::__construct($this, $name, $author, $module_version, $nameless_version);

        // Add admin panel page for XAuthConnect settings
        $pages->add($this->getName(), '/panel/xauthconnect', 'pages/panel/xauthconnect.php');

        // Register XAuthConnect as an OAuth provider
        NamelessOAuth::getInstance()->registerProvider('xauthconnect', 'XAuthConnect', [
            'class' => 'XAuthConnectProvider', // Class that implements League\OAuth2\\Client\Provider\AbstractProvider
            'user_id_name' => 'sub', // Key in XAuthConnect user data for user ID
            'scope_id_name' => 'openid', // Default scope for identifying the user
            'icon' => 'fas fa-user-shield', // Font Awesome icon
            'display_name' => 'XAuthConnect',
        ]);

        // Load endpoints if any (e.g., for webhooks or API calls)
        // $endpoints->loadEndpoints(ROOT_PATH . '/modules/XAuthConnect/includes/endpoints');
    }

    public function onInstall() {
        // Create default settings for XAuthConnect
        Settings::set('xauthconnect_client_id', '');
        Settings::set('xauthconnect_client_secret', '');
        Settings::set('xauthconnect_issuer_url', 'http://xauth-server.com'); // Default issuer URL
    }

    public function onUninstall() {
        // Remove settings
        Settings::delete('xauthconnect_client_id');
        Settings::delete('xauthconnect_client_secret');
        Settings::delete('xauthconnect_issuer_url');
    }

    public function onDisable() {
        // Nothing to do here
    }

    public function onEnable() {
        // Nothing to do here
    }

    public function onPageLoad(User $user, Pages $pages, Cache $cache, $smarty, $navs, Widgets $widgets, TemplateBase $template) {
        PermissionHandler::registerPermissions($this->getName(), [
            'admincp.xauthconnect' => $this->_language->get('admin', 'integrations') . ' » ' . $this->_language->get('admin', 'xauthconnect'),
        ]);

        if (!defined('FRONT_END')) {
            if ($user->hasPermission('admincp.xauthconnect')) {
                $navs[2]->addItemToDropdown('integrations', 'xauthconnect', $this->_language->get('admin', 'xauthconnect'), URL::build('/panel/xauthconnect'), 'top', null, '<i class="nav-icon fas fa-user-shield"></i>', 1);
            }
        }
    }

    public function getDebugInfo(): array {
        return [
            'client_id' => Settings::get('xauthconnect_client_id'),
            'issuer_url' => Settings::get('xauthconnect_issuer_url'),
            'is_setup' => NamelessOAuth::getInstance()->isSetup('xauthconnect'),
            'is_enabled' => NamelessOAuth::getInstance()->isEnabled('xauthconnect'),
        ];
    }
}
