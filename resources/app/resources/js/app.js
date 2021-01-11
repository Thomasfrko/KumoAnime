require('./bootstrap')

window.Vue = require('vue')

Vue.component('add-anime', require('./components/add-anime.vue').default)
Vue.component('anime', require('./components/anime.vue').default)
Vue.component('catalog-anime', require('./components/catalog-anime.vue').default)
Vue.component('categories', require('./components/categories.vue').default)
Vue.component('list-links', require('./components/list-search.vue').default)
Vue.component('watch', require('./components/watch.vue').default)
Vue.component('default', require('./components/default.vue').default)
Vue.component('settings', require('./components/settings.vue').default)

const app = new Vue({
    el: '#app'
});