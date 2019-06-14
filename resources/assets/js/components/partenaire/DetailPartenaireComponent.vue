<template>
    <div>
        <div class="card">
            <div class="card-header">Informations Générales du Partenaire</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <b> Nom du Partenaire : </b> {{detail_partenaire.nom}} <br><br>
                        <b> Type du Partenaire : </b> {{detail_partenaire.type}} <br><br>
                        <b> Etat d'enregistrement  : </b> {{ etat_partenaire }} <br><br>
                    </div>
                    <div class="col-4">
                        <b> Adresse partenaire : </b> {{detail_partenaire.adresse}} <br><br>
                        <b> Email : </b> {{detail_partenaire.user.email}} <br><br>
                        <b> Numéro de tel : </b> {{detail_partenaire.numero_tel}} <br><br>
                    </div>
                    <div class="col-4 image-div">
                        <img v-if="detail_partenaire.logo != null" :src="detail_partenaire.logo" alt="Logo du partenaire">
                        <img v-else src="/Storage.defaults/default_image.png" alt="Logo du partenaire">
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-header">Information agence principale</div>
            <div class="card-body">
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

            </div>
        </div>
        <!-- les autres agences du partenaire-->
        <div class="card">
            <div class="card-header"> Les autres agences du partenaire </div>
            <div class="card-body">


                <div class="single-table">
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead class="text-uppercase thead-light">
                            <tr class="text-dark">
                                <th scope="col">Libelle </th>
                                <th scope="col">ville</th>
                                <th scope="col">Contact </th>
                                <th scope="col">Adresse </th>
                                <th scope="col">Email</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="agence in agences">
                                <td>{{ agence.libelle }}</td>
                                <td>{{ ville_id(agence.ville)}}</td>
                                <td>{{ agence.contact}}</td>
                                <td>{{ agence.adresse}}</td>
                                <td>{{ agence.email}}</td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

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

                all_cities: [],
            }
        },
        mounted() {
            this.load_all_cities();
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
                                this.agences.push({
                                    libelle: agence.libelle,
                                    contact: agence.contact,
                                    adresse: agence.adresse,
                                    email: agence.email,
                                    ville: agence.ville
                                    })
                        });
                        // On charger la ville à partir de l'ID
                        this.ville_principale = this.ville_id(this.detail_partenaire.agence_principale.ville);
                    })
                    .catch(error => { console.log(error)})
            },
            // Charger les villes
            load_all_cities() {
                this.all_cities = [];
                let cities = [];
                this.axios.get('/api/ville')
                    .then((response) => {
                        cities = response.data.content.data;
                        cities.forEach((ville) => {
                            this.all_cities.push({
                                id: ville.id,
                                nom: ville.nom,
                                pays_id: ville.pays
                            })
                        });
                    }).catch(err => console.log(err));
            },

            ville_id(id_seek){
                let $ville = '';
                this.all_cities.forEach( (city) => {
                    if (city.id === id_seek) {
                        $ville = city.nom;
                    }
                });
                return $ville;
            },

        },
    }
</script>

<style scoped>
    .image-div img{
        width: 200px;
        height: 150px;
    }
</style>