<template>


    <div class="row">


        <div class="col-md-12" v-if="items">
            <div class="single-table">
                <div class="table-responsive">
                    <table class="table table-striped  table-hover text-center">
                        <thead class="text-uppercase thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Statut</th>
                            <th>Dernier connexion</th>
                            <th>Date de création</th>
                            <th class="text-right"><p>Action</p></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="client in items.data">
                            <td>{{ client.id }}</td>
                            <td>{{ client.nom }}</td>
                            <td>{{ client.prenom }}</td>
                            <td>{{ client.compte.email }}</td>
                            <td>{{ client.compte.user_role.nom }}</td>
                            <td>
                                <button v-if="client.compte.is_active == null " class="btn btn-success"
                                        @click="_activate(client)"> Activer
                                </button>
                                <button v-else class="btn btn-danger" @click="_activate(client)">
                                    Désactiver
                                </button>
                            </td>
                            <td>{{ client.compte.last_login}}</td>
                            <td>{{ client.compte.created_at}}</td>
                            <td class="text-right">
                                <button type="button" rel="tooltip" class="btn btn-danger btn-icon btn-sm "
                                        title="suppression" @click="_delete(client)">
                                    <i class="fa fa-times"></i>
                                </button>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>


        <template v-if="items == null" class="row">
            <b-alert show variant="danger">Pas de client enregistré pour le moment</b-alert>
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
                status: '',
                is_completed: [],
                roles_: {
                    id: '',
                    name: '',
                },
                empty_: '',
                message: '',
                message_: '',
                status_: '',
                email_: '',
                birth_: '',
                name: '',
                role_: '',
                validations: [],
                current_page_: '',
                date_embauche: '',
                client: {
                    nom: '',
                    prenom: '',
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
            }
        },
        mounted() {
            this._fetch('/api/client?page=0');
        },
        methods: {
            _fetch(url) {
                let _self = this;
                axios.get(url)
                    .then(function (response) {
                        _self.empty_ = response.data.message;
                        _self.items = response.data.content.clients;
                        _self.current_page_ = _self.items.current_page;

                    }).catch(function (response) {
                });
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

                            axios.get('/api/client/desactivate/' + _slug)
                                 .then(function (response) {
                                     console.log('done !')
                                 });
                            this._fetch('/api/client?page=' + this.current_page_);
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
                            axios.get('/api/client/activate/' + _slug)
                                .then(function (response) {
                                    console.log('done !')

                                });
                            this._fetch('/api/client?page=' + this.current_page_);
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
                        axios.delete('/api/delete-client/' + _slug)
                            .then(function (response) {
                            }).catch(function (response) {
                        });
                        this._fetch('/api/client?page=' + this.current_page_);
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
                this.$refs['show'].show()
            },
            edit(c) {

                this.client = c;
                this.$refs['edit'].show();
            },


            update(item) {
                var _self = this;
                var _client = _self.client;
                _client = item;

                axios.post('/api/update-client', _client)
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
                this._fetch('/api/client?page=' + this.current_page_);
            }


        }

    }
</script>

<style scoped>
</style>