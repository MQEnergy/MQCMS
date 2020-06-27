/**
 * 插件
 * */

// 错误捕获
import pluginError from '@/plugins/error';
// 日志插件
import pluginLog from '@/plugins/log';
// color指令
import { colorInserted, resizeInserted, fontInserted, heightInserted, widthInserted, bgColorInserted } from '@/plugins/directive';

export default {
    async install (Vue, options) {
        // 插件
        Vue.use(pluginError);
        Vue.use(pluginLog);

        // 指令
        Vue.directive('color', colorInserted);
        Vue.directive('resize', resizeInserted);
        Vue.directive('font', fontInserted);
        Vue.directive('height', heightInserted);
        Vue.directive('width', widthInserted);
        Vue.directive('bg-color', bgColorInserted);
    }
}
