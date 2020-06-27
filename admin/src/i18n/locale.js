import zhCN from './locale/zh-CN';
import enUS from './locale/en-US';

import zhCNiView from 'view-design/dist/locale/zh-CN';
import enUSiView from 'view-design/dist/locale/en-US';

import layoutLocale from '@/components/layouts/basic-layout/i18n';

export default {
    'zh-CN': Object.assign(zhCN, zhCNiView, layoutLocale['zh-CN']),
    'en-US': Object.assign(enUS, enUSiView, layoutLocale['en-US'])
};
