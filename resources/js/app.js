require('./bootstrap');

const {initializeApp, ADMIN_MOUNT_SELECTOR} = require('./vue/vue');

if (document.querySelector(ADMIN_MOUNT_SELECTOR)) {
    initializeApp();
}
