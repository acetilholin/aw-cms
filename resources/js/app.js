import Calculation from "./components/Calculation";
import Contact from "./components/Contact";
import EnCalculation from "./components/EnCalculation";
import EnContact from "./components/EnContact";

require('./bootstrap');
window.Vue = require('vue');

Vue.config.silent = true  /* Suppress all Vue logs and warnings */

const app = new Vue({
    el: '#app',
    components: {
        calculation: Calculation
    }
});

const contact = new Vue({
    el: '#contact',
    components: {
        contact: Contact
    }
});

const appeng = new Vue({
    el: '#appeng',
    components: {
        ecalc: EnCalculation
    }
});

const enc = new Vue({
    el: '#enc',
    components: {
        encontact: EnContact
    }
});