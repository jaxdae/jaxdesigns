# Configuration

This part desribes the available configuration files and what to look for.

## ENV Variables

The ENV Variables are mainly for WordPress. Additionally, we maintain any key which is needed for third-party libraries or apis.

### WordPress Related

- `DB_NAME`: required | name of the database which WordPress should connect to
- `DB_USER`: required | user for the database
- `DB_PASSWORD`: required | password for the database
- `DB_HOST`: optional | if not defined, `localhost` will be used
- `DB_PREFIX`: optional | if not defined, `wp_` will be used
- `SHOW_ADMIN_BAR`: optional | enable/disable displaying the admin-bar if logged-in
- `WP_ENV`: required | define the stage for the current installation. Based on it configuration files will be loaded
- `WP_HOME`: required | domain name of the website
- `WP_SITEURL`: required | path for the website
- Salts
  - the following are all salt-key, which can be generated [here](https://roots.io/salts.html)
  - `AUTH_KEY`, `SECURE_AUTH_KEY`, `LOGGED_IN_KEY`, `NONCE_KEY`, `AUTH_SALT`, `SECURE_AUTH_SALT`, `LOGGED_IN_SALT`, `NONCE_SALT`

### Libraries, Services

- `ACF_PRO_KEY`: required | is used during the composer installation
- `GOOGLE_MAPS`: optional | if google-maps services are required in the project

### Development Purpose

- `SHOW_ADMIN_BAR`: optional | enable it on non-productive environments. It shows a badge for showing the current breakpoint
