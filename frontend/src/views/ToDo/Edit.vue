<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Edit To-Do</h4>
            </div>
            <div class="card-body">
                <ul class="alert alert-warning" v-if="Object.keys(this.errorList).length > 0">
                    <li class="mb-0 ms-3" v-for="(errorL, index) in this.errorList" :key="index">
                        {{ errorL[0] }}
                    </li>
                </ul>
                <div class="mb-3">
                    <label for="">Title</label>
                    <input type="text" class="form-control" v-model="model.toDo.title">
                </div>
                <div class="mb-3">
                    <label for="">Description</label>
                    <textarea name="" id="" class="form-control" v-model="model.toDo.description"></textarea>
                </div>
                <div class="mb-3">
                    <label for="">Status</label>
                    <select name="" id=""  class="form-control" v-model="model.toDo.status">
                        <option value="Pending">Pending</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>
                <div class="mb-3">
                    <button type="button" class="btn btn-primary mx-2" @click="saveToDo">Save</button>
                    <button type="button" class="btn btn-secondary mx-2" @click="backToList">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
export default {
    name: 'todoEdit',
    data() {
        return {
            errorList: '',
            model: {
                toDo: {
                    title: '',
                    description: '',
                    status: '',
                }
            }
        }
    },
    mounted() {
        //this.getToDos();
        console.log(this.$route.params.id);
        this.getToDoData(this.$route.params.id);
    },
    methods: {
        saveToDo() {
            var mythis = this;
            axios
                .put(`http://localhost:8000/api/to_dos/${this.model.toDo.id}`, this.model.toDo)
                .then(res => {
                    console.log(res);
                    alert(res.data.message);
                    this.$router.push('/');
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
        },
        getToDoData(toDoID) {
            var mythis = this;
            axios
                .get(`http://localhost:8000/api/to_dos/${toDoID}`).then(res => {
                    this.model.toDo = res.data.toDo;
                })
                .catch(function (error) {
                    if (error.response) {
                        if (error.response.status = 404) {
                            alert('No ToDo ID found');
                            mythis.$router.push('/');
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
        },
        backToList(){
            this.$router.push('/') ;
        }
    }
}
</script>