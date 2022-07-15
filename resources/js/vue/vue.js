import {createApp} from 'vue'

import charts from "./chartjs";
import d3 from "./d3";
import smbeditor from "./SuperMegaBaseball/smbeditor"

export const ADMIN_MOUNT_SELECTOR = '#hoops-app';

/**
 * Handles the registration of components.
 *
 * Currently, we explicitly register our vue components.
 * We could automatically register components in the `./components` directory.
 *
 * @param app
 */
function registerComponents(app) {

    // Chart.js
    app.component('charts', charts);

    // D3
    app.component('d3', d3);

    app.component('smbeditor', smbeditor)

}

/**
 * Handles initializing the top level application for our project.
 */
export function initializeApp() {
    const app = createApp({
        data() {
            return {
                // darkMode: false,
                // phoneServiceContainer: false,
                // phoneServiceActive: false,
            }
        },
        created() {
            // this.darkMode = window.localStorage.getItem("admin-dark-mode") === "dark";
        },
        methods: {
            // toggleDarkMode() {
            //     this.darkMode = !this.darkMode;
            //     window.localStorage.setItem("admin-dark-mode", this.darkMode ? "dark" : "light");
            // },
            //
            // // Converted old Vanilla JS Phone Service/Ring Central functionality to Vue.
            // togglePhoneServiceDropdown() {
            //     this.phoneServiceContainer = ! this.phoneServiceContainer;
            // },
            // togglePhoneService() {
            //     this.phoneServiceActive = ! this.phoneServiceActive;
            //     if(this.phoneServiceActive) {
            //         document.dispatchEvent(new CustomEvent('ring-central-authentication', {}));
            //         console.log('Test: Phone Service is Active')
            //     }
            //     else {
            //         document.dispatchEvent(new CustomEvent('ring-central-logout', {}));
            //         console.log('Test: Phone Service is Inactive')
            //     }
            // },
        }
    });



    if(process && process.env && process.env.MIX_APP_ENV === "local")
        app.config.devtools = true;

    registerComponents(app);
    app.mount(ADMIN_MOUNT_SELECTOR);
}
