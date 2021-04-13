const webpack = require("webpack");
const { merge } = require("webpack-merge");
const FriendlyErrorsWebpackPlugin = require("friendly-errors-webpack-plugin");
const { CleanWebpackPlugin } = require("clean-webpack-plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CopyPlugin = require("copy-webpack-plugin");
const path = require("path");
const config = require("./config");

const assetsFilenames = config.enabled.cacheBusting
  ? "[name].[contenthash]"
  : "[name]";
const chunkFilenames = config.enabled.cacheBusting
  ? "[id].[contenthash]"
  : "[id]";

async function webpackConfig() {
  let webpackConfig = {
    mode: config.env.production ? "production" : "development",
    context: config.paths.assets,
    entry: config.entry,
    devtool: config.enabled.sourceMaps ? "source-map" : undefined,
    output: {
      path: config.paths.dist,
      publicPath: config.publicPath,
      filename: `scripts/${assetsFilenames}.js`,
      chunkFilename: `scripts/${chunkFilenames}.js`,
    },
    stats: {
      hash: false,
      version: false,
      timings: false,
      children: false,
      errors: false,
      errorDetails: false,
      warnings: false,
      chunks: false,
      modules: false,
      reasons: false,
      source: false,
      publicPath: false,
    },
    module: {
      rules: [
        //
        // SCRIPTS
        //
        // {
        //   test: /\.js$/,
        //   exclude: [/node_modules/],
        //   use: [
        //     { loader: "cache-loader" },
        //     {
        //       loader: "babel-loader",
        //       options: {
        //         presets: ["@babel/preset-env"],
        //       },
        //     },
        //   ],
        // },
        {
          test: /\.(js)$/,
          // include: path.join(__dirname, "src"),
          exclude: [/node_modules/],
          loader: require.resolve("babel-loader"),
          options: {
            babelrc: false,
            presets: ["@babel/preset-env", "@babel/preset-react"],
            plugins: [
              require.resolve("@babel/plugin-proposal-optional-chaining"),
            ].filter(Boolean),
            // This is a feature of `babel-loader` for webpack (not Babel itself).
            // It enables caching results in ./node_modules/.cache/babel-loader/
            // directory for faster rebuilds.
            cacheDirectory: true,
            // See #6846 for context on why cacheCompression is disabled
            cacheCompression: false,
            compact: false,
          },
        },
        //
        // STYLES
        //
        {
          include: config.paths.assets,
          test: /\.(scss|css)$/,
          use: [
            {
              loader: MiniCssExtractPlugin.loader,
              options: {},
            },
            {
              loader: "css-loader",
              options: {
                sourceMap: config.enabled.sourceMaps,
                importLoaders: 2,
                url: false,
              },
            },
            {
              loader: "postcss-loader",
              options: {
                postcssOptions: {
                  config: `${__dirname}/postcss.config.js`,
                },
                sourceMap: config.enabled.sourceMaps,
              },
            },
            {
              loader: "sass-loader",
              options: {
                sourceMap: config.enabled.sourceMaps,
              },
            },
          ].filter(Boolean),
        },
      ],
    },
    plugins: [
      // Extract css to separate files
      new MiniCssExtractPlugin({
        filename: `styles/${assetsFilenames}.css`,
        chunkFilename: `styles/${chunkFilenames}.css`,
      }),
      // Remove /dist directory before build
      config.enabled.watcher ? null : new CleanWebpackPlugin(),
      // Print nice errors
      new FriendlyErrorsWebpackPlugin(),
      // Make jQuery available without importing. We don't support jQuery, but sometimes you can't avoid it
      new webpack.ProvidePlugin({
        $: "jquery",
        jQuery: "jquery",
        "window.jQuery": "jquery",
      }),
      new CopyPlugin({
        patterns: [
          {
            from: path.join(config.paths.assets, "fonts"),
            to: path.join(config.paths.dist, "fonts"),
          },
        ],
      }),
    ].filter(Boolean),
    externals: {
      jquery: "jQuery",
    },
  };

  if (config.enabled.optimize) {
    webpackConfig = merge(
      webpackConfig,
      require("./webpack.config.optimize")(config)
    );
  }

  if (config.env.production) {
    webpackConfig.plugins.push(new webpack.NoEmitOnErrorsPlugin());
  }

  if (config.enabled.cacheBusting) {
    const WebpackAssetsManifest = require("webpack-assets-manifest");

    webpackConfig.plugins.push(
      new WebpackAssetsManifest({
        output: "assets.json",
        space: 2,
        writeToDisk: false,
        assets: config.manifest,
        replacer: require("./util/assetManifestsFormatter"),
      })
    );
  }

  if (config.enabled.watcher) {
    webpackConfig.entry = require("./util/addHotMiddleware")(
      webpackConfig.entry
    );
    webpackConfig = merge(
      webpackConfig,
      await require("./webpack.config.watch")(config)
    );
  }

  return webpackConfig;
}

module.exports = webpackConfig();
