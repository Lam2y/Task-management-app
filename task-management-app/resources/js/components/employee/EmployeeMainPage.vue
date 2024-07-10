<script setup>
import { ref, onMounted} from 'vue';
import axios from 'axios';

const quote=ref([]);
const user_details = ref([]);
let created_at = ref([]);
let num=ref([]);

const getUserDetails = () => {
    axios.get('/api/user-details')
        .then(response => {
            user_details.value = response.data;
            console.log(user_details.value);
            created_at=user_details.value.created_at.slice(0,10);
            console.log(created_at);
        })
        .catch(error => {
            console.error('Error fetching user details:', error);
        });
    
    axios.get('https://type.fit/api/quotes')
        .then(response => {
            quote.value = response.data;
            console.log(quote.value);
        })
        .catch(error => {
            console.error('Error fetching quote:', error);
        });
};

const randomnumber =()=>{
    num=Math.floor(Math.random(0,15) * 10);
} 

onMounted(() => {
    getUserDetails();
    randomnumber();
});
</script>
<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Welcome back, {{ user_details.name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Main Page</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Name</h5>
                        </div>
                        <div class="card-body">
                            <p>{{ user_details.name }}</p>
                        </div>
                    </div>
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">User type</h5>
                        </div>
                        <div class="card-body">
                            <p>{{ user_details.usertype }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Email</h5>
                        </div>
                        <div class="card-body">
                            <p>{{ user_details.email }}</p>
                        </div>
                    </div>
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Joined Since</h5>
                        </div>
                        <div class="card-body">
                            <p>{{created_at}}</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0 text-center">Quote of the Day</h5>
                        </div>
                        <div class="card-body">
                            <h3 class="text-center">{{ quote[num]? quote[num].text:''}}</h3>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</template>