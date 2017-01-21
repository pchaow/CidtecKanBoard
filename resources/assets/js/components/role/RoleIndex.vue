<template>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    Search Role
                </div>
                <div class="panel-body">
                    <div class="col-lg-12">
                        <form class="form-horizontal" v-on:submit.prevent="search">
                            <div class="form-group">
                                <label>Keyword : </label>
                                <input class="form-control" v-model="form.keyword" @keypress placeholder="keyword"/>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <button type="button" @click="reset" class="btn btn-default">Clear</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="btn-group btn-group-sm pull-right">
                        <a href="/superadministrator/role/create" class="btn btn-default">Create Role</a>
                    </div>
                    Role Table
                </div>

                <div class="panel-body">

                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Display Name</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="role in roles">
                                    <td>{{role.name}}</td>
                                    <td>{{role.display_name}}</td>
                                    <td>{{role.description}}</td>
                                    <td>
                                        <a v-bind:href="'/superadministrator/role/'+role.id+'/edit'"
                                           class="btn btn-primary">Edit</a>
                                        <button type="button" class="btn btn-danger" v-on:click="deleteRole(role)">
                                            Delete
                                        </button>
                                    </td>

                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="4">
                                        <div>
                                            จำนวนทั้งหมด {{rolesPage.total}} รายการ
                                        </div>
                                        <ul class="pagination">
                                            <li v-bind:class="{ 'active' : (rolesPage.current_page == n) }"

                                                v-for="n in rolesPage.last_page ">
                                                <a style="cursor: default;" v-on:click="gotoPage(n)">{{ n }}</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
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
                roles: [],
                rolesPage: {},
                form: {
                    keyword: "",
                    page: 1,
                }
            }
        },
        methods: {
            reset: function () {
                this.form = {
                    keyword: "",
                    page: 1,
                }
            },
            search: function () {
                this.form.page = 1
                this.load();
            },
            gotoPage: function (n) {
                this.form.page = n;
                this.load()
            },
            load: function () {
                this.$http.get('/api/v1/admin/role', {
                    params: this.form
                }).then(function (r) {
//                    console.log(r.data)
                    this.rolesPage = r.data
                    this.roles = this.rolesPage.data

                })
            },
            deleteRole: function (role) {
                if (confirm("Do you want to delete this role?")) {
                    this.$http.delete('/api/v1/admin/role/' + role.id, {
                        params: this.form
                    }).then(function (r) {
                        this.load()
                    })
                }

            }
        },
        mounted() {
            console.log('Component mounted.')
            this.load();
        }
    }

</script>
