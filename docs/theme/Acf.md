# Acf

## Introduction

The Boilerplate is depending on the lugin [Advanced Custom Fields - ACF](https://www.advancedcustomfields.com/). The plugin provides a framework for extending meta-fields on available posts, taxonomies and options for WordPress.

## Register new Fieldgroup (Add new ACF Field to Post)

- look into Folder `towa-theme/lib/ACF/Groups/`
- there you have examples of how to register ACF Field groups.
- Use ACF Controller to register the ACF Field Group
- Field types are defined via Composer (vendor/towa/towa-acf-fields/src/fields)
- set the location where the group should be displayed
- use *'towa_admin'* text domain for translations in the Backend. This way you can determine between frontend and backend later in the translation process

### Finding options for registering groups and fields

In the WordPress backend, you can also add groups and fields via the available UI which ACF provides. After creating those, you can export it into a php-snippet, which will show up all availalbe options for your configuration. That way, we can find available options for the ACF stuff.

## Extensions

The ACF library can be extendend with new field types. An example is the **Iconpicker**. See the github-repo to see some details.

## Good to know

- we have acf-sdk which is registered in our `composer.json` dependencies
- ACF Plugin must be activated
  - with wp-cli: `wp plugin activate advanced-custom-fields-pro --skip-themes`
- we always register ACF groups & fields in our theme via code
  - see `lib/Controller/AcfController.php`
