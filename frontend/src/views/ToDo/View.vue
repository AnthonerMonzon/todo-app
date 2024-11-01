<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4>
                    To Do
                    <RouterLink to="/to-do/create" class="btn btn-primary float-end">
                        Add To-Do
                    </RouterLink>

                </h4>
                <div class="mb-3">
                    <label for="">Filter Status</label>
                    <select name="" id="" class="form-control" @change="filterToDo" v-model="filterStatus">
                        <option value="All">All</option>
                        <option value="Pending">Pending</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Create At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody v-if="this.toDos.length > 0">
                        <tr v-for="(toDo, index) in this.toDos" :key="index" >
                            <td>{{ toDo.id }}</td>
                            <td>{{ toDo.title }}</td>
                            <td>{{ toDo.description }}</td>
                            <td>
                                <span class="badge text-bg-warning" v-if="toDo.status == 'Pending'">Pending</span>
                                <span class="badge text-bg-info" v-else-if="toDo.status == 'Completed'">Completed</span>
                            </td>
                            <td>{{ toDo.created_at }}</td>
                            <td>
                                <RouterLink :to="{ path: '/to-do/' + toDo.id + '/edit' }" class="btn btn-success mx-2">
                                    Edit
                                </RouterLink>
                                <button type="button" class="btn btn-danger mx-2" @click="deleteToDo(toDo.id)">
                                    Delete
                                </button>
                                <button type="button" class="btn btn-info mx-2" v-if="toDo.status == 'Pending'"
                                    @click="markedAsStatus(toDo.id, toDo, 'Completed')">
                                    Mark as Completed
                                </button>
                                <button type="button" class="btn btn-warning mx-2"
                                    v-else-if="toDo.status == 'Completed'"
                                    @click="markedAsStatus(toDo.id, toDo, 'Pending')">
                                    Mark as Pending
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else-if="this.toDos.length == 0">
                        <tr>
                            <td colspan="6">no data</td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="6">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    name: 'todo',
    data() {
        return {
            filterStatus: 'All',
            toDos: []
        }
    },
    mounted() {
        this.getToDos();
        //console.log('active');
    },
    methods: {
        getToDos() {

            axios.get('http://localhost:8000/api/to_dos').then(res => {
                this.toDos = res.data.toDo;
                console.log(this.toDos);
            });
        },
        deleteToDo(toDoID) {
            if (confirm('Are you sure, you want to delete this data?')) {
                var mythis = this;
                axios
                    .delete(`http://localhost:8000/api/to_dos/${toDoID}`)
                    .then(res => {
                        alert(res.data.message);
                        mythis.getToDos(); //refresh
                    })
                    .catch(function (error) {
                        if (error.response) {
                            if (error.response.status = 422) {
                                mythis.errorList = error.response.data.errors;
                            }

                            if (error.response.status = 404) {
                                alert('No ToDo ID found');
                                mythis.$router.push('/to-do');
                            }
                            // console.log(error.response.data);
                            // console.log(error.response.status);
                            // console.log(error.response.headers);
                        } else if (error.request) {
                            // The request was made but no response was received
                            // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                            // http.ClientRequest in node.js
                            console.log(error.request);
                        } else {
                            // Something happened in setting up the request that triggered an Error
                            console.log('Error', error.message);
                        }
                        console.log(error.config);

                    });
            }
        },
        markedAsStatus(toDoID, toDo, status) {

            if (confirm(`Do you want to marked this data as ${status}?`)) {
                toDo.status = status;
                axios
                    .put(`http://localhost:8000/api/to_dos/${toDoID}`, toDo)
                    .then(res => {
                        console.log(res);
                        alert(res.data.message);
                        //this.$router.push('/to-do');
                    })
                    .catch(function (error) {
                        if (error.response) {
                            if (error.response.status = 422) {
                                mythis.errorList = error.response.data.errors;
                            }

                            if (error.response.status = 404) {
                                alert('No ToDo ID found');
                                mythis.$router.push('/to-do');
                            }
                            // console.log(error.response.data);
                            // console.log(error.response.status);
                            // console.log(error.response.headers);
                        } else if (error.request) {
                            // The request was made but no response was received
                            // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                            // http.ClientRequest in node.js
                            console.log(error.request);
                        } else {
                            // Something happened in setting up the request that triggered an Error
                            console.log('Error', error.message);
                        }
                        console.log(error.config);

                    });
            }
        },
        filterToDo(){
            var queryStr = this.filterStatus == "All" ? "" : "?status=" + this.filterStatus;
            
            axios.get(`http://localhost:8000/api/to_dos${queryStr}`).then(res => {
                this.toDos = res.data.toDo;
                console.log(this.toDos);
            });
        }
    },
}

</script>