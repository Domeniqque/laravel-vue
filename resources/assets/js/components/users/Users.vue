<template lang="html">
    <div>
        <form method="POST" v-on:submit.prevent="createUser">
            <div v-bind:class="{'form-group': true, 'has-error': errors.username}">
                <input type="text" class="form-control" v-model="user.username">
                <span class="help-block" v-for="error in errors.username">{{ error }}</span>
            </div>
            <div v-bind:class="{'form-group': true, 'has-error': errors.email}">
                <input type="text" class="form-control" v-model="user.email">
                <span class="help-block" v-for="error in errors.email">{{ error }}</span>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Create new user</button>
            </div>
        </form>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>email</th>
                    <th>Ations</th>
                </tr>
            </thead>
            <tbody>
                <user v-for="user in users" :user="user" :key="user.id"
                    @delete-user="deleteUser"
                    @update-user="fetchUsers"
                ></user>
            </tbody>
        </table>
    </div>
</template>

<script>
import User from './User.vue'

export default {
    data() {
        return {
            user: {
                username: '',
                email: ''
            },
            users: [],
            errors: []
        }
    },
    components: { User },
    created() {
        this.fetchUsers()
    },
    methods: {
        fetchUsers () {
            axios.get('/users').then(response => {
                this.users = response.data.users
            })
        },

        createUser () {
            axios.post('/users', this.user).then(response => {
                this.users.push(response.data.user)
                this.user = { username: '', email: '' }
                this.errors = []

                console.log(response.data)
            }, error => {
                this.errors = error.response.data
            })
        },

        deleteUser (user) {
            axios.delete(`/users/${user.id}`).then(response => {
                this.users.splice(this.users.indexOf(user), 1)

                console.log(response.data)
            })
        }
    }
}
</script>

<style lang="css">

</style>