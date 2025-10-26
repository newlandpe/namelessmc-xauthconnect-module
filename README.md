# NamelessMC XAuthConnect Module

A NamelessMC module offering secure OAuth2 authentication by integrating with XAuthConnect as an external identity provider.

## Features

*   **Secure OAuth2 Authentication:** Integrate your NamelessMC forum with your XAuthConnect server for robust and secure user logins.
*   **User Linking & Registration:** Seamlessly link existing NamelessMC accounts with XAuthConnect identities or allow new users to register using XAuthConnect.
*   **Admin Panel Configuration:** Easily configure XAuthConnect client ID, client secret, and issuer URL directly from the NamelessMC admin panel.
*   **Customizable:** Utilizes NamelessMC's integration framework for easy customization and extension.

## Requirements

*   NamelessMC version 2.2.3 or higher
*   PHP 7.4 or higher
*   `newlandpe/oauth2-xauthconnect` library installed via Composer in your NamelessMC root directory.
*   An active XAuthConnect server (e.g., `http://xauth-server.com`)
*   An XAuthConnect application configured with the correct Redirect URI.

## Installation

1.  **Install `newlandpe/oauth2-xauthconnect` library:**
    Navigate to your NamelessMC root directory and run:
    ```bash
    composer require newlandpe/oauth2-xauthconnect
    ```
    *Note: If you are developing the `oauth2-xauthconnect` library locally, you can configure a `path` repository in your NamelessMC `composer.json`.*

2.  **Upload Module Files:**
    Copy the contents of the `upload/` directory from this module's repository into the root directory of your NamelessMC installation.

3.  **Enable the Module:**
    *   Log in to your NamelessMC admin panel.
    *   Navigate to `Modules`.
    *   Find "XAuthConnect Integration" and click "Install".
    *   Ensure the module is enabled.

4.  **Configure XAuthConnect:**
    *   In the NamelessMC admin panel, navigate to `Integrations` -> `XAuthConnect`.
    *   Enter your XAuthConnect **Client ID**, **Client Secret**, and **Issuer URL**.
    *   Note the **Redirect URI** displayed on this page.

5.  **Configure your XAuthConnect Application:**
    *   Go to your XAuthConnect application settings.
    *   Add the **Redirect URI** obtained from the NamelessMC admin panel to your XAuthConnect application's allowed redirect URIs.

## Usage

Once configured and enabled, users will see a "Login with XAuthConnect" option on your NamelessMC login and registration pages. Clicking this will redirect them to your XAuthConnect server for authentication.

## Troubleshooting

*   **Module not appearing:** Ensure all files from the `upload/` directory were copied correctly to your NamelessMC root.
*   **OAuth2 errors:** Double-check your Client ID, Client Secret, Issuer URL, and Redirect URI in both NamelessMC and your XAuthConnect application settings.
*   **Composer issues:** Ensure `newlandpe/oauth2-xauthconnect` is correctly installed via Composer.
*   **NamelessMC logs:** Check your NamelessMC error logs for more detailed information.

## Contributing

Contributions are welcome and appreciated! Here's how you can contribute:

1. Fork the project on GitHub.
2. Create your feature branch (`git checkout -b feature/AmazingFeature`).
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`).
4. Push to the branch (`git push origin feature/AmazingFeature`).
5. Open a Pull Request.

Please make sure to update tests as appropriate and adhere to the existing coding style.

## License

This module is licensed under the [CSSM Unlimited License v2.0](LICENSE).
