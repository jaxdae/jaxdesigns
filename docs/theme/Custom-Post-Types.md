# Custom Post Types (CPTs)

## What is a custom post type

Custom post types in Wordpress are representing custom type of content data. Out of the box there are different types like `Posts`, `Pages`, `Navigation`, `Menus` and so on. Read the [official Custom Post Types documentation](https://wordpress.org/support/article/post-types/) for more Details.

## Setup Custom Post Types

The `towa-theme/lib/Cpt/Person.php` is an example how a custom post type can be registered in our boilerplate.

Steps for registering a custom post type:

- create a PHP Class for a post type: For example `towa-theme/lib/Cpt/Person.php`
- let it extend the `TowaPost`-class
  - the parent class has some built-in functionality like handling data for acf-fields
- define the required arguments for registering the custom post type
  - see the [official documentation](https://codex.wordpress.org/Function_Reference/register_post_type) for available options
- register your class in the `towa-theme/lib/Controller/CptCtr.php` class
- to ensure that Timber uses the new custom post types correctly register your custom post type in the `get_cpt_classmap function` in `towa-theme/lib/Helper/global.php` function

## Good to know

- making a custom post type `public`, will provide a detail page in the frontend
  - that can be queried and indexed by search-robots
  - see the `public`-argument in the official documentation for details
