// require ('./bootstrap')
import Vue from 'vue'
import mysection from './vue/playerprofile'
import newsection from './vue/teamprofile'

new Vue({
    el: '#q',
    components: {mysection},
});


var app5 = new Vue({
    el: '#myid2',
    component: {newsection},
});


// Vue.component(
//     'example-component',
//     require('./components/ExampleComponent').default
// )
