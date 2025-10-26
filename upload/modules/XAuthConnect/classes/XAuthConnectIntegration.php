<?php
/**
 * XAuthConnectIntegration class
 *
 * @package Modules\XAuthConnect\Integrations
 * @author Your Name
 * @version 1.0.0
 * @license MIT
 */
class XAuthConnectIntegration extends IntegrationBase {

    protected Language $_language;

    public function __construct(Language $language) {
        $this->_name = 'XAuthConnect';
        $this->_icon = 'fas fa-user-shield';
        $this->_language = $language;
        $this->_settings = ROOT_PATH . '/modules/XAuthConnect/includes/admin_integrations/xauthconnect.php';

        parent::__construct();
    }

    public function onLinkRequest(User $user) {
        Session::put('oauth_method', 'link_integration');

        $providers = NamelessOAuth::getInstance()->getProvidersAvailable();
        $provider = $providers['xauthconnect'];

        Redirect::to($provider['url']);
    }

    public function onVerifyRequest(User $user) {
        // XAuthConnect typically verifies during the OAuth flow, so this might not be directly used.
        // If XAuthConnect provides a separate verification step, implement it here.
    }

    public function onUnlinkRequest(User $user) {
        $integrationUser = new IntegrationUser($this, $user->data()->id, 'user_id');
        $integrationUser->unlinkIntegration();

        Session::flash('connections_success', $this->_language->get('user', 'integration_unlinked', ['integration' => Output::getClean($this->_name)]));
    }

    public function onSuccessfulVerification(IntegrationUser $integrationUser) {
        Session::flash('connections_success', $this->_language->get('user', 'integration_linked', ['integration' => Output::getClean($this->_name)]));
    }

    public function validateUsername(string $username, int $integration_user_id = 0): bool {
        // XAuthConnect might not provide a traditional username for validation, but rather a 'sub' (subject ID).
        // This method might need to be adapted or removed depending on XAuthConnect's user data structure.
        return true; // Placeholder
    }

    public function validateIdentifier(string $identifier, int $integration_user_id = 0): bool {
        // The identifier will be the 'sub' (subject ID) from XAuthConnect.
        // Ensure it's unique and not already linked.
        $validation = Validate::check(['identifier' => $identifier], [
            'identifier' => [
                Validate::REQUIRED => true,
                Validate::MIN => 1,
                Validate::MAX => 255 // Adjust max length based on XAuthConnect 'sub' length
            ]
        ])->messages([
            'identifier' => [
                Validate::REQUIRED => $this->_language->get('admin', 'integration_identifier_required', ['integration' => $this->getName()]),
                Validate::MIN => $this->_language->get('admin', 'integration_identifier_invalid', ['integration' => $this->getName()]),
                Validate::MAX => $this->_language->get('admin', 'integration_identifier_invalid', ['integration' => $this->getName()]),
            ]
        ]);

        if (count($validation->errors())) {
            foreach ($validation->errors() as $error) {
                $this->addError($error);
            }
        } else {
            $exists = DB::getInstance()->query("SELECT * FROM nl2_users_integrations WHERE integration_id = ? AND identifier = ? AND id <> ?", [$this->data()->id, $identifier, $integration_user_id]);
            if ($exists->count()) {
                $this->addError($this->_language->get('user', 'integration_identifier_already_linked', ['integration' => $this->getName()]));
                return false;
            }
        }

        return $validation->passed();
    }

    public function allowLinking(): bool {
        return NamelessOAuth::getInstance()->isSetup('xauthconnect');
    }

    public function onRegistrationPageLoad(Fields $fields) {
        // Nothing to do here
    }

    public function beforeRegistrationValidation(Validate $validate) {
        // Nothing to do here
    }

    public function afterRegistrationValidation() {
        // Nothing to do here
    }

    public function successfulRegistration(User $user) {
        if (Session::exists('oauth_register_data')) {
            $data = json_decode(Session::get('oauth_register_data'), true);
            if ($data['provider'] == 'xauthconnect' && isset($data['data']['sub'])) {

                $xauthconnect_id = $data['data']['sub'];
                $xauthconnect_username = $data['data']['nickname'] ?? $data['data']['name'] ?? $data['data']['sub']; // Use 'nickname' or 'name' if available, otherwise 'sub'

                if ($this->validateIdentifier($xauthconnect_id) && $this->validateUsername($xauthconnect_username)) {
                    $integrationUser = new IntegrationUser($this);
                    $integrationUser->linkIntegration($user, $xauthconnect_id, $xauthconnect_username, true);
                    $integrationUser->verifyIntegration();
                }
            }
        }
    }

    public function syncIntegrationUser(IntegrationUser $integration_user): bool {
        // Implement logic to sync user data from XAuthConnect if needed
        return false;
    }
}
