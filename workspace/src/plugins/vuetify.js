import Vue from 'vue';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';

// 日本語
import ja from 'vuetify/es5/locale/ja.js'

Vue.use(Vuetify);

export default new Vuetify({
    // 言語
    lang: {
        locales: { ja },
        current: "ja"
    },
    // ブレイクポイント
    breakpoint: {
        thresholds: {
            xs: 320,
            sm: 480,
            md: 768,
            lg: 1280,
        },
        scrollBarWidth: 24,
    },
    // カラー
    theme: {
        themes: {
            light: {
                primary: '#ff9900',
                secondary: '#f57d00',
                accent: '#009680',
                error: '#FF5252',
                info: '#2196F3',
                success: '#4CAF50',
                warning: '#FFC107'
            },
        },
    },
});
