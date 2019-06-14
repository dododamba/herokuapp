<template>
    <b-card title="">
        <b-card-text>

            <form @submit.prevent="onSubmit" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group col-12">
                        <label for="name" class=" form-control-label">Titre</label>
                        <input type="text" id="name" v-model="name"
                               placeholder="Titre de l'article" class="form-control">
                    </div>
                </div>


                <div class="form-group shadow-textarea">
                    <label>Description</label>
                    <vue-editor id="editor" useCustomImageHandler @imageAdded="handleImageAdded"
                                v-model="htmlForEditor"></vue-editor>

                </div>

                <hr>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-offset-3 col-sm-3">
                            <button type="submit" class="btn btn-primary form-control">
                                <i class="fa fa-check"></i> Enregistrer
                            </button>
                        </div>
                        <div class="col-sm-offset-3 col-sm-3">
                            <button type="reset" class="btn btn-danger form-control">
                                <i class="fa fa-ban"></i> Recommencer
                            </button>
                        </div>
                    </div>
                </div>

            </form>

        </b-card-text>

    </b-card>
</template>
<script>
    import axios from 'axios';
    import {VueEditor, Quill} from "vue2-editor";

    export default {
        components: {
            VueEditor
        },
        data() {
            return {
                name: '',
                site_web: '',
                adresse_partenaire: '',
                email_partenaire: '',
                type_partenaire: '',
                langue: '',
                description: '',
                libelle_agence: '',
                contact_agence: '',
                adresse_agence: '',
                email_agence: '',
                pays_agence: null,
                ville_agence: null,
                logo: null,
                pays: [],
                villes: [],
            }
        },

        mounted() {
            this.load_countries();
        },
        methods: {

            load_countries() {
                axios.get('/api/pays')
                    .then((response) => {
                        response.data.content.forEach((country) => {
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

            load_cities() {
                this.villes = [];
                axios.get('/api/ville-pays/' + this.pays_agence)
                    .then((response) => {
                        response.data.content.forEach((city) => {
                            this.villes.push({
                                value: city.id,
                                text: city.nom,
                            });
                        });
                    }).catch((response) => {
                        console.log(response);
                    }
                );
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
                    'ville_agence': this.ville_agence
                };

                axios.post('/api/partenaire', new_partenaire)
                    .then(() => {
                        //this.showAlert();
                        toast.fire({
                            type: 'success',
                            title: 'Partenaire créé avec succès !'
                        });
                        this.onResetForm();
                    }).catch((response) => {
                    console.log(response);
                });
            },


            onResetForm() {
                this.name = '',
                    this.site_web = '',
                    this.adresse_partenaire = '',
                    this.email_partenaire = '',
                    this.type_partenaire = '',
                    this.langue = '',
                    this.description = '',
                    this.libelle_agence = '',
                    this.contact_agence = '',
                    this.adresse_agence = '',
                    this.email_agence = '',
                    this.pays_agence = null,
                    this.ville_agence = null,
                    this.logo = null
            },
        }

    }
</script>

<style scoped>

</style>