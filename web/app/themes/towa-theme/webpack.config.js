/* eslint-disable no-console */

const Autoprefixer = require("autoprefixer");
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const path = require("path");
// const glob = require("glob-all");
const UglifyJSPlugin = require("uglifyjs-webpack-plugin");
const webpack = require("webpack");
const CopyWebpackPlugin = require("copy-webpack-plugin");
// const PurifyCSSPlugin = require("purifycss-webpack");

const IS_PRODUCTION = process.env.NODE_ENV === "production";

// get public path from .env file
const envPath = path.resolve("../../../../.env"); // path to .env file
require("dotenv-extended").load({
  allowEmptyValues: true,
  path: envPath
});

const publicPath = `${process.env.WP_HOME}/app/themes/towa-theme/dist/`;

function resolve(dir) {
  return path.join(__dirname, dir);
}

const entry = ["./resources/index.js"];
if (!IS_PRODUCTION) {
  entry.push("./tools/tmp/timestamp");
}

function getPlugins() {
  const plugins = [
    new ExtractTextPlugin("main.css"),
    new webpack.HotModuleReplacementPlugin(),
    new webpack.NoEmitOnErrorsPlugin(),
    new webpack.DefinePlugin({
      IS_PRODUCTION
    }),
    // not working for WYSIWYG.json and WYSIWYG from Database
    // new PurifyCSSPlugin({
    //   paths: glob.sync([
    //     path.join(__dirname, "views/**/*.twig"),
    //     path.join(__dirname, "resources/*.js"),
    //     path.join(__dirname, "resources/components/**/*.twig"),
    //     path.join(__dirname, "resources/components/**/*.js")
    //   ]),
    //   purifyOptions: {
    //     info: true
    //   }
    // }),
    new CopyWebpackPlugin([
      {
        from: "./resources/assets/static",
        to: "assets/static"
      }
    ])
  ];

  // Conditionally add plugins for Production builds.
  if (process.env.NODE_ENV === "production") {
    plugins.push(new UglifyJSPlugin());
  }
  return plugins;
}

module.exports = {
  entry,
  output: {
    filename: "bundle.js",
    libraryTarget: "umd",
    path: resolve("dist")
  },
  devServer: {
    headers: {
      "Access-Control-Allow-Origin": "*"
    },
    contentBase: resolve("dist"),
    quiet: false,
    hot: true
  },
  node: {
    fs: "empty"
  },
  resolve: {
    modules: ["node_modules", "./"]
  },
  plugins: getPlugins(),
  module: {
    rules: [
      {
        test: /\.js$/,
        loader: "babel-loader"
      },
      {
        test: /\.(png|jpg|gif|svg)$/,
        loader: "url-loader",
        options: {
          outputPath: "",
          limit: 1000,
          name: "[name].[ext]",
          publicPath
        }
      },
      {
        test: /\.(woff2?|eot|ttf|otf)(\?.*)?$/,
        loader: "url-loader",
        options: {
          outputPath: "",
          limit: 1000,
          name: "[name].[hash:7].[ext]",
          publicPath
        }
      },
      {
        test: /\.(mp4|webm|ogg|mp3|wav|flac|aac|xml|webmanifest|ico)(\?.*)?$/,
        loader: "url-loader",
        options: {
          outputPath: "assets/media/",
          limit: 1000,
          name: "[name].[hash:7].[ext]",
          publicPath
        }
      },
      {
        test: /\.scss$/,
        use: IS_PRODUCTION
          ? undefined
          : [
              "style-loader",
              "css-loader",
              {
                loader: "postcss-loader",
                options: {
                  plugins: () => [Autoprefixer]
                }
              },
              "sass-loader"
            ],
        loader: IS_PRODUCTION
          ? ExtractTextPlugin.extract({
              fallback: "style-loader",
              use: [
                {
                  loader: "css-loader",
                  options: {
                    minimize: true,
                    modules: false
                  }
                },
                {
                  loader: "postcss-loader",
                  options: {
                    plugins: () => [Autoprefixer]
                  }
                },
                {
                  loader: "sass-loader"
                }
              ]
            })
          : undefined
      }
    ]
  }
};
