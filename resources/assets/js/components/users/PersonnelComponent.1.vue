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
            <b-alert v-else
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
                    <h4 class="card-title"> Personnel</h4>
                </div>
                <div class="text-right">
                    <button class="btn btn-success" @click="create()">
                        + <i class="fa fa-user"></i>
                    </button>
                </div>

                <div v-if="validations">
                    <div v-for="value in validations">
                        <b-alert variant="danger" show dismissible fade>
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
                                <th>Matricule</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Date d'embauche</th>
                                <th>Statut</th>
                                <th>Dernier connexion</th>
                                <th>Date de création</th>
                                <th class="text-right"><p>Action</p></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="personnel in items.data">
                                <td>{{ personnel.id }}</td>
                                <td>{{ personnel.matricule }}</td>
                                <td>{{ personnel.nom }}</td>
                                <td>{{ personnel.prenom }}</td>
                                <td>{{ personnel.compte.email }}</td>
                                <td>{{ personnel.compte.user_role.nom }}</td>
                                <td>{{ personnel.date_embauche }}</td>

                                <td>
                                    <button v-if="personnel.compte.is_active == null " class="btn btn-success"
                                            @click="goToActive(personnel)"> Activer
                                    </button>
                                    <button v-else class="btn btn-danger" @click="goToActive(personnel)">
                                        Désactiver
                                    </button>
                                </td>
                                <td>{{ personnel.compte.last_login}}</td>
                                <td>{{ personnel.compte.created_at}}</td>
                                <td class="text-right">
                                    <button type="button" rel="tooltip" class="btn btn-default btn-icon btn-sm "
                                            title="detail" @click="role(personnel)">
                                        <i class="fa fa-suitcase"></i>
                                    </button>
                                    <button type="button" rel="tooltip" class="btn btn-info btn-icon btn-sm "
                                            title="detail" @click="show(personnel)">
                                        <i class="fa fa-user"></i>
                                    </button>
                                    <button type="button" rel="tooltip" class="btn btn-success btn-icon btn-sm "
                                            title="mise à jours" @click="edit(personnel)">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" rel="tooltip" class="btn btn-danger btn-icon btn-sm "
                                            title="suppression" @click="deleteModal(personnel.compte.slug)">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    <button type="button" rel="tooltip" class="btn btn-warning btn-icon btn-sm "
                                            title="modification mot de pass" @click="lockModal(personnel)">
                                        <i class="fa fa-lock"></i>
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
                                    <button type="button" class="page-link btn-danger">Total : <span
                                            v-if="items.total > items.per_page">{{ items.per_page
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


        <b-modal ref="lock" hide-footer title="Mise à jours mot de pass ">
            <div class="d-block">
                <label class="text-dark font-weight-medium" for="">Mot de pass</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="mdi mdi-lock"></i>
                        </span>
                    </div>
                    <input type="password" class="form-control" v-model="password">
                </div>
                <label class="text-dark font-weight-medium" for="">Confirmation</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="mdi mdi-lock"></i>
                        </span>
                    </div>
                    <input type="password" class="form-control" v-model="password_confirmation">
                </div>
            </div>

            <hr>
            <b-button variant="success" @click="resetPassword(item)">Confirmer</b-button>
        </b-modal>

        <b-modal ref="profile" hide-footer title="Mise à jours profile ">
            <div class="d-block">

            </div>
            <hr>
            <b-button variant="success" @click="profileUpdate(item)">Confirmer</b-button>
        </b-modal>

        <b-modal ref="create" hide-footer title="Création Compte">

            <form v-on:submit.prevent="storeModal()">


                <label class="text-dark mt-4 font-weight-medium" for="">Nom</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-account-details"></i>
													</span>
                    </div>
                    <input type="text" class="form-control" v-model="personnel.nom">
                </div>


                <label class="text-dark mt-4 font-weight-medium" for="">Prenom</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-account-details"></i>
													</span>
                    </div>
                    <input type="text" class="form-control" v-model="personnel.prenom">
                </div>
                <p style="font-size: 90%">ex. Snow</p>


                <label class="text-dark mt-4 font-weight-medium" for="">Matricule</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-account-details"></i>
													</span>
                    </div>
                    <input type="text" class="form-control" v-model="personnel.matricule">
                </div>
                <p style="font-size: 90%">ex. ITC094-R2</p>


                <label class="text-dark font-weight-medium" for="">Date d'embauche</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-calendar-range"></i>
													</span>
                    </div>
                    <input type="date" class="form-control" v-model="personnel.date_embauche">
                </div>
                <p style="font-size: 90%">ex. 08/08/2008</p>


                <label class="text-dark mt-4 font-weight-medium" for="">Sexe</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-gender-male-female"></i>
													</span>
                    </div>
                    <select v-model="personnel.sexe" class="form-control">
                        <option value="">Selectioner le sexe</option>
                        <option value="M">Masculin</option>
                        <option value="F">Féminin</option>
                    </select>

                </div>
                <p style="font-size: 90%">ex. Femme</p>


                <label class="text-dark mt-4 font-weight-medium" for="">Email</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-email"></i>
													</span>
                    </div>
                    <input type="email" class="form-control" v-model="personnel.email">
                </div>
                <p style="font-size: 90%">ex. info@techomegapartners.com</p>


                <label class="text-dark mt-4 font-weight-medium" for="">Langue</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-translate"></i>
													</span>
                    </div>
                    <select v-model="personnel.langue" class="form-control">
                        <option value="">Selectioner une langue</option>
                        <option value="fr">Fr</option>
                        <option value="en">En</option>

                    </select>
                </div>
                <p style="font-size: 90%">ex. Fr</p>


                <label class="text-dark mt-4 font-weight-medium" for="">Téléphone</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-phone"></i>
													</span>
                    </div>
                    <input type="text" class="form-control" v-model="personnel.telephone">
                </div>
                <p style="font-size: 90%">ex. +24100000000</p>


                <label class="text-dark font-weight-medium" for="">Date de Naissance</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-calendar-range"></i>
													</span>
                    </div>
                    <input type="date" class="form-control" v-model="personnel.date_naissance">
                </div>
                <p style="font-size: 90%">ex. 08/08/2008</p>

                <label class="text-dark font-weight-medium" for="">Role</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-calendar-range"></i>
													</span>
                    </div>
                    <select class="form-control" v-model="personnel.role">
                        <option disabled>Selectioner un role</option>
                        <option value=""></option>
                        <option v-for="r in roles_" v-bind:value="r.id">{{ r.name }}</option>
                    </select>
                </div>
                <p style="font-size: 90%">ex. Role</p>


                <hr>
                <div class="row">
                    <button class="btn btn-primary" type="submit">Valider</button>
                    <button class="btn btn-default" type="reset">Recommencer</button>
                </div>
            </form>

        </b-modal>


        <b-modal ref="activation" hide-footer title="Activation Compte">
            <div class="d-block text-center">
                <p id="green">Activer le compte de : {{ item.nom }} {{ item.prenom }} ?</p>
            </div>
            <hr>
            <b-button variant="success" @click="activation(item)">Confirmer</b-button>
        </b-modal>

        <b-modal ref="desactivation" hide-footer title="Dectivation Compte">
            <div class="d-block text-center">
                <p id="redone">Desactiver le compte de : {{ item.nom }} {{ item.prenom }} ?</p>
            </div>
            <hr>
            <b-button variant="success" @click="desactivation(item)">Confirmer</b-button>
        </b-modal>


        <b-modal ref="delete" hide-footer title="Suppression Compte">
            <div class="d-block text-center">
                <p id="red">Supprimer le compte de : {{ item.nom }} {{ item.prenom }} ?</p>
            </div>

            <hr>
            <b-button variant="success" @click="destroy(item)">Confirmer</b-button>
        </b-modal>


        <b-modal ref="edit" hide-footer title="Mise à jours Compte">

            <div class="card card-default">

                <div class="card-body">

                    <form action="api/personnel-create" method="post">

                        <label class="text-dark mt-4 font-weight-medium" for="">Matricule</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-account-details"></i>
													</span>
                            </div>
                            <input type="text" class="form-control" v-model="personnel.matricule">
                        </div>
                        <p style="font-size: 90%">ex. GV-789</p>


                        <label class="text-dark mt-4 font-weight-medium" for="">Nom</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-account-details"></i>
													</span>
                            </div>
                            <input type="text" class="form-control" v-model="personnel.nom">
                        </div>
                        <p style="font-size: 90%">ex. John</p>

                        <label class="text-dark mt-4 font-weight-medium" for="">Prenom</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-account-details"></i>
													</span>
                            </div>
                            <input type="text" class="form-control" v-model="personnel.prenom">
                        </div>
                        <p style="font-size: 90%">ex. Snow</p>


                        <label class="text-dark mt-4 font-weight-medium" for="">Email</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-email"></i>
													</span>
                            </div>
                            <input type="email" class="form-control">
                        </div>
                        <p style="font-size: 90%">ex. info@techomegapartners.com</p>


                        <label class="text-dark mt-4 font-weight-medium" for="">Langue</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-translate"></i>
													</span>
                            </div>
                            <select class="form-control">
                                <option value=""></option>
                                <option value="">fr</option>
                                <option value="">en</option>
                            </select>
                        </div>
                        <p style="font-size: 90%">ex. Fr</p>

                        <label class="text-dark mt-4 font-weight-medium" for="">Téléphone</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-phone"></i>
													</span>
                            </div>
                            <input type="text" class="form-control">
                        </div>
                        <p style="font-size: 90%">ex. +24100000000</p>


                        <label class="text-dark font-weight-medium" for="">Date d'embauche'</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-calendar-range"></i>
													</span>
                            </div>
                            <input type="date" class="form-control" v-model="personnel.date_embauche">
                        </div>
                        <p style="font-size: 90%">actuel . {{ personnel.date_embauche }}</p>


                        <label class="text-dark font-weight-medium" for="">Date de Naissance</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-calendar-range"></i>
													</span>
                            </div>
                            <input type="date" class="form-control" v-model="personnel.date_naissance">
                        </div>
                        <p style="font-size: 90%">ex. 08/08/2008</p>

                        <label class="text-dark font-weight-medium" for="">Role</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-calendar-range"></i>
													</span>
                            </div>
                            <select class="form-control" v-model="personnel.role">
                                <option disabled>Selectioner un role</option>
                                <option value=""></option>
                                <option v-for="r in roles_" v-bind:value="r.id">{{ r.name }}</option>
                            </select>
                        </div>
                        <p style="font-size: 90%" id="redone" v-if="validations" v-for="value in validations.role ">{{
                            value }} </p>
                        <p v-else></p>
                        <p style="font-size: 90%">ex. Role</p>


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
                            <h1 class="name">{{ item.nom }} {{ item.prenom }}</h1>
                            <h3 class="title"><i class="mdi mdi-wallet-travel"></i> ROLE : {{ role_ }}</h3>
                            <h6 class="title"><i class="mdi mdi-email"></i> EMAIL : {{ email_}} </h6>
                            <h6 class="title"><i class="mdi mdi-baby-buggy"></i> DATE DE NAISSANCE : {{ birth_ }}</h6>
                            <h6 class="title"><i class="mdi mdi-translate"> LANGUE : {{ lang_ }}</i></h6>
                            <h6 class="title"><i class="mdi mdi-phone"> TEL : {{ phone_ }}</i></h6>
                            <h6 class="title"><i class="mdi mdi-gender-male-female"> SEXE : {{ item.sexe }}</i></h6>
                            <h6 class="title"><i class="mdi mdi-account-badge"> DATE EMBAUCHE : {{ item.date_embauche
                                }}</i></h6>
                            <h6 class="title"><i class="mdi mdi-counter"> MATRICULE : {{ item.matricule }}</i></h6>
                            <h6 class="title"><i class="mdi mdi-web"> DERNIERE CONNEXION : {{ login_ }}</i></h6>
                            <h6 class="title"><i class="mdi mdi-alert"></i> ETAT DU COMPTE : <p class="text-danger"
                                                                                                v-if="status_ === 0 ">
                                Compte non actif</p>
                                <p class="text-success" v-else>Compte actif</p>
                            </h6>
                            <h6 class="title"><i class="mdi mdi-calendar"> DATE DE CREATION : {{ created_ }}</i></h6>

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
                is_completed: [],
                roles_: {
                    id: '',
                    name: '',
                },
                message: '',
                message_: '',
                dismissSecs: 7,
                dismissCountDown: 0,
                role_: '',
                status_: '',
                email_: '',
                birth_: '',
                password_confirmation: '',
                password: '',
                phone_: '',
                lang_: '',
                login_: '',
                created_: '',
                validations: [],
                current_page_: '',
                date_embauche: '',
                personnel: {
                    nom: '',
                    prenom: '',
                    matricule: '',
                    date_embauche: '',
                    matricule: '',
                    email: '',
                    role: '',
                    telephone: '',
                    langue: '',
                    sexe: '',
                    date_naissance: '',

                },
                compte: {
                    email: '',
                    role: '',
                    slug: '',
                    telephone: '',
                    langue: '',
                    role: '',
                    password: '',
                    password_confirmation: '',
                },
                password_: '',
                password_confirmation_: '',
            }
        },
        mounted() {
            this.list('/api/personnel?page=0');
        },
        methods: {
            list(url) {
                let app = this;
                axios.get(url)
                    .then(function (response) {
                        app.items = response.data.content.personnels;
                        app.roles_ = response.data.content.roles;
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
            goToActive(c) {
                this.item = c;
                this.is_completed = c.compte.is_active;
                if (this.is_completed) {
                    this.$refs['desactivation'].show()
                } else {
                    this.$refs['activation'].show()
                }
            },
            deleteModal(c) {
                this.item = c
                this.$refs['delete'].show()
            },

            show(c) {

                this.item = c;
                let item_role = c.compte.user_role.nom;
                let item_status = c.compte.is_active;
                this.birth_ = c.date_naissance;
                if (item_status == null) {
                    this.status_ = 0;
                } else {
                    this.status_ = 1;
                }
                let item_email = c.compte.email;
                this.role_ = item_role;
                this.email_ = item_email;
                this.lang_ = c.compte.langue;
                this.phone_ = c.compte.telephone;
                this.login_ = c.compte.last_login;
                this.created_ = c.compte.created_at;
                this.$refs['show'].show()
            },
            edit(c) {

                this.personnel = c;
                this.$refs['edit'].show();
            },

            activation(c) {
                let ar = this;
                axios.get('api/personnel/activate/' + c.compte.slug)
                    .then(function (response) {
                        ar.message = response.data;
                        ar.success(ar.message.message);
                    });
                this.$refs['activation'].hide();
                this.list('/api/personnel?page=' + this.current_page_);
            },

            desactivation(c) {
                let ar = this;
                axios.get('api/personnel/desactivate/' + c.compte.slug)
                    .then(function (response) {
                        ar.message = response.data;
                        ar.success(ar.message.message);
                    });
                this.$refs['desactivation'].hide();
                this.showAlert();
                this.list('/api/personnel?page=' + this.current_page_);

            },

            destroy(slug) {
                let app = this;
                axios.delete('/api/delete-personnel/' + slug)
                    .then(function (response) {
                        app.message_ = response.data;
                    }).catch(function (response) {
                });

                this.$refs['delete'].hide();
                this.success(app.message_.message);
                this.list('/api/personnel?page=' + this.current_page_);
            },
            storeModal() {
                var app = this;
                var newPersonnel = app.personnel;
                axios.post('/api/create/personnel', newPersonnel)
                    .then(function (response) {
                        app.message_ = response.data.message;
                        app.status = response.data.status;
                        app.validations = response.data.error;
                        console.log(app.status);
                    }).catch(function (response) {
                });
                this.$refs['create'].hide();
                this.showAlert();
                this.list('/api/personnel?page=' + this.current_page_);
            },
            update(item) {
                var app = this;
                var newPersonnel = item;
                console.log(newPersonnel);

                axios.post('/api/create/personnel', newPersonnel)
                    .then(function (response) {
                        app.items = response.data;
                        app.message_ = response.data.message;
                        app.validations = response.data.error;
                        if (this.isEmpty(app.validations.error)) {
                            this.success(app.message.message);
                        }
                    })
                    .catch(function (response) {
                    });
                this.$refs['create'].hide();
                this.list('/api/personnel?page=' + this.current_page_);


            },
            role(c) {
                this.item = c
                this.$refs['profile'].show()
            },
            lockModal(c) {
                this.item = c
                this.$refs['lock'].show()
            },
            resetPassword(item) {
                var app = this;
                var newUser = app.compte;

                newUser.email = item.compte.email;
                newUser.role = item.compte.id;
                newUser.slug = item.compte.slug;
                newUser.telephone = item.compte.telephone;
                newUser.langue = item.compte.langue;
                newUser.role = item.compte.user_role.id;
                newUser.password = app.password_;
                newUser.password_confirmation = app.password_confirmation_;

                axios.post('/api/reset-password', newUser)
                    .then(function (response) {
                        app.message_ = response.data;
                        console.log(app.message_)
                    })
                    .catch(function (response) {
                        console.log(response);
                    });
                this.$refs['lock'].hide();
                this.list('/api/personnel?page=' + this.current_page_);

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