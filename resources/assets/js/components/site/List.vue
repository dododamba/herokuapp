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
                            <th>Nom </th>
                            <th>Description</th>
                            <th>ville</th>
                            <th>Date de création</th>
                            <th class="text-right"><p>Action</p></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="site in items">
                            <td>{{ site.id }}</td>
                            <td>{{ site.nom }}</td>
                            <td></td>
                            <td></td>
                            <td>{{ site.created_at}}</td>

                            <td class="text-right">
                                <button type="button" rel="tooltip" class="btn btn-danger btn-icon btn-sm "
                                        title="suppression" @click="_delete(site)">
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
            <b-alert show variant="danger">Pas d'Article enregistré pour le moment</b-alert>
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
                message: '',
                message_: '',
                role_: '',
                created_: '',
                site : {
                    nom: '',
                    description: '',
                    ville: '',
                },




            }
        },
        mounted() {
            this._fetch('/api/site');
        },
        methods: {
            _fetch(url) {
                let _self = this;
                axios.get(url)
                    .then(function (response) {
                        _self.items = response.data.content;
                    }).catch(function (response) {
                });
            },

            _delete(item) {
                let _self = this;
                var _item = item;
                var _slug = _item.slug;


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


        }

    }
</script>

<style scoped>
</style>