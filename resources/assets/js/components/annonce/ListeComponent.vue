<template>

    <div class="container m-lg-auto">
        <div class="row justify-content-center">
            <div class="col-md-auto">
                <div class="card card-default"><h1>
                    <div class="card-header bg-transparent text-primary">Gvoyage
                        <button class="btn btn-link btn-sm pull-right" data-target="#addRecord" data-toggle="modal">
                            <i class="fa  fa-sign-language" aria-hidden="true"></i></button>
                    </div>
                </h1>


                    <div class="card-body">
                        <input @keyup="searchRecord" class="form-control mb-3" placeholder="Recherche "
                               type="text"
                               v-model="search">
                        <table class="table">

                        <thead class="text-uppercase thead-dark">
                            <tr class="text-primary text-center">
                                <th scope="col">Titre</th>
                                <th scope="col">Date de création</th>
                                <th scope="col">Date Debut</th>
                                <th scope="col">Publier?</th>
                                <th scope="col">action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="record in records.content.data" class="text-center">
                                <td v-text="record.titre"></td>
                                <td v-text="record.created_at_human"></td>
                                <td v-text="record.dateDebutHuman"></td>
                                <td>
                                    <button v-if="record.etat == 2 " class="btn btn-success btn-link"
                                            data-toggle="modal" data-target="#viewRecord" @click="get(record.slug)"> Active
                                    </button>
                                    <button v-else class="btn btn-danger btn-xs  btn-link" data-toggle="modal" data-target="#viewRecord" @click="get(record.slug)">
                                        Désactive
                                    </button>
                                </td>

                                <td>
                                    <button class="btn btn-outline-info btn-sm  btn-link" data-toggle="modal" data-target="#viewRecord" @click="get(record.slug)"><i class="fa fa-eye"></i></button>

                                    <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editRecord" @click="get(record.slug)"><i class="fa fa-edit"></i></button>

                                    <button class="btn btn-outline-danger btn-sm" @click="remove(record.slug)"><i class="fa fa-trash"></i></button>
                                </td>





                            </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4 offset-4 mt-4">
                    <pagination :data="records" v-on:pagination-change-page="list"></pagination>
                </div>
            </div>
        </div>

        <div id="modal">
            <create @recordAdded="list"></create>
            <edit :editRec="editRec" @recordUpdated="getResults"></edit>
            <show :viewRec="editRec"></show>
        </div>

    </div>




</template>
<script>
    import Pagination from 'laravel-vue-pagination'
    import VueAxios from 'vue-axios';
    import axios from 'axios';
    import BootstrapVue from 'bootstrap-vue'

    Vue.use(BootstrapVue)

    Vue.use(VueAxios, axios);
    export default {
        activate : '#activate',

        data(){
            return {
                record : {},
                records : {},
                editRec: [],
                errors: [],
                search: '',
                is_completed:[]
            }
        },


        components: {
            Pagination
        },


        methods: {


            getResults(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }

                axios.get(`/api/annonce?page=${page}`)
                    .then(response => this.records = response.data)
                    .catch(response => console.log(response))
            },

            refreshRecord(record) {
                this.records = record.data;
            },



            activate(){
                this.$refs['my-modal'].show()

            },

            list(page)
            {
                let ar = this;
                if (typeof page === 'undefined') {
                    page = 1;
                }

                axios.get('/api/annonce?page=${page}')
                    .then(function(response){
                        ar.records = response.data;
                        console.log(ar.records)
                    }).catch(
                    function(response){
                        console.log(response)

                    }
                );
            },



            refreshRecord(record) {
                this.records = record.data.content;
            },

            get(slug) {
                axios.get(`/api/annonce/${slug}`)
                    .then(response => this.editRec = response.data.content)
                    .catch(
                    function(response){
                    console.log(response)

                })
            },

            remove(slug) {
                swal.fire({
                    title: 'êtes-vous sûr de vouloir  supprimer?',
                    text: "Vous ne pourrez plus le récuperer! ",
                    type: '',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, Supprimer!',
                    cancelButtonText:'Non, annuler'
                })
                    .then((result) => {
                        if (result.value) {
                            axios.delete(`/api/annonce/${slug}`)
                                .then(response => {
                                    this.refreshRecord(response);

                                    swal.fire(

                                        'Supprimé!',
                                        'L\'annonce a été supprimé.',
                                        'success'
                                    );
                                    this.list();
                                })
                        }
                    })
            },

            searchRecord() {
                if (this.search.length >= 3) {
                    axios.get(`/api/annonce/search/${this.search}`)
                        .then(response => this.records = response)
                        .catch(error => console.log(error))
                } else {
                    this.list();
                }
            }
        },
        created() {
            axios.get('/api/annonce')
                .then(response => this.records = response.data)
                .catch(error => console.log(error))
        }




    }
</script>

