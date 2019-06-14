<template>


    <div>

        <FlashMessage></FlashMessage>

        <div class="col-md-12">
            <b-alert v-if="status === 0"
                     :show="dismissCountDown"
                     dismissible
                     variant="danger"
                     @dismissed="dismissCountDown=0"
                     @dismiss-count-down="countDownChanged"
            >
                {{ message_ }}
            </b-alert>
            <b-alert    v-else
                        :show="dismissCountDown"
                        dismissible
                        variant="success"
                        @dismissed="dismissCountDown=0"
                        @dismiss-count-down="countDownChanged"
            >
                {{ message_ }}
            </b-alert>





        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Pays </h4>
                </div>
                <div class="text-right">
                    <button class="btn btn-success" @click="create()">
                        + <i class="fa fa-user"></i>
                    </button>
                </div>

                <div v-if="validations">
                    <div   v-for="value in validations">
                        <b-alert  variant="danger" show dismissible fade >
                            {{ value }}
                        </b-alert>
                    </div>
                </div>


                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class=" text-primary">
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Capitale</th>
                                <th>Date de création</th>
                                <th class="text-right"><p>Action</p></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="pays in items.data">
                                <td>{{ pays.id }}</td>
                                <td>{{ pays.nom }}</td>
                                <td>{{ pays.capitale }}</td>
                                <td>{{ pays.created_at}}</td>
                                <td class="text-right">
                                    <button type="button" rel="tooltip" class="btn btn-info btn-icon btn-sm "
                                            title="detail" @click="show(pays)">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <button type="button" rel="tooltip" class="btn btn-success btn-icon btn-sm "
                                            title="mise à jours" @click="edit(pays)">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" rel="tooltip" class="btn btn-danger btn-icon btn-sm "
                                            title="suppression" @click="deleteModal(pays)">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <nav aria-label="Page navigation example">
                            <ul class="pagination pagination-seperated pagination-seperated-rounded">

                                <li class="page-item" v-if="items.prev_page_url != null">
                                    <button @click="list(items.prev_page_url)" class="page-link">
                                        <span aria-hidden="true" class="fa fa-chevron-left"></span>
                                    </button>
                                </li>
                                <li class="page-item"
                                    v-if="items.prev_page_url != null || items.prev_page_url > 0 ">
                                    <button @click="list(items.prev_page_url)" class="page-link">{{
                                        items.current_page -1 }}
                                    </button>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link">{{ items.current_page }}</a>
                                </li>
                                <li class="page-item" v-if="items.next_page_url != null">
                                    <button @click="list(items.next_page_url)" class="page-link">{{
                                        items.current_page +1 }}
                                    </button>
                                </li>


                                <li class="page-item" v-if="items.next_page_url != null">
                                    <button class="page-link" @click="list(items.next_page_url)">
                                        <span aria-hidden="true" class="fa fa-chevron-right ml-1"></span>
                                    </button>
                                </li>

                                <li class="page-item pull-right">
                                    <button type="button" class="page-link btn-danger">Total : <span v-if="items.total > items.per_page">{{ items.per_page
                                        }} / {{ items.total }}</span>
                                        <span v-else>
                                            {{ items.total }}
                                        </span>
                                    </button>
                                </li>
                            </ul>
                        </nav>

                    </div>
                </div>
            </div>
        </div>



        <b-modal ref="create" hide-footer title="Création Compte">
            <form v-on:submit.prevent="storeModal()">
                <label class="text-dark mt-4 font-weight-medium" for="">Nom</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-account-details"></i>
													</span>
                    </div>
                    <input type="text" class="form-control" v-model="pays.nom">
                </div>
                <p style="font-size: 90%">ex. USA</p>


                <label class="text-dark mt-4 font-weight-medium" for="">Capitale</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-account-details"></i>
													</span>
                    </div>
                    <input type="text" class="form-control" v-model="pays.capitale">
                </div>
                <p style="font-size: 90%">ex. Washington DC</p>

                <hr>
                <div class="row">
                    <button class="btn btn-primary" type="submit">Valider</button>
                    <button class="btn btn-default" type="reset">Recommencer</button>
                </div>
            </form>

        </b-modal>




        <b-modal ref="delete" hide-footer title="Suppression Compte">
            <div class="d-block text-center">
                <p id="red">Supprimer le compte de : {{ item.nom }} ?</p>
            </div>

            <hr>
            <b-button variant="success" @click="destroy(item)">Confirmer</b-button>
        </b-modal>


        <b-modal ref="edit" hide-footer title="Mise à jours Compte">

            <div class="card card-default">

                <div class="card-body">

                    <form action="api/pays-create" method="post">



                        <label class="text-dark mt-4 font-weight-medium" for="">Nom</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-account-details"></i>
													</span>
                            </div>
                            <input type="text" class="form-control" v-model="pays.nom">
                        </div>

                        <label class="text-dark mt-4 font-weight-medium" for="">Capitale</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-account-details"></i>
													</span>
                            </div>
                            <input type="text" class="form-control" v-model="pays.capitale">
                        </div>

                        <hr>
                        <div class="row">
                            <button class="btn btn-primary" type="submit">Valider</button>
                            <button class="btn btn-default" type="reset">Recommencer</button>
                        </div>
                    </form>

                </div>
            </div>


        </b-modal>


        <b-modal ref="show" hide-footer title="Detail" v-b-modal.modal-center>
            <div class="d-block text-center">
                <section class="card-o">
                    <div class="panel-o meta">
                        <picture>
                            <img class="avatar"
                                 src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/67516/Screen_Shot_2015-11-18_at_11.47.23_AM.png"
                                 width="128" height="128" alt=""/>
                            <img class="company-logo" src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/67516/b-01.png"
                                 alt="BigglesCodes" width="40" height="40"/>
                        </picture>
                        <div>
                            <h1 class="name">{{ item.nom }}</h1>
                            <h3 class="title"><i class="mdi mdi-wallet-travel"></i> Capitale : {{ item.capitale }}</h3>
                            <h6 class="title"><i class="mdi mdi-calendar"> DATE DE CREATION : {{ item.created_at }}</i></h6>

                        </div>
                    </div>

                </section>

            </div>
        </b-modal>

    </div>

</template>

<script>
    import VueAxios from 'vue-axios';
    import axios from 'axios';
    import BootstrapVue from 'bootstrap-vue';
    import Swal from 'sweetalert2';
    import FlashMessage from '@smartweb/vue-flash-message';


    Vue.use(FlashMessage);
    Vue.use(BootstrapVue);

    Vue.use(VueAxios, axios);
    export default {
        data() {
            return {
                items: [],
                item: '',
                status: '',
                message_: '',
                dismissSecs: 7,
                dismissCountDown: 0,
                created_: '',
                validations: [],
                current_page_: '',
                pays: {
                    nom: '',
                    capitale: '',
                    email: '',
                },
            }
        },
        mounted() {
            this.list('/api/pays?page=0');
        },
        methods: {
            list(url) {
                let app = this;
                axios.get(url)
                    .then(function (response) {
                        app.items = response.data.content.pays;
                        app.current_page_ = app.items.current_page;
                    }).catch(function (response) {
                });
            },
            countDownChanged(dismissCountDown) {
                this.dismissCountDown = dismissCountDown
            },
            showAlert() {
                this.dismissCountDown = this.dismissSecs
            },
            success(message) {
                Swal.fire(
                    'Succès!',
                    message,
                    'success'
                )
            },
            error(message) {
                Swal.fire(
                    'Erreur !',
                    message,
                    'error'
                )
            },
            create() {
                this.$refs['create'].show();
            },
            deleteModal(c) {
                this.item = c
                this.$refs['delete'].show()
            },

            show(c) {

                this.item = c;
                this.$refs['show'].show()
            },
            edit(c) {
                this.pays = c;
                this.$refs['edit'].show();
            },
            destroy(item) {
                let app = this;
                axios.delete('/api/pays/' + item.slug)
                    .then(function (response) {
                        app.message_ = response.data;
                    }).catch(function (response) {
                });

                this.$refs['delete'].hide();
                this.success(app.message_.message);
                this.list('/api/pays?page=' + this.current_page_);
            },
            storeModal() {
                var app = this;
                var newPersonnel = app.pays;
                axios.post('/api/pays', newPersonnel)
                    .then(function (response) {
                        app.message_ = response.data.message;
                        app.status = response.data.status;
                        app.validations = response.data.error;
                        console.log(app.status);
                    }).catch(function (response) {
                });
                this.$refs['create'].hide();
                this.showAlert();
                this.list('/api/pays?page=' + this.current_page_);
            },
            update(item) {
                var app = this;
                var newPersonnel = item;
                var slug = newPersonnel.slug;

                axios.put('/api/pays/'+slug, newPersonnel)
                    .then(function (response) {
                        app.items = response.data;
                        app.message_ = response.data.message;
                        app.validations = response.data.error;
                        if(this.isEmpty(app.validations.error)){
                            this.success(app.message.message);
                        }
                    })
                    .catch(function (response) {
                    });
                this.$refs['create'].hide();
                this.list('/api/pays?page=' + this.current_page_);


            }

        }
    }
</script>
<style>

    #redone {
        color: red;
    }

    #green {
        color: green;
    }

    #transparent {
        color: transparent;
    }

    .bg-sensei {
        background-color: #4c84ff;
    }

    .bg-sensei tr th {
        color: #ffffff;
        text-transform: capitalize;
    }
</style>
<style lang="scss">
    .panel-o {
        padding: 1.5rem 2rem;
        /* position: absolute; */
        background-color: #fff;
        width: 100%;
        height: 100%;
        border: none;
        overflow: hidden;
    }

    .meta {
        top: 0;
        left: 0;
        z-index: 1;
        margin: 0;
        position: relative;
        text-align: center;
        padding: 2rem 4rem;
        border-right: 1px solid transparent;

        picture {
            position: relative;
            display: inline-block;
        }

        img {
            object-fit: cover;
        }

        .avatar {
            border-radius: 50%;
        }

        .company-logo {
            position: absolute;
            bottom: -0.5rem;
            right: 0;
        }

        .name {
            font-size: 2rem;
            text-align: center;
            margin-top: 1rem;
            font-weight: 300;
        }

        .title {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 1rem 0 0;
        }
    }

</style>