const path = require('path');

module.exports = {
    entry: [ './js/app.js', './scss/style.scss'],
    output: {
        filename: 'web/js/bundle.js',
        path: path.resolve(__dirname, '')
    },
    module: {
        rules: [
            {
                test: /\.scss$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[name].css',
                            outputPath: 'web/css'
                        }
                    },
                    {
                        loader: 'extract-loader'
                    },
                    {
                        loader: 'css-loader'
                    },
                    {
                        loader: 'sass-loader'
                    }
                ]
            }
        ]
    }
};