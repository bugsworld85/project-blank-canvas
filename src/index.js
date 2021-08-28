import Vue from "vue";

Vue.config.productionTip = false;

Vue.component('donation-box', require('./components/DonationBox.vue').default);

const app = new Vue({
    el: '#primary',
});