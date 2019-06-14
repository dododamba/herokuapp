<template>
    <div class="card">
        <div class="card-body">

            <b-form @submit.prevent="onSubmit" @reset="onResetForm" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-9">
                        <div class="row">
                            <b-form-group label="Nom du partenaire:" class="col-6">
                                <b-form-input placeholder="Saisir le nom du partenaire ici" v-model="name"
                                              :state="valid_name" required>
                                </b-form-input>
                                <p v-if="errors.name" style="color: red"> {{errors.name[0]}}</p>
                            </b-form-group>

                            <b-form-group label="Site web:" class="col-6">
                                <b-form-input placeholder="Le Site web du partenaire" v-model="site_web">
                                </b-form-input>
                            </b-form-group>
                        </div>
                        <div class="row">
                            <b-form-group label="Adresse du partenaire" class="col-6">
                                <b-form-input placeholder="Saisir l'adresse du partenaire" v-model="adresse_partenaire"
                                            :state="valid_adresse_partenaire">
                                </b-form-input>
                                <p v-if="errors.adresse_partenaire" style="color: red">
                                    {{errors.adresse_partenaire[0]}}
                                </p>
                            </b-form-group>

                            <b-form-group label="Email" class="col-6">
                                <b-form-input placeholder="Email du partenaire" v-model="email_partenaire"
                                                :state="valid_email_partenaire">
                                </b-form-input>
                                <p v-if="errors.email_partenaire" style="color: red"> {{errors.email_partenaire[0]}}</p>
                            </b-form-group>
                        </div>

                        <div class="row">
                            <b-form-group label="Type partenaire" class="col-6">
                                <b-form-select v-model="type_partenaire" :options="type_entreprise" :state="valid_type_partenaire" >
                                    <template slot="first">
                                        <option :value="null" disabled> -- Selectionnez un pays --</option>
                                    </template>
                                </b-form-select>
                                <p v-if="errors.type_partenaire" style="color: red"> {{errors.type_partenaire[0]}}</p>
                            </b-form-group>

                            <b-form-group label="Langue" class="col-6">
                                <b-form-select v-model="langue" :options="langues">
                                    <template slot="first">
                                        <option :value="null" disabled> -- Choisir la langue --</option>
                                    </template>
                                </b-form-select>
                            </b-form-group>
                        </div>
                    </div>

                    <div class="col-3">
                        <imageComponent :logo=null></imageComponent>
                        <p v-if="errors.logo" style="color: red"> {{errors.logo[0]}}</p>
                    </div>
                </div>
                <div class="row">
                    <b-form-group label="Description" class="col-12">
                        <b-form-textarea
                                v-model="description"
                                placeholder="La description de du partenaire ici ..."
                                rows="5"
                                :state="valid_description"
                        ></b-form-textarea>
                        <p v-if="errors.description" style="color: red"> {{errors.description[0]}}</p>
                    </b-form-group>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h2>Information sur agence principale</h2>
                        <hr>
                    </div>
                </div>
                <div class="row">

                    <b-form-group label="Nom agence" class="col-6">
                        <b-form-input placeholder="Nom agence" v-model="libelle_agence" :state="valid_libelle_agence">
                        </b-form-input>
                        <p v-if="errors.libelle_agence" style="color: red">
                            {{errors.libelle_agence[0]}}
                        </p>
                    </b-form-group>

                    <b-form-group label="Numéro de téléphone de l'agence" class="col-6">
                        <b-form-input placeholder="Numéro de téléphone" v-model="contact_agence"></b-form-input>
                    </b-form-group>
                </div>
                <div class="row">
                    <b-form-group label="Adresse agence" class="col-6">
                        <b-form-input placeholder="Adresse de l'agence" v-model="adresse_agence"></b-form-input>
                        <p v-if="errors.adresse_agence" style="color: red"> {{errors.adresse_agence[0]}}</p>
                    </b-form-group>

                    <b-form-group label="Email agence" class="col-6">
                        <b-form-input placeholder="Email de l'agence principale" v-model="email_agence" :state="valid_email_agence"></b-form-input>
                        <p v-if="errors.email_agence" style="color: red">
                            {{errors.email_agence[0]}}
                        </p>
                    </b-form-group>

                </div>
                <div class="row">
                    <b-form-group label="Pays agence :" class="col-6">
                        <b-form-select v-model="pays_agence" :options="pays" v-on:input="charger_ville">
                            <template slot="first">
                                <option :value="null" disabled> -- Selectionnez un pays --</option>
                            </template>
                        </b-form-select>
                    </b-form-group>
                    <b-form-group label="Ville agence:" class="col-6">
                        <b-form-select v-model="ville_agence" :options="villes" required>
                            <template slot="default">
                                <option :value="null" disabled> -- Selectionnez une ville --</option>
                            </template>
                        </b-form-select>
                    </b-form-group>
                </div>
                <div class="row">
                    <div class="col-6">
                        <b-button block type="reset" variant="danger">Annuler</b-button>
                    </div>
                    <div class="col-6">
                        <b-button block type="submit" variant="info" >Enregistrer</b-button>
                    </div>
                </div>
            </b-form>

        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {

        data() {
            return {
                name: '',
                site_web: '',
                adresse_partenaire: '',
                email_partenaire:'',
                type_partenaire: null,
                langue: null,
                description: '',
                libelle_agence: '',
                contact_agence: '',
                adresse_agence:'',
                email_agence: '',
                pays_agence: null,
                ville_agence: null,
                logo: null,
                pays: [] ,
                all_cities: [],
                villes: [],

                errors: [],
                type_entreprise: [
                    {value: 'Entreprise', text: 'Entreprise'},
                    {value: 'Particulier', text: 'Particulier'},
                ],

                langues : [
                        {value:'français', text: 'Français'},
                        {value:'anglais', text: 'Anglais'}
                    ],
            }
        },

        computed: {

            valid_email_agence() {
                    return this.errors.email_agence == null ? null: false ;
            },
            valid_email_partenaire() {
                    return this.errors.email_partenaire == null ? null: false ;
            },
            valid_type_partenaire() {
                    return this.errors.type_partenaire == null ? null: false ;
            },
            valid_adresse_partenaire() {
                    return this.errors.adresse_partenaire == null ? null: false ;
            },
            valid_description() {
                    return this.errors.valid_description == null ? null: false ;
            },
            valid_libelle_agence() {
                    return this.errors.libelle_agence == null ? null: false ;
            },

            valid_name() {
                return this.errors.name == null ? null : false;
            }
        },
        mounted() {

            // On écoute le composant image
            this.$root.$on('image' , (image_loaded) => {
                this.put_logo(image_loaded);
            });

            this.load_countries();
            this.load_all_cities();
        },
        methods: {

            put_logo(image) {
                this.logo = image;
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
            charger_ville() {
                this.villes = [];
                this.all_cities.forEach( (city) => {
                    if (city.pays_id === this.pays_agence) {
                        this.villes.push({
                            value: city.id,
                            text: city.nom,
                        });
                    }
                });
            },
            onSubmit() {
                var new_partenaire = {
                    'name': this.name,
                    'site_web': this.site_web,
                    'adresse_partenaire': this.adresse_partenaire,
                    'email_partenaire': this.email_partenaire,
                    'type_partenaire': this.type_partenaire,
                    'langue': this.langue,
                    'description': this.description,
                    'libelle_agence': this.libelle_agence,
                    'contact_agence': this.contact_agence,
                    'adresse_agence': this.adresse_agence,
                    'email_agence': this.email_agence,
                    'pays_agence': this.pays_agence,
                    'ville_agence': this.ville_agence,
                    'logo' : this.logo
                };

                axios.post('/api/partenaire', new_partenaire)
                    .then((response) => {
                        if(response.data.status === 1) {
                            this.errors = [];
                            toast.fire({
                                type: 'success',
                                title: 'Succès',
                                html: 'Partenaire créé avec succès'
                            });
                            this.onResetForm();
                        }else {
                            this.errors = response.data.errors;
                            toast.fire({
                                type: 'error',
                                title: 'Erreur !',
                                html: response.data.message
                            });
                        }
                    }).catch((response) => {
                        console.log(response);
                });
            },

            onResetForm() {
                this.name = '',
                this.site_web = '',
                this.adresse_partenaire = '',
                this.email_partenaire ='',
                this.type_partenaire ='',
                this.langue = '',
                this.description = '',
                this.libelle_agence = '',
                this.contact_agence ='',
                this.adresse_agence ='',
                this.email_agence = '',
                this.pays_agence = null,
                this.ville_agence =null,
                this.logo = null
            },
        }

    }
</script>

<style scoped>

</style>