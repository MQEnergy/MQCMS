/**
 * 注册、登录、注销
 */
import util from '@/libs/util';
import router from '@/router';
import { AccountLogin, AccountRegister, AccountLogout } from '@api/account';
import { Modal } from 'view-design';

export default {
    namespaced: true,
    actions: {
        /**
         * 登录
         * @param dispatch
         * @param account
         * @param password
         * @returns {Promise<unknown>}
         */
        login ({ dispatch }, {
            account = '',
            password = ''
        } = {}) {
            return new Promise((resolve, reject) => {
                // 开始请求登录接口
                AccountLogin({
                    account,
                    password
                })
                    .then(async res => {
                        util.cookies.set('uuid', res.uuid);
                        util.cookies.set('token', res.token);
                        // 设置 vuex 用户信息
                        await dispatch('admin/user/set', res.info, { root: true });
                        // 用户登录后从持久化数据加载一系列的设置
                        await dispatch('load');
                        // 结束
                        resolve();
                    })
                    .catch(err => {
                        reject(err);
                    })
            })
        },
        /**
         * 退出登录
         * @param commit
         * @param dispatch
         * @param confirm
         * @param vm
         */
        logout ({ commit, dispatch }, { confirm = false, vm } = {}) {
            async function logout () {
                AccountLogout().then(async res => {
                    util.cookies.remove('token');
                    util.cookies.remove('uuid');
                    await dispatch('admin/user/set', {}, { root: true });
                    router.push({
                        name: 'login'
                    });
                })
            }

            if (confirm) {
                Modal.confirm({
                    title: vm.$t('basicLayout.logout.confirmTitle'),
                    content: vm.$t('basicLayout.logout.confirmContent'),
                    onOk: () => {
                        logout();
                    }
                });
            } else {
                logout();
            }
        },
        /**
         * 注册
         * @param dispatch
         * @param email
         * @param account
         * @param password
         * @param phone
         * @param captcha
         * @returns {Promise<unknown>}
         */
        register ({ dispatch }, {
            email = '',
            account = '',
            password = '',
            phone = '',
            captcha = ''
        } = {}) {
            return new Promise((resolve, reject) => {
                AccountRegister({
                    email,
                    account,
                    password,
                    phone,
                    captcha
                })
                    .then(async res => {
                        util.cookies.set('uuid', res.uuid);
                        util.cookies.set('token', res.token);
                        await dispatch('admin/user/set', res.info, { root: true });
                        await dispatch('load');
                        resolve();
                    })
                    .catch(err => {
                        reject(err);
                    })
            })
        },
        /**
         * 用户登录后从持久化数据加载一系列的设置
         * @param state
         * @param dispatch
         * @returns {Promise<unknown>}
         */
        load ({ state, dispatch }) {
            return new Promise(async resolve => {
                await dispatch('admin/user/load', null, { root: true });
                await dispatch('admin/page/openedLoad', null, { root: true });
                resolve();
            })
        }
    }
};
