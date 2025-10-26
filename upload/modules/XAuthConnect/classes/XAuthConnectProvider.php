<?php

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\ArrayAccessor;
use Psr\Http\Message\ResponseInterface;

// Assuming the oauth2-xauthconnect-clone library is available via Composer
// and its classes are autoloaded.
// For example, if the library's main provider class is named XAuthConnectProvider
// in the ChernegaSergiy\XAuthConnect\OAuth2\Client\Provider namespace.
use ChernegaSergiy\XAuthConnect\OAuth2\Client\Provider\XAuthConnect as BaseXAuthConnectProvider;

/**
 * XAuthConnectProvider class for NamelessMC.
 *
 * @package Modules\XAuthConnect\Classes
 * @author Serhii Cherneha
 * @version 1.0.0
 * @license CSSM Unlimited License v2.0 (CSSM-ULv2)
 */
class XAuthConnectProvider extends BaseXAuthConnectProvider {

    public function __construct(array $options = [], array $collaborators = [])
    {
        // Retrieve issuer URL from NamelessMC settings
        $issuer_url = Settings::get('xauthconnect_issuer_url');
        if (empty($issuer_url)) {
            throw new RuntimeException('XAuthConnect issuer URL is not configured.');
        }

        // Pass the issuer URL to the base XAuthConnectProvider constructor
        $options['issuer'] = $issuer_url;

        parent::__construct($options, $collaborators);
    }

    /**
     * Returns the default scopes used by this provider.
     *
     * @return array
     */
    protected function getDefaultScopes(): array
    {
        return [
            'openid',
            'profile',
            'email',
        ];
    }

    /**
     * Generates a resource owner object from a successful resource owner
     * response.
     *
     * @param array $response
     * @param AccessToken $accessToken
     * @return \League\OAuth2\Client\Provider\ResourceOwnerInterface
     */
    protected function createResourceOwner(array $response, AccessToken $accessToken)
    {
        // XAuthConnectProvider from the library already returns a proper ResourceOwnerInterface
        // We can just return it directly or wrap it if needed.
        return parent::createResourceOwner($response, $accessToken);
    }

    /**
     * Returns the base URL for API requests.
     *
     * @param AccessToken $token
     * @return string
     */
    public function getBaseApiUrl(AccessToken $token)
    {
        // The base library handles this via OIDC Discovery
        return parent::getBaseApiUrl($token);
    }

    /**
     * Returns the URL for requesting the resource owner's details.
     *
     * @param AccessToken $token
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        // The base library handles this via OIDC Discovery
        return parent::getResourceOwnerDetailsUrl($token);
    }

    /**
     * Checks a provider response for errors.
     *
     * @throws IdentityProviderException
     * @param ResponseInterface $response
     * @param array|string $data Parsed response data
     * @return void
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        // The base library handles this
        parent::checkResponse($response, $data);
    }
}
