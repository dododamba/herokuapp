<template>


    <div class="row">

        <div class="pull-right"> <b-button  variant="success" @click="_create()">+ Découpage Un</b-button></div>

        <div class="col-md-12" v-if="items">
            <div class="single-table">
                <div class="table-responsive">
                    <table class="table table-striped  table-hover text-center">
                        <thead class="text-uppercase thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Libellé</th>
                            <th>Chef Lieu</th>
                            <th>Pays</th>
                            <th>Date d'ajout</th>
                            <th class="text-right"><p>Action</p></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="decoupageun in items.data">
                            <td>{{ decoupageun.id }}</td>
                            <td>{{ decoupageun.nom }}</td>
                            <td>{{ decoupageun.libelle }}</td>
                            <td>{{decoupageun.cheflieu}}</td>
                            <td>{{decoupageun.pays}}</td>
                            <td>{{ decoupageun.created_at}}</td>
                            <td class="text-right">
                                <button type="button" rel="tooltip" class="btn btn-info btn-icon btn-sm "
                                        title="detail" @click="show(decoupageun)">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button type="button" rel="tooltip" class="btn btn-success btn-icon btn-sm "
                                        title="mise à jours" @click="edit(decoupageun)">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" rel="tooltip" class="btn btn-danger btn-icon btn-sm "
                                        title="suppression" @click="deleteModal(decoupageun)">
                                    <i class="fa fa-times"></i>
                                </button>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination pagination-seperated pagination-seperated-rounded">

                            <li class="page-item" v-if="items.prev_page_url != null">
                                <button @click="_fetch(items.prev_page_url)" class="page-link">
                                    <span aria-hidden="true" class="fa fa-chevron-left"></span>
                                </button>
                            </li>
                            <li class="page-item"
                                v-if="items.prev_page_url != null || items.prev_page_url > 0 ">
                                <button @click="_fetch(items.prev_page_url)" class="page-link">{{
                                    items.current_page -1 }}
                                </button>
                            </li>
                            <li class="page-item active">
                                <a class="page-link">{{ items.current_page }}</a>
                            </li>
                            <li class="page-item" v-if="items.next_page_url != null">
                                <button @click="_fetch(items.next_page_url)" class="page-link">{{
                                    items.current_page +1 }}
                                </button>
                            </li>


                            <li class="page-item" v-if="items.next_page_url != null">
                                <button class="page-link" @click="_fetch(items.next_page_url)">
                                    <span aria-hidden="true" class="fa fa-chevron-right ml-1"></span>
                                </button>
                            </li>

                            <li class="page-item pull-right">
                                <button type="button" class="page-link btn-danger">Total : <span
                                        v-if="items.total > items.per_page">{{ items.per_page}} / {{ items.total }}</span>
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


        <template v-if="items == null" class="row">
            <b-alert show variant="danger">Pas de Pays enregistré pour le moment</b-alert>
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
                decoupageun :{
                    id: '',
                    iso: '',
                    name: '',
                    numcode: '',
                    nicename: '',
                    iso3: '',
                    phonecode: '',
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

            }
        },
        mounted() {
            this._fetch('/api/decoupageun?page=0');
        },
        methods: {
            _fetch(url) {
                let _self = this;
                axios.get(url)
                    .then(function (response) {
                        _self.empty_ = response.data.message;
                        _self.items = response.data.content.decoupageun;
                        _self.current_page_ = _self.items.current_page;

                        console.log(_self.items)

                    }).catch(function (response) {
                });
            },

            _create(){

                let _self = this;


                Swal.fire({
                    title: 'Enregistrement decoupageun ',
                    input: 'text',
                    focusConfirm: false,

                    showCancelButton: true,
                    confirmButtonText: '<i class="fa fa-check"></i>Confirmer',
                    cancelButtonText: '<i class="fa fa-window-close" aria-hidden="true"></i>Annuller',

                }).then((result) => {
                    if (result.value) {
                        axios.post('/api/decoupageun/')
                            .then(function (response) {
                            }).catch(function (response) {
                        });
                        this._fetch('/api/decoupageun?page=' + _self.current_page_);
                        Swal.fire(
                            'Succès !',
                            'Enregistrement effectué !',
                            'success'
                        )

                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire(
                            'Abandon !',
                            'L\'enregistrement n\'a pas été effectué !',
                            'error'
                        )
                    }
                })
            },
            update(item) {
                var _self = this;
                var _decoupageun = _self.decoupageun;
                _decoupageun = item;

                axios.post('/api/update-decoupageun', _decoupageun)
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
                this._fetch('/api/decoupageun?page=' + this.current_page_);
            }


        }

    }
</script>

<style scoped>
</style>