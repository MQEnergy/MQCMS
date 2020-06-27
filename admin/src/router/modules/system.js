import BasicLayout from '@/components/layouts/basic-layout';

const meta = {
    auth: true
};

// const pre = 'system-';

export default {
    path: '/system',
    name: 'system',
    redirect: {
        name: `permission-admin`
    },
    meta,
    component: BasicLayout
};
