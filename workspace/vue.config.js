const path = require('path')

module.exports = {
    devServer: {
        watchOptions: {
            poll: 2000
        }
    },
    configureWebpack: {
        resolve: {
            alias: {
                '@': path.join(__dirname, '/resources') // 1. @の参照先の変更
            }
        }
    },
    outputDir: 'public', // 2. 出力先
    pages: {
        index: {
            entry: 'resources/js/main.js', // エントリーポイント
            template: '/public/index.html', //3. index.htmlテンプレート
            filename: 'index.html' // 省略可
        }
    }
}