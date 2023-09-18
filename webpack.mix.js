const mix = require('laravel-mix');
const path = require('path')

mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.pug$/,
                loader: 'pug-plain-loader'
            },
            {
                test: /\.scss$/,
                use: [
                    'sass-loader'
                ]
            }
        ]
    },
    resolve: {
        alias: {
            "@components": path.resolve(
                __dirname,
                "resources/assets/js/components"
            )
        }
    }
});

mix.js('resources/js/basicPackages.js', 'public/js').vue()
mix.js('resources/js/layout.js', 'public/js').vue()
mix.js('resources/js/layoutWithHeader.js', 'public/js').vue()
mix.js('resources/js/welcome.js', 'public/js').vue()
mix.js('resources/js/aboutUs.js', 'public/js').vue()
mix.js('resources/js/contactAndFAQ.js', 'public/js').vue()
