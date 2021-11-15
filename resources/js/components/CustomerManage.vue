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
                                <button
                                    class="btn btn-primary"
                                    @click="addCustomerModal()"
                                >
                                    Add Customer
                                </button>
                                <button
                                    class="btn btn-success"
                                    @click="reLoad()"
                                >
                                    Reload Page
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-2 offset-md-1">
                            <label for="">
                                <strong class="text-center"
                                    >Search By:-</strong
                                ></label
                            >
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
                            <input
                                type="text"
                                v-model="searchKey"
                                placeholder="Searach"
                                class="form-control"
                            />
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
                                            @click="editModal(customer)"
                                            >Edit</a
                                        >
                                        <a
                                            href="#"
                                            class="btn btn-sm btn-danger"
                                            title="Delete"
                                            @click="deleteRecord(customer)"
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
        <vue-snotify></vue-snotify>

        <!-- Button trigger modal -->
        <!-- Modal -->
        <div
            class="modal fade"
            id="customerModal"
            aria-labelledby="customerModallLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5
                            class="modal-title"
                            id="customerModallLabel"
                            v-show="!editMode"
                        >
                            Add New Customer
                        </h5>
                        <h5
                            class="modal-title"
                            id="customerModallLabel"
                            v-show="editMode"
                        >
                            Edit Customer Info
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form
                            @submit.prevent="editMode ? update() : store()"
                     
                            enctype="multipart/form-data"
                        >
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="form.name"
                                    name="name"
                                    id="name"
                                    placeholder="Enter Your Name"
                                />
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="form.email"
                                    name="email"
                                    id="email"
                                    placeholder="Enter Your email"
                                />
                            </div>
                            <div class="form-group">
                                <label for="mobile">Mobile</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    v-model="form.mobile"
                                    name="mobile"
                                    id="mobile"
                                    placeholder="Enter Your mobile"
                                />
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea
                                    class="form-control"
                                    v-model="form.address"
                                    name="address"
                                    id="address"
                                    rows="3"
                                ></textarea>
                            </div>
                            <div class="form-group">
                                <label for="total">Total</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    v-model="form.total"
                                    name="total"
                                    id="total"
                                    placeholder="Enter Your Amount"
                                />
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select
                                    class="form-control"
                                    v-model="form.status"
                                    name="status"
                                >
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input
                                    type="file"
                                    @change="imagePreviewMethod"
                                    class="form-control-file"
                                    name="image"
                                    id="image"
                                    placeholder="image"
                                />
                                <img
                                    style="width:150px; margin-top: 8px;"
                                    :src="imagePreview == null ? form.image : imagePreview "
                                    alt=""
                                />
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-dismiss="modal"
                                >
                                    Close
                                </button>
                                <button
                                    v-show="editMode"
                                    type="submit"
                                    class="btn btn-success"
                                >
                                    Update
                                </button>
                                <button
                                    v-show="!editMode"
                                    type="submit"
                                    class="btn btn-primary"
                                >
                                    Create
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            imagePreview: null,
            customerPicture: "",
            imageStyleClass: {
                "image-preview": true
            },
            editMode: false,
            queryInput: "name",
            searchKey: "",
            customers: [],
            imagePath: "",
            errorMsgStyle: {
                "text-center": true,
                "text-danger": true,
                "font-weight-bolder": true
            },
            errorText: "Sorry no data found!",
            //    form data set
            form: new Form({
                id: "",
                name: "",
                email: "",
                mobile: "",
                address: "",
                total: "",
                status: 1,
                image: ""
            })
        };
    },
    watch: {
        // condition wise data rendering
        searchKey: function(value) {
            if (value === "") {
                this.getAllCustomers();
            } else {
                this.getSarchCustomers();
            }
        }
    },
    mounted() {
        // console.log("Component mounted.");
        this.getAllCustomers();
    },
    methods: {
        // get all customer data
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
        // get search result
        getSarchCustomers(page = 1) {
            this.$Progress.start();
            //
            axios
                .get(
                    "api/search/customers" +
                        "/" +
                        this.queryInput +
                        "/" +
                        this.searchKey +
                        "?page=" +
                        page
                )
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
        // page reload method
        reLoad() {
            this.$Progress.start();
            this.getAllCustomers();
            this.searchKey = "";
            this.queryInput = "name";
            this.$snotify.success("Data reload successfully.");
        },
        // add new customer modal method
        addCustomerModal() {
            this.editMode = false;
            this.imagePreview = null;
            this.form.reset();
            $("#customerModal").modal("show");
        },

        // image preview script
        imagePreviewMethod(event) {
            this.form.image = event.target.files[0];
            let reader = new FileReader();
            reader.addEventListener(
                "load",
                function() {
                    this.imagePreview = reader.result;
                }.bind(this),
                false
            );
            if (this.form.image) {
                if (/\.(jpe?g|png|gif)$/i.test(this.form.image.name)) {
                    reader.readAsDataURL(this.form.image);
                }
            }
        },

        // edit customer info
        editModal(customer) {
            this.editMode = true;
            this.form.reset();
             this.imagePreview = null;
            $("#customerModal").modal("show");
            this.form.fill(customer);
             this.imagePreview = this.customer.image;
        },

        // insert customer record
        store() {
            this.$Progress.start();
            this.form.busy = true;
            this.form
                .post("/api/customers")
                .then(response => {
                    this.getAllCustomers();
                    $("#customerModal").modal("hide");
                    if (this.form.successful) {
                        this.$Progress.finish();
                        this.$snotify.success(
                            "Customer info successfully submitted."
                        );
                    } else {
                        this.$Progress.fail();
                        this.$snotify.error(
                            "Something went wrong, please try again.",
                            "error"
                        );
                    }
                    console.log(response);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        // update customer record
        update() {
            this.$Progress.start();
            this.form.busy = true;
            this.form
                .put("/api/customers/" + this.form.id)
                .then(response => {
                    this.getAllCustomers();
                    $("#customerModal").modal("hide");
                    if (this.form.successful) {
                        this.$Progress.finish();
                        this.$snotify.success(
                            "Customer info successfully updated."
                        );
                    } else {
                        this.$Progress.fail();
                        this.$snotify.error(
                            "Something went wrong, please try again.",
                            "error"
                        );
                    }
                    console.log(response);
                })
                .catch(error => {
                    console.log(error);
                });
        },

        // delete customer record
        deleteRecord(customer) {
             this.$snotify.clear();
            this.$snotify.confirm("You cannot recover this data again.", "Are You Sure?", {
                timeout: false,
                showProgressBar: false,
                closeOnClick: false,
                pauseOnHover: true,
                buttons: [
                    {
                        text: "Yes",
                        action: toast => {
                            this.$snotify.remove(toast.id);
                            this.$Progress.start();
                            // this.form.busy = true;
                            this.form
                                .delete("/api/customers/" + customer.id)
                                .then(response => {
                                    this.getAllCustomers();
                                    if (this.form.successful) {
                                        this.$Progress.finish();
                                        this.$snotify.success(
                                            "Customer info successfully deleted."
                                        );
                                    }
                                    console.log(response);
                                })
                                .catch(error => {
                                    this.$Progress.fail();
                                    this.$snotify.error(
                                        response.error,
                                        "error"
                                    );
                                });
                        },
                        bold: true,
                    },
                    { text: "No",
                     action: toast => {
                             this.$snotify.success(
                                            "Safe Data."
                                        );
                            this.$snotify.remove(toast.id);
                     }
                     },
                    {
                        text: "Later",
                        action: toast => {
                            console.log("Clicked: Later");
                            this.$snotify.remove(toast.id);
                        }
                    },
                    {
                        text: "Close",
                        action: toast => {
                            console.log("Clicked: No");
                            this.$snotify.remove(toast.id);
                        },
                        bold: true
                    }
                ]
            });
        }
    }
};
</script>
<style>
.image-preview {
    height: 150px;
    width: 150px;
    margin-top: 8px;
    border: 1px solid #111;
}
</style>
