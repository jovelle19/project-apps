import Vue from "vue";
import VueRouter from "vue-router";
Vue.use(VueRouter);
import home from "../components/MainComponent.vue";

const routes = [
    {
        path: "/home",
        component: () => home,
        name: "home",
    },
];

const router = new VueRouter({
    mode: "history",
    routes,
});

export default router;
