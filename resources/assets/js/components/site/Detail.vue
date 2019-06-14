<template>
    <div>

        <b-card>
            <h6 slot="header" class="mb-0">Informations Générales du Partenaire</h6>
            <b-card-text>
                <div class="row">
                    <div class="col-5">
                        <b> Nom du Partenaire : </b> {{detail_partenaire.nom}} <br><br>
                        <b> Type du Partenaire : </b> {{detail_partenaire.type}} <br><br>
                        <b> Etat d'enregistrement  : </b> {{ etat_partenaire }} <br><br>
                    </div>
                    <div class="col-5">
                        <b> Adresse partenaire : </b> {{detail_partenaire.adresse}} <br><br>
                        <b> Email : </b> {{detail_partenaire.user.email}} <br><br>
                        <b> Numéro de tel : </b> {{detail_partenaire.numero_tel}} <br><br>
                    </div>
                    <div class="col-2">

                    </div>
                </div>
            </b-card-text>
        </b-card>
        <br>
        <b-card>
            <h6 slot="header" class="mb-0">Information agence principale</h6>
            <b-card-text>
                <div class="row">
                    <div class="col-6">
                        <b> Libelle : </b> {{ detail_partenaire.agence_principale.libelle}} <br><br>
                        <b> Contact : </b> {{ detail_partenaire.agence_principale.contact}} <br><br>
                        <b> Adresse : </b> {{ detail_partenaire.agence_principale.adresse}} <br><br>
                    </div>
                    <div class="col-6" style="{text-align: right}">
                        <b> Ville  : </b> {{ ville_principale }} <br><br>
                        <b> email  : </b> {{ detail_partenaire.agence_principale.email}} <br><br>
                    </div>
                </div>

            </b-card-text>
        </b-card>
        <br>
        <!-- les autres agences du partenaire-->
        <b-card>
            <h6 slot="header" class="mb-0"> Les autres agences du partenaire </h6>
            <b-card-text>


                <div class="single-table">
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead class="text-uppercase thead-dark">
                            <tr class="text-white">
                                <th scope="col">Libelle </th>
                                <th scope="col">Contact </th>
                                <th scope="col">Adresse </th>
                                <th scope="col">Email</th>
                                <th scope="col">ville</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="agence in agences">
                                <td>{{ agence.libelle }}</td>
                                <td>{{ agence.contact}}</td>
                                <td>{{ agence.adresse}}</td>
                                <td>{{ agence.email}}</td>
                                <td>{{ agence.ville}}</td>
                                <td>
                                    <button v-b-tooltip.hover title="Détail du partenaire" class="mb-1 btn btn-pill btn-info" @click="onDetail(partenaire)">
                                        <i class="mdi mdi-eye"></i>
                                    </button>
                                    <button v-b-tooltip.hover title="Modifier"class="mb-1 btn btn-pill btn-warning" @click="">
                                        <i class="mdi mdi-pencil"></i>
                                    </button>
                                    <button  class="mb-1 btn btn-pill btn-danger" v-b-tooltip.hover title="Supprimer"
                                             @click="removePartenaire(partenaire)">
                                        <i class="mdi mdi-delete-forever"></i>
                                    </button>

                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>



            </b-card-text>
        </b-card>

    </div>
</template>

<script>

    import axios from 'axios';

    Vue.use(axios);

    export default {
        props: ['partenaire'],

        data () {
            return {
                detail_partenaire : '',
                ville_principale: '',
                etat_partenaire: '',
                type_partenaire: null,
                ville_tmp: '',
                agences: [],
            }
        },
        mounted() {
            this.charger_info_partenaire();
        },

        methods: {

            charger_info_partenaire() {

                // On doit recuperer le partenaire avcec ses relations
                axios.get('/api/partenaire/'+this.partenaire.slug)
                    .then( (response) => {
                        this.detail_partenaire = response.data.content;

                        this.etat_partenaire = this.detail_partenaire.etat == 1 ? 'Non Validé' : 'Validé';

                        // Calcul du type du partenaire
                        this.type_partenaire = this.detail_partenaire.type == 'Entreprise' ?  true : false;

                        this.detail_partenaire.agences.forEach( (agence) => {
                            this.ville_id(agence.ville).then(response => {
                                this.agences.push({
                                    libelle: agence.libelle,
                                    contact: agence.contact,
                                    adresse: agence.adresse,
                                    email: agence.email,
                                    ville: response,
                                });

                            })
                        });
                        // On charger la ville à partir de l'ID
                        this.ville_id(this.detail_partenaire.agence_principale.ville).then(
                            response => this.ville_principale = response
                        );
                    })
                    .catch(error => { console.log(error)})
            },

            ville_id(id){
                return axios.get('/api/ville_id/' + id)
                    .then( response => {
                        return response.data.content.nom
                    }).catch(err => {
                        console.log(err)
                    });
            },

        },
    }
</script>

<style scoped>

</style>