/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import "./bootstrap";
import "./echo";
import { createApp } from "vue";

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});
import UploadAlert from "./components/UploadAlert.vue";
import DownloadAlert from "./components/DownloadAlert.vue";
import DownloadWarningModal from "./components/modals/DownloadWarningModal.vue";
import LogBody from "./components/LogBody.vue";
import Counter from "./components/Counter.vue";
import CounterAlert from "./components/CounterAlert.vue";
import ExcelExportAlert from "./components/ExcelExportAlert.vue";

import ProgressBar from "./components//toasts/ProgressBar.vue";

app.component("upload-alert", UploadAlert);
app.component("download-alert", DownloadAlert);
app.component("download-warning", DownloadWarningModal);
app.component("counter-component", Counter);
app.component("counter-alert", CounterAlert);
app.component("log-body", LogBody);
app.component("export-alert", ExcelExportAlert);

app.component("progress-bar-toast", ProgressBar);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount("#app");
