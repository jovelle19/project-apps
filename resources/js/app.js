/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue").default;
import Vuetify from "../plugins/vuetify";
import VueRouter from "vue-router";
import router from "./router";

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);

Vue.component(
    "main-component",
    require("./components/MainComponent.vue").default
);

Vue.use(VueRouter);

const app = new Vue({
    el: "#app",
    vuetify: Vuetify,
    router,
});
