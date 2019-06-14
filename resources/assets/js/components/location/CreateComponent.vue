<template>

    <div>
        <b-form @submit.prevent="onSubmit" @reset="onRestForm">
            <b-row>
                <div class="col-6">
                    <b-row>
                        <div class="form-group col-6">
                            <label for="partenaireId"> Partenaire  (*)</label>
                            <select v-model="form_location.partenaire" class="form-control" id="partenaireId">
                                <option value="null" disabled selected> -- choisir partenaire -- </option>
                                <option :value=partenaire.value v-for="partenaire in partenaires">{{partenaire.text}}</option>
                            </select>
                            <p v-if="errors.partenaire" style="color: red">
                                {{errors.partenaire[0]}}
                            </p>
                        </div>
                        <div class="form-group col-6">
                            <label for="titre_location" class="form-control-label"> Titre </label>
                            <input type="text"  v-model="form_location.title" class="form-control" id="titre_location">
                        </div>
                    </b-row>
                    <b-row>
                        <div class="form-group col-6">
                            <label> Date début disponibilité</label>
                            <date-picker
                                    width="100%"
                                    v-model="form_location.date_debut"
                                    type="date" lang="fr" format="DD/MM/YYYY"
                                    :first-day-of-week="1" :not-before="new Date()">
                            </date-picker>
                            <p v-if="errors.date_depart" style="color: red">
                                {{errors.date_depart[0]}}
                            </p>
                        </div>
                        <div class="form-group col-6">
                            <label> Date fin disponibilité  </label>
                            <date-picker
                                    width="100%"
                                    v-model="form_location.date_fin" format="DD/MM/YYYY"
                                    type="date" lang="fr"
                                    :first-day-of-week="1" :not-before=form_location.date_debut>
                            </date-picker>
                            <p v-if="errors.heure_depart" style="color: red">
                                {{errors.heure_depart[0]}}
                            </p>
                        </div>
                    </b-row>
                    <b-row>
                        <b-form-group class="col-6">
                            <label>Pays</label>
                            <b-form-select v-model="form_location.pays_location" :options="pays" v-on:input="charger_ville(form_location.pays_location)">
                                <template slot="first">
                                    <option :value="null" disabled> -- Selectionnez un pays --</option>
                                </template>
                            </b-form-select>
                        </b-form-group>
                        <b-form-group class="col-6">
                            <label >Ville</label>
                            <b-form-select v-model="form_location.ville_location" :options="villes" required>
                                <template slot="default">
                                    <option :value="null" disabled> -- Selectionnez une ville --</option>
                                </template>
                            </b-form-select>
                        </b-form-group>
                    </b-row>
                </div>
                <div class="form-group col-6">
                    <label for="description">Description de la location</label>
                    <textarea class="form-control" rows="10" v-model="form_location.description" id="description" ></textarea>
                </div>
            </b-row>

            <b-row>
                <br>
                <div class="card card-default col-12">
                    <h5 class="card-header bg-info">Ajouter les images </h5>
                    <div class="card-body">
                        <b-row>
                            <div class="offset-4 col-4">
                                <imageComponent :logo=null></imageComponent>
                            </div>
                        </b-row>
                        <br>
                        <b-row>

                        </b-row>
                    </div>
                </div>
            </b-row>
            <div class="row" style="margin-top: 20px">
                <div class="col-6">
                    <b-button type="reset" block variant="danger">Annuler</b-button>
                </div>
                <div class="col-6">
                    <b-button type="submit" block variant="success">Enregistrer </b-button>
                </div>
            </div>
        </b-form>
    </div>
</template>


<script>
    import axios from 'axios';
    import DatePicker from 'vue2-datepicker';

    export default {
        props: ['location'],
        components: { DatePicker},
        data() {
            return {

                form_location: {
                    'partenaire': null,
                    'title': '',
                    'description': '',
                    'date_debut': '',
                    'date_fin': '',
                    'photos': [],
                    'pays_location': '',
                    'ville_location': ''
                },
                errors: [],
                partenaires: [],

                update: false,
                pays: [] ,
                all_cities: [],
                villes: [],
            }
        },
        computed: {
            valid_date_depart() {
                return this.errors.date_depart == null ? null: false;
            }
        },
        mounted() {

            this.init_form();

            // Recuperer tous les partenaire de la base de données
            this.recuperer_partenaire();


            this.load_countries();
            this.load_all_cities();
            // On écoute le composant image
            this.$root.$on('image' , (image_loaded) => {
                this.put_image(image_loaded);
            })

        },
        methods: {

            init_form() {
               if ( this.location == null) {
                   this.update = false;

               } else {
                   this.update = true;
                   this.form_location.partenaire = this.location.partenaire;
                   this.form_location.description = this.location.description;
                   this.form_location.title = this.location.titre;
                   this.form_location.date_fin = this.location.date_fin_disponibilite;
                   this.form_location.date_debut = this.location.date_debut_disponibilite;
               }

            },

            put_image(image) {
                console.log(image);

            },

            is_updated(){
                return !(
                    this.form_location.partenaire === this.location.partenaire &&
                    this.form_location.description === this.location.description &&
                    this.form_location.title === this.location.titre &&
                    this.form_location.date_fin === this.location.date_fin_disponibilite &&
                    this.form_location.date_debut === this.location.date_debut_disponibilite
                ) ;
            },

            onSubmit() {

                if(this.update) {
                    // Nous sommes dans un de modification de location
                    if (!this.is_updated()) {
                        swal.fire({
                            title: 'Pas de modification!',
                            type: 'error',
                            text: 'Vous n\'avez rien modifié!!!',
                        });
                    } else {
                        axios.put('api/location/'+this.location.slug, this.form_location)
                            .then((response) => {
                                console.log(response)
                                swal.fire({
                                    title: 'Modification!',
                                    type: 'success',
                                    text: 'Location modifiée avec succès!!!',
                                });
                            })
                    }
                } else {
                    axios.post('/api/location', this.form_location)
                        .then((response) => {
                            swal.fire({
                                title: 'Création!',
                                type: 'success',
                                text: 'Location planifié !!!',
                            });
                        }).catch(error => console.log(error));
                }

            },

            onRestForm() {

            },

            recuperer_partenaire() {
                let part = [];
                axios.get('/api/partenaire')
                    .then( (response) => {
                        part = response.data.content;

                        /*
                          On recupère tous les partenaires activés
                         */
                        part.forEach((par) => {
                            if (par.is_actived){
                                this.partenaires.push({
                                    value: par.id,
                                    text: par.nom_partenaire,
                                });
                            }
                        });
                    }).catch((response) => {
                    this.partenaires = [];
                });
            },

            load_countries() {
                axios.get('/api/pays')
                    .then((response) =>{
                        response.data.content.pays.data.forEach( (country) => {
                            this.pays.push({
                                value: country.id,
                                text: country.nom,
                            });
                        });

                    }).catch((response) => {
                        console.log(response);
                    }
                );
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
                        })
                    }).catch(err => console.log(err));
            },

            // En fonction du pays de depart
            charger_ville($id_pays) {
                this.villes = [];
                this.all_cities.forEach( (city) => {
                    if (city.pays_id === $id_pays) {
                        this.villes.push({
                            value: city.id,
                            text: city.nom,
                        });
                    }
                });
            },
        }
    }
</script>