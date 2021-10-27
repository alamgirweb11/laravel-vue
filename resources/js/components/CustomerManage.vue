<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">List of customers</div>

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
            customers: [],
            imagePath: ""
        };
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
        }
    }
};
</script>
