<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row d-flex">
                            <div class="col">
                                List of customers
                            </div>
                            <div class="col">
                                <button class="btn btn-primary">Add Customer</button>
                                <button class="btn btn-success" @click="reLoad()">Reload Page</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-2 offset-md-1">
                           <label for=""> <strong class="text-center">Search By:-</strong></label>
                        </div>
                        <div class="col-md-3">
                            
                            <select class="form-control" v-model="queryInput">
                                <option>Select Option</option>
                                <option value="name">Name</option>
                                <option value="email">Email</option>
                                <option value="address">Address</option>
                                <option value="mobile">Mobile</option>
                                <option value="total">Total</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" v-model="searchKey" placeholder="Searach" class="form-control">
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Operations</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(customer, index) in customers.data"
                                    :key="customer.id"
                                 >
                                    <td>{{ index + 1 }}</td>
                                    <td>
                                        <img
                                            :src="customer.image"
                                            height="50"
                                            width="50"
                                        />
                                    </td>
                                    <td>{{ customer.name }}</td>
                                    <td>{{ customer.email }}</td>
                                    <td>{{ customer.mobile }}</td>
                                    <td>{{ customer.address }}</td>
                                    <td>{{ customer.total }}</td>
                                    <td v-if="customer.status === 1">Active</td>
                                    <td v-else>Inactive</td>
                                    <td>
                                        <a
                                            href="#"
                                            class="btn btn-sm btn-info"
                                            title="Update"
                                            >Edit</a
                                        >
                                        <a
                                            href="#"
                                            class="btn btn-sm btn-danger"
                                            title="Delete"
                                            >Delete</a
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- <div v-if="!customers.length" :class="errorMsgStyle">{{ errorText }}</div> -->
                        <!-- <pagination :data="customers" @pagination-change-page="getAllCustomers"></pagination> -->
                        <pagination
                            :data="customers"
                            @pagination-change-page="getAllCustomers"
                        >
                            <span slot="prev-nav">&lt; Previous</span>
                            <span slot="next-nav">Next &gt;</span>
                        </pagination>
                    </div>
                </div>
            </div>
        </div>
        <vue-progress-bar></vue-progress-bar>
    </div>
</template>

<script>
export default {
    data() {
        return {
            queryInput: 'name',
            searchKey: '',
            customers: [],
            imagePath: "",
            errorMsgStyle:{
                       'text-center': true,
                       'text-danger': true,
                       'font-weight-bolder': true,
                  },
           errorText: 'Sorry no data found!',
        };
    },
    watch:{
        searchKey: function(value){
                     if(value === ''){
                          this.getAllCustomers();
                     }else{
                        this.getSarchCustomers();
                     }
        }
         
    },
    mounted() {
        // console.log("Component mounted.");
        this.getAllCustomers();
    },
    methods: {
        getAllCustomers(page = 1) {
            this.$Progress.start();
            axios
                .get("api/customers?page=" + page)
                .then(response => {
                    this.customers = response.data;
                    //   console.log(response)
                    this.$Progress.finish();
                })
                .catch(e => {
                    console.log(e);
                    this.$Progress.fail();
                });
        },
        getSarchCustomers(page = 1) {
            this.$Progress.start();
            // 
            axios
                .get('api/search/customers' + '/' + this.queryInput + '/' + this.searchKey + '?page=' + page )
                .then(response => {
                    this.customers = response.data;
                    //   console.log(response)
                    this.$Progress.finish();
                })
                .catch(e => {
                    console.log(e);
                    this.$Progress.fail();
                });
        },
        reLoad(){
            this.$Progress.start()
             this.getAllCustomers()
             this.searchKey = ''
             this.queryInput = 'name'
        },
    }
};
</script>
