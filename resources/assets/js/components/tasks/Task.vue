<template lang="html">
    <tr>
        <td>
            <div class="form-group">
                <input type="text" class="form-control" v-model="formEdit.description" v-if="edit">
                <span v-else>{{ task.description }}</span>

                <br>

                <span class="label label-primary" v-show="!edit">Created at&nbsp;{{ task.created_at }}</span>
                <span class="label label-default" v-show="!edit">Updated at&nbsp;{{ task.updated_at }}</span>
            </div>
        </td>
        <td width="140">
            <select class="form-control" v-if="edit" v-model="formEdit.completed">
                <option value="1" :selected="formEdit.completed == 1 ? true : false">completed</option>
                <option value="0" :selected="formEdit.completed == 0 ? true : false">pendent</option>
            </select>

            <span class="label label-success" v-if="task.completed" v-show="!edit">completed</span>
            <span class="label label-info" v-else v-show="!edit">pendent</span>
        </td>
        <td width="150">
            <button class="btn btn-success btn-xs is-50" @click="finishTask(task)" :disabled="task.completed == 1 ? true : false" v-if="!edit">
                finish
            </button>
            <button class="btn btn-success btn-xs is-50" @click="updateTask" v-if="edit">
                update
            </button>
            <button class="btn btn-primary btn-xs is-50" @click="editTask" v-if="!edit">
                edit
            </button>
            <button class="btn btn-default btn-xs is-50" @click="cancelEdit" v-if="edit">
                cancel
            </button>
            <button class="btn btn-danger btn-xs" @click="$emit('delete-task', task)">
                <i class="glyphicon glyphicon-trash"></i>
            </button>
        </td>
    </tr>
</template>

<script>
export default {
    props: ['task'],
    data() {
        return {
            edit: false,
            formEdit: {
                description: '',
                completed: 0
            }
        }
    },
    methods: {
        editTask () {
            this.edit = true
            this.formEdit.description = this.task.description
            this.formEdit.completed = this.task.completed
        },

        cancelEdit() {
            this.edit = false
            this.formEdit.description = ''
            this.formEdit.description = 0
        },

        finishTask (task) {
            this.update(task.id, { completed: true, description: task.description }).then(response => {
                this.$emit('complete-task')
                console.log(response.data)
            })
        },

        updateTask () {
          this.update(this.task.id, this.formEdit).then(response => {
              this.$emit('task-updated')
              this.cancelEdit()
              console.log(response)
          }, error => {
              console.log(error.response.data)
          })
        },

        update (task_id, data) {
            return axios.put(`/tasks/${task_id}`, data)
        }
    }
}
</script>

<style>
    .is-50 { width: 50px;}
</style>