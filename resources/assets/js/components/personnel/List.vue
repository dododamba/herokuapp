<template>
    <div class="row">
        <div class="col-md-12" v-if="items">

            <div v-if="message_">
                <div class="sufee-success alert with-close alert-success alert-dismissible fade show">
                    <span class="badge badge-pill badge-errot">Succès</span>
                    {{ message_ }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div v-else></div>
            <div class="single-table">
                <div class="table-responsive">
                    <table class="table table-striped  table-hover text-center">
                        <thead class="text-uppercase thead-dark">
                        <tr class="text-white">
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
                                        @click="_activate(personnel)"> Activer
                                </button>
                                <button v-else class="btn btn-danger" @click="_activate(personnel)">
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
                                        title="suppression" @click="_delete(personnel)">
                                    <i class="fa fa-times"></i>
                                </button>
                                <button type="button" rel="tooltip" class="btn btn-warning btn-icon btn-sm "
                                        title="modification mot de pass" @click="_password(personnel)">
                                    <i class="fa fa-lock"></i>
                                </button>
                            </td>
                        </tr>

                        </tbody>
                    </table>

                    <nav aria-label="Page navigation example">
                        <ul class="pagination pagination-seperated pagination-seperated-rounded">


                            <li class="page-item" v-if="items.prev_page_url != null">
                                <button @click="_fetch(items.prev_page_url)" class="page-link">
                                    <<
                                </button>
                            </li>

                            <li class="page-item" v-if="items.prev_page_url != null || items.prev_page_url > 0 ">
                                <button @click="_fetch(items.prev_page_url)" class="page-link">{{ items.current_page -1
                                    }}
                                </button>
                            </li>


                            <li class="page-item active">
                                <a class="page-link">{{ items.current_page }}</a>
                            </li>


                            <li class="page-item" v-if="items.next_page_url != null">
                                <button @click="_fetch(items.next_page_url)" class="page-link">{{ items.current_page +1
                                    }}
                                </button>
                            </li>


                            <li class="page-item" v-if="items.next_page_url != null">
                                <button class="page-link" @click="_fetch(items.next_page_url)">
                                    >>
                                </button>
                            </li>


                            <li class="page-item pull-right">
                                <button type="button" class="page-link btn-danger">Total : {{ items.per_page }} / {{
                                    items.total }}
                                </button>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>


            <b-modal ref="profile" hide-footer title="Mise à jours profile ">
                <div class="d-block">
                    <label class="text-dark font-weight-medium" for="">Role</label>
                    <div class="form-group">
                        <select class="form-control" v-model="roles_.name">
                            <option disabled>Selectioner un role</option>
                            <option value=""></option>
                            <option v-for="r in roles_" v-bind:value="r.name">{{ r.name }}</option>
                        </select>
                    </div>
                    <p v-if="validations" id="red">
                        {{ validations.role }}
                    </p>
                    <p style="font-size: 90%">ex. Role</p>
                </div>
                <hr>
                <b-button variant="success" @click="profileUpdate(item)">Confirmer</b-button>
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


            <b-modal ref="edit" hide-footer title="Mise à jours Compte">

                <div>

                    <div class="card-body">

                        <form v-on:submit.prevent="update(personnel)">

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
                                <input type="email" class="form-control" v-model="personnel.compte.email">
                            </div>
                            <p style="font-size: 90%">ex. info@techomegapartners.com</p>


                            <label class="text-dark mt-4 font-weight-medium" for="">Langue</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-translate"></i>
													</span>
                                </div>
                                <select class="form-control" v-model="personnel.compte.langue">
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
                                <input type="text" class="form-control" v-model="personnel.compte.telephone">
                            </div>
                            <p style="font-size: 90%">ex. +24100000000</p>


                            <label class="text-dark font-weight-medium" for="">Date d'embauche'</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-calendar-range"></i>
													</span>
                                </div>
                                <date-picker v-model="personnel.date_embauche" valueType="format"
                                             lang="en"></date-picker>

                            </div>
                            <p style="font-size: 90%">actuel . {{ personnel.date_embauche }}</p>


                            <label class="text-dark font-weight-medium" for="">Date de Naissance</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
													<span class="input-group-text">
														<i class="mdi mdi-calendar-range"></i>
													</span>
                                </div>
                                <date-picker v-model="personnel.date_naissance" valueType="format"
                                             lang="en"></date-picker>

                            </div>
                            <p style="font-size: 90%">ex. 08/08/2008</p>

                            <hr>
                            <div class="row">
                                <button class="btn btn-primary" type="submit" @click="update(item)">Valider</button>
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
                                <img class="company-logo"
                                     src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/67516/b-01.png"
                                     alt="BigglesCodes" width="40" height="40"/>
                            </picture>
                            <div>
                                <h1 class="name">{{ item.nom }} {{ item.prenom }}</h1>
                                <h3 class="title"><i class="mdi mdi-wallet-travel"></i> ROLE : {{ role_ }}</h3>
                                <h6 class="title"><i class="mdi mdi-email"></i> EMAIL : {{ email_}} </h6>
                                <h6 class="title"><i class="mdi mdi-baby-buggy"></i> DATE DE NAISSANCE : {{ birth_ }}
                                </h6>
                                <h6 class="title"><i class="mdi mdi-translate"> LANGUE : {{ lang_ }}</i></h6>
                                <h6 class="title"><i class="mdi mdi-phone"> TEL : {{ phone_ }}</i></h6>
                                <h6 class="title"><i class="mdi mdi-gender-male-female"> SEXE : {{ item.sexe }}</i></h6>
                                <h6 class="title"><i class="mdi mdi-account-badge"> DATE EMBAUCHE : {{
                                    item.date_embauche
                                    }}</i></h6>
                                <h6 class="title"><i class="mdi mdi-counter"> MATRICULE : {{ item.matricule }}</i></h6>
                                <h6 class="title"><i class="mdi mdi-web"> DERNIERE CONNEXION : {{ login_ }}</i></h6>
                                <h6 class="title"><i class="mdi mdi-alert"></i> ETAT DU COMPTE : <p class="text-danger"
                                                                                                    v-if="status_ === 0 ">
                                    Compte non actif</p>
                                    <p class="text-success" v-else>Compte actif</p>
                                </h6>
                                <h6 class="title"><i class="mdi mdi-calendar"> DATE DE CREATION : {{ created_ }}</i>
                                </h6>

                            </div>
                        </div>

                    </section>

                </div>
            </b-modal>


        </div>
        <template v-if="items == null" class="row">
            <b-alert show variant="danger">Pas de personnel enregistré pour le moment</b-alert>
        </template>
    </div>


</template>

<script>
    import VueAxios from 'vue-axios';
    import axios from 'axios';
    import BootstrapVue from 'bootstrap-vue';
    import DatePicker from 'vue2-datepicker';
    import Swal from 'sweetalert2'


    Vue.use(BootstrapVue);
    Vue.use(VueAxios, axios);

    export default {
        name: "List",
        components: {DatePicker},

        data() {
            return {
                items: [],
                item: '',
                _secret:'',
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
                name: '',
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
                    compte: {
                        email: '',
                        role: '',
                        slug: '',
                        telephone: '',
                        langue: '',
                        role: '',
                        password: '',
                        password_confirmation: '',
                    }

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
            this._fetch('/api/personnel?page=0');
            this._role();
        },
        methods: {
            _fetch(url) {
                let _self = this;
                axios.get(url,)
                    .then(function (response) {
                        _self.items = response.data.content.personnels;
                        _self.roles_ = response.data.content.roles;
                        _self.current_page_ = _self.items.current_page;

                    }).catch(function (response) {
                });
            },

            _oauth() {
                let _self = this;
                axios.get('/oauth/clients')
                    .then(response => {
                        _self._secret = response.data;
                    });
            },
            _role() {
                let _self = this;
                axios.get('api/role-personnel')
                    .then(function (response) {
                        _self.roles_ = response.data.content.roles;
                    })
                    .catch();
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
            goToActive(c) {
                this.item = c;
                this.is_completed = c.compte.is_active;
                if (this.is_completed) {
                    this.$refs['desactivation'].show()
                } else {
                    this.$refs['activation'].show()
                }
            },
            _activate(item) {
                let _self = this;
                var _item = item;
                var _slug = _item.compte.slug;
                _self.is_completed = item.compte.is_active;
                if (this.is_completed) {
                    Swal.fire({
                        title: 'Désactiver le compte de ' + _item.nom,
                        html: '<h1><i class="fa fa-warning" style="color: orangered"></i></h1>',
                        showCancelButton: true,
                        confirmButtonText: '<i class="fa fa-check"></i>Confirmer',
                        cancelButtonText: '<i class="fa fa-window-close" aria-hidden="true"></i>Annuller'
                    }).then((result) => {
                        if (result.value) {
                            axios.get('api/personnel/desactivate/' + _slug)
                                .then(function (response) {
                                });
                            this._fetch('/api/personnel?page=' + this.current_page_);
                            Swal.fire(
                                'Succès !',
                                'Le compte a été désactivé avec succès!',
                                'success'
                            )

                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire(
                                'Abandon !',
                                'La désactivation n\'a pas été éffectué !',
                                'error'
                            )
                        }
                    })
                } else {
                    Swal.fire({
                        title: 'Activer le compte de ' + _item.nom,
                        html: '<h1><i class="fa fa-warning" style="color: orangered"></i></h1>',
                        showCancelButton: true,
                        confirmButtonText: '<i class="fa fa-check"></i>Confirmer',
                        cancelButtonText: '<i class="fa fa-window-close" aria-hidden="true"></i>Annuller'
                    }).then((result) => {
                        if (result.value) {
                            axios.get('api/personnel/activate/' + _slug)
                                .then(function (response) {
                                });
                            this._fetch('/api/personnel?page=' + this.current_page_);
                            Swal.fire(
                                'Succès !',
                                'Le compte a été activé avec succès!',
                                'success'
                            )

                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire(
                                'Abandon !',
                                'L\'activation n\'a pas été éffectué !',
                                'error'
                            )
                        }
                    })
                }


            },
            _delete(item) {
                let _self = this;
                var _item = item;
                var _slug = _item.compte.slug;


                Swal.fire({
                    title: 'Confirmer la suppression du compte ' + _item.nom,
                    html: '<h1><i class="fa fa-warning" style="color: orangered"></i></h1>',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa fa-check"></i>Confirmer',
                    cancelButtonText: '<i class="fa fa-window-close" aria-hidden="true"></i>Annuller'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/delete-personnel/' + _slug)
                            .then(function (response) {
                            }).catch(function (response) {
                        });
                        this._fetch('/api/personnel?page=' + this.current_page_);
                        Swal.fire(
                            'Supprimé !',
                            'Le compte a été supprimé avec succès!',
                            'success'
                        )

                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire(
                            'Abandon !',
                            'La suppression n\'a pas été éffectué !',
                            'error'
                        )
                    }
                })
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

            role(item) {
                let _self = this;
                var _item = item;
                var _slug = _item.compte.slug;
                var _roles = _self.roles_;
                var _roleOption = {};
                var _selected = {};


                _roles.forEach(function (element) {
                    _roleOption[element.id] = element.name;
                });


                Swal.fire({
                    title: 'Modification Profile utilisateur ',
                    input: 'select',
                    inputPlaceholder: 'Selection un role',
                    inputOptions: _roleOption,
                    focusConfirm: false,

                    showCancelButton: true,
                    confirmButtonText: '<i class="fa fa-check"></i>Confirmer',
                    cancelButtonText: '<i class="fa fa-window-close" aria-hidden="true"></i>Annuller',

                }).then((result) => {
                    _selected = result.value;
                    if (result.value) {
                        axios.post('/api/update-role/' + _slug + '?id=' + _selected)
                            .then(function (response) {
                            }).catch(function (response) {
                        });
                        this._fetch('/api/personnel?page=' + this.current_page_);
                        Swal.fire(
                            'Succès !',
                            'Le role utilisateur a été mise à jours !',
                            'success'
                        )

                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire(
                            'Abandon !',
                            'Le role utilisateur n\'a pas été mise à jours !',
                            'error'
                        )
                    }
                })
            },
            _password(item) {
                let _self = this;
                var _item = item;
                var _slug = _item.compte.slug;

                Swal.fire({
                    title: 'Modification mot de pass ' + _item.nom,
                    html: '<h1><i class="fa fa-lock" style="color: orangered"></i></h1>' +
                        '<input  type="password" id="swal-input1" class="swal2-input" placeholder="Mot de Passe" >' +
                        '<input  type="password" id="swal-input2" class="swal2-input" placeholder="Confirmation">',
                    focusConfirm: false,
                    preConfirm: () => {
                        return [
                            _self.password = document.getElementById('swal-input1').value,
                            _self.password_confirmation = document.getElementById('swal-input2').value
                        ]
                    },

                    showCancelButton: true,
                    confirmButtonText: '<i class="fa fa-check"></i>Confirmer',
                    cancelButtonText: '<i class="fa fa-window-close" aria-hidden="true"></i>Annuller'
                }).then((result) => {
                    if (result.value) {
                        var _personel = _self.compte;

                        _personel.email = item.compte.email;
                        _personel.role = item.compte.id;
                        _personel.slug = item.compte.slug;
                        _personel.telephone = item.compte.telephone;
                        _personel.langue = item.compte.langue;
                        _personel.role = item.compte.user_role.id;
                        _personel.password = _self.password;
                        _personel.password_confirmation = _self.password_confirmation;


                        axios.post('/api/reset-password', _personel)
                            .then(function (response) {
                                _self.message_ = response.data.content.message;
                                _self.status = response.data.content.status;
                                _self.validations = response.data.content.error;
                                console.log(_self.message_)
                            })
                            .catch(function (response) {
                                console.log(response);
                            });
                        this._fetch('/api/personnel?page=' + this.current_page_);
                        Swal.fire(
                            'Succès !',
                            '' + _self.message,
                            'success'
                        )

                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire(
                            'Abandon !',
                            'Le mot de pass a pas été réinitialisé !',
                            'error'
                        )
                    }
                })
            },
            profileUpdate(item) {
                var _self = this;
                var _name = _self.roles_;
                var _slug = item.compte.slug;

                axios.post('/api/update-role/' + _slug + '?name=' + _name.name)
                    .then(function (response) {
                        _self.message_ = response.data.content.message;
                        _self.status = response.data.content.status;
                        _self.validations = response.data.content.error;
                    }).catch(function (response) {
                });
                this.$refs['profile'].hide();
                this._fetch('/api/personnel?page=' + this.current_page_);
            },
            update(item) {
                var _self = this;
                var _personnel = _self.personnel;
                _personnel = item;

                axios.post('/api/update-personnel', _personnel)
                    .then(function (response) {
                        _self.message_ = response.data.content.message;
                        _self.status = response.data.content.status;
                        _self.validations = response.data.content.error;

                        console.log(_self.validations, _self.status, _self.message_);
                        if (_self.status === 0) {
                            Swal.fire(
                                'Echec!',
                                _self.message_,
                                'error'
                            )
                        }

                    }).catch(function (response) {
                });
                this.$refs['edit'].hide();
                this._fetch('/api/personnel?page=' + this.current_page_);
            }


        }

    }
</script>

<style scoped>
</style>