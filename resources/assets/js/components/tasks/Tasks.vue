<template lang="html">
    <div>
        <form @submit.prevent="createTask">
            <div :class="{'form-group' : true, 'has-error' : errors.description}">
                <label class="control-label">Descrição</label>
                <input type="text" class="form-control" v-model="newTask.description" autofocus>
                <span class="help-block" v-if="errors.description" v-for="error in errors.description" :key="error.id">{{ error }}</span>
            </div>

            <div class="form-group">
                <button class="btn btn-primary" type="submit">Salvar</button>
            </div>
        </form>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>
                        Task
                        <span class="glyphicon glyphicon-sort" :class="{
                                'glyphicon-sort-by-attributes': sort.column == 'description' && sort.reverse,
                                'glyphicon-sort-by-attributes-alt': sort.column == 'description' && !sort.reverse
                            }"
                            @click="sortBy('description')">
                        </span>
                    </th>
                    <th>
                        Status
                        <span class="glyphicon glyphicon-sort" :class="{
                            'glyphicon-sort-by-attributes': sort.column == 'completed' && sort.reverse,
                            'glyphicon-sort-by-attributes-alt': sort.column == 'completed' && !sort.reverse
                        }" @click="sortBy('completed')">
                        </span>
                    </th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <task v-for="task in getTasks" :key="task.id"
                    v-bind="{ task }"
                    @delete-task="deleteTask"
                    @complete-task="fetchTasks"
                    @task-updated="fetchTasks"/>
            </tbody>
        </table>
    </div>
</template>

<script>
import Task from './Task.vue'

export default {
    data() {
        return {
            errors: [],
            tasks: [],
            newTask: {
                description: ''
            },
            sort: {
                column: 'description',
                reverse: false
            }
        }
    },

    components: { Task },

    created() {
        this.fetchTasks()
    },

    computed: {
        getTasks () {
            return this.tasks.sort((a, b) => {
                let comparation = this.sort.reverse
                    ? a[this.sort.column] > b[this.sort.column]
                    : a[this.sort.column] < b[this.sort.column]

                return comparation ? -1 : 1
            })
        }
    },

    methods: {
        fetchTasks () {
            axios.get('/tasks/all').then(response => {
                this.tasks = response.data.tasks
            })
        },

        createTask () {
            axios.post('/tasks', this.newTask).then(response => {
                this.tasks.push(response.data.task)
                this.newTask.description = ''

                console.log(response.data)
            }, error => {
                this.errors = error.response.data

                console.log(this.errors)
            })
        },

        deleteTask (task) {
            axios.delete(`tasks/${task.id}`).then(response => {
                this.tasks.splice(this.tasks.indexOf(task), 1)

                console.log(response.data)
            })
        },

        sortBy (column) {
            this.sort.reverse = !this.sort.reverse
            this.sort.column = column
        }
    }

}
</script>
