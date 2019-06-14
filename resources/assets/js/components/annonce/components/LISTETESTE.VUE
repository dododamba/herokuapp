<template>



    <div class="row">
        <div class="col-md-12" v-if="annonces != null">
            <div class="card card-default">


                <div class="card-body">
                    <input type="text" class="form-control mb-3" placeholder="Recherche par nom" v-model="search" @keyup="searchRecord">


                    <div class="single-table">
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead class="text-uppercase thead-light">
                                <tr class="text-white text-center">
                                    <th scope="col">Titre</th>
                                    <th scope="col">contenue</th>
                                    <th scope="col">Date de création</th>
                                    <th scope="col">Date Debut</th>
                                    <th scope="col">etat</th>
                                    <th scope="col">action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="annonce in annonces.content.data">
                                    <td>{{ annonce.titre }}</td>
                                    <td>{{ annonce.contenue }}</td>
                                    <td>{{ annonce.created_at}}</td>
                                    <td>{{ annonce.dateDebut}}</td>
                                    <td>{{ annonce.etat}}</td>
                                    <td class="text-right">
                                        <div class="dropdown show d-inline-block widget-dropdown">
                                            <a class="dropdown-toggle icon-burger-mini" href="" role="button" id="dropdown-recent-order1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a>
                                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order1">
                                                <li class="dropdown-item">
                                                    <button class="mb-1 btn btn-pill btn-info" @click="show(client)">
                                                        <i class="mdi mdi-eye"></i>
                                                    </button>
                                                </li>
                                                <li class="dropdown-item">
                                                    <button class="mb-1 btn btn-pill btn-warning" @click="edit(client)">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </button>
                                                </li>
                                                <li class="dropdown-item">
                                                    <button  class="mb-1 btn btn-pill btn-danger" @click="deleteModal(client)">
                                                        <i class="mdi mdi-delete-forever"></i>
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <template v-if="annonces == null" class="row">
            <b-alert show variant="danger">Pas de annonce enregistré pour le moment</b-alert>
        </template>
    </div>
</template>

<script>

    import VueAxios from 'vue-axios';
    import axios from 'axios';
    Vue.use(VueAxios, axios);

    export default {
        data(){
            return {
                annonce : {},
                annonces: [],
            }
        },
        mounted() {
            this.all_annonce();
        },

        methods: {

            removeannonce(part) {
                swal.fire({
                    title: 'êtes-vous sûr de vouloir supprimer?',
                    text: "Vous ne pourrez plus le récuperer! ",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, Supprimer!',
                    cancelButtonText:'Non, annuler'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/annonce/'+part.slug)
                            .then( (response) => {
                                swal.fire(
                                    'Supprimé!',
                                    'Le annonce a été supprimé.',
                                    'success'
                                );
                                this.all_annonce();
                            })
                    }
                })
            },

            all_annonce() {
                let ar = this;

                axios.get('/api/annonce')
                    .then(function(response){
                        ar.annonces = response.data;
                        console.log(ar.annonces)
                    }).catch(
                    function(response){
                        console.log(response)

                    }
                );
            },

            onDetail(annonce) {
                this.$root.$emit('detail-annonce', annonce );
            },

            onUpdate(annonce) {
                this.$root.$emit('update-annonce', annonce );
            }

        },
    }
</script>