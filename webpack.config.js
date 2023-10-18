const path = require("path");
const { VueLoaderPlugin } = require("vue-loader");

module.exports = {
    entry: "./src/app.js",
    output: {
        path: path.resolve(__dirname, "webroot/js"),
        filename: "bundle.js",
    },
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: "vue-loader",
            },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader'
                }
            },
            {
                test: /\.css$/,
                use: ["style-loader", "css-loader"],
            },
        ],
    },
    resolve: {
        alias: {
            vue$: "vue/dist/vue.esm.js",
            '@': path.resolve(__dirname, 'src/')
        },
    },
    devtool: "inline-source-map",
    plugins: [new VueLoaderPlugin()],
};
