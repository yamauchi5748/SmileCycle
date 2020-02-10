const path = require('path');
module.exports = {
    configureWebpack: {
        resolve: {
            alias: {
                '@': path.join(__dirname, "/src")
            }
        }
    },
    devServer: {
        watchOptions: {
            poll: 2000
        },
        proxy: {
            "/socket.io": {
                target: "http://localhost:3000",
            },
            "/api": {
                target: "http://localhost:3000",
            }
        }
    },
    filenameHashing: false,
    "transpileDependencies": [
        "vuetify"
    ]
}