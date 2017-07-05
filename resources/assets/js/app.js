require('./bootstrap')
window.Vue = require('vue')

import Users from './components/users/Users.vue'
import Tasks from './components/tasks/Tasks.vue'

const app = new Vue({
    el: '#app',
    components: { Users, Tasks }
})
