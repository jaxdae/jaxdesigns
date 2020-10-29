# Assets & Styles

## Static Assets

Static assets are located in the directory `resources/assets`.
By default these are split up into the folders `fonts`, `img` and `static` for general static assets, like the `browserconfig.xml` or favicons.

The contents of these folders will be processed during build by Webpack([Laravel Mix](https://laravel.com/docs/6.x/mix)) and made available in the `dist` directory.

The Webpack configuration (`webpack.mix.js`) is located in the root directory.

## Styles

The Towa boilerplate uses [SCSS](https://sass-lang.com/). As the main entrypoint for compiling the styles `resources/styles/main.scss` is used. Laravel Mix compiles the styles into the `dist/css` folder. The `dist/css/main.css` file is registered in WordPress and gets injected into the head of the page.

There are two different types of styles:

1) component styles
2) global styles

Component styles can be added by running `yarn create-component YOUR_COMPONENT_NAME`. This will create an SCSS and a TWIG file (this is the place to put the markup for that component) in `resources/components/YOUR_COMPONENT_NAME`. All you have to do afterwards is importing the SCSS file in `resources/styles/main.scss`.

The boilerplate contains a set of global styles like animations, buttons, colours, font-styles, a grid system, shadows and many more. All these are exposed as mixins which you can import them into the component styles and use them there (e.g. `@import '@styles/globals/_animations.scss';`) The styling of the global styles can be adjusted by changing the variables at the top of the partials.

To add global styles to the project you can create an SCSS partial in the `resources/styles/globals` folder. SCSS partial always start with an underscore (like `_buttons.scss`) this is a naming convention to identify the file as a partial. After creating the file it has to be included in the `resources/styles/main.scss`.
