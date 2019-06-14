<template>
    <div>
        <form @submit.prevent="onSubmit" enctype="multipart/form-data">
            <b-card>
                <h6 slot="header" class="mb-0">Informations Générales </h6>
                <b-card-text>
                    <div class="row">

                        <div class="col-10">

                            <div class="row">
                                <b-form-group label="Nom Partenaire :"  label-for="name" class="col-5">
                                    <b-form-input size="sm" id="name"  v-model="partenaire_form.name" type="text" required></b-form-input>
                                </b-form-group>
                                <b-form-group label="Adresse du partenaire:"  label-for="adresse" class="col-5">
                                    <b-form-input size="sm" id="adresse"  v-model="partenaire_form.adresse_partenaire" type="text" required></b-form-input>
                                </b-form-group>
                            </div>

                            <div class="row">
                                <b-form-group label="Numéro Téléphone :"  label-for="numero_tel" class="col-5">
                                    <b-form-input size="sm" id="numero_tel"  v-model="partenaire_form.numero_tel" type="text"></b-form-input>
                                </b-form-group>
                                <b-form-group label="type partenaire:"  label-for="type_partenaire" class="col-5">
                                    <b-form-input size="sm" id="type_partenaire"  v-model="partenaire_form.type_partenaire" type="text" required></b-form-input>
                                </b-form-group>
                            </div>


                        </div>
                        <div class="col-2">

                        </div>
                    </div>
                </b-card-text>
            </b-card>
            <br>
            <!-- les autres agences du partenaire -->
            <b-card>
                <h6 slot="header" class="mb-0"> Les autres agences du partenaire </h6>
                <b-card-text>
                    <div style="text-align: right">
                        <b-button variant="outline-success" v-on:click="add_agence_modal()" size="sm"> Ajouter Agence</b-button>
                        <hr>
                    </div>

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
                                        <a style="cursor: pointer" v-b-tooltip.hover title="Modifier"  @click="update_agence_modal(agence)">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                        <a style="cursor: pointer" v-b-tooltip.hover title="Supprimer"
                                                 @click="delete_agence(agence.slug)">
                                            <i class="mdi mdi-delete-forever"></i>
                                        </a>

                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </b-card-text>
            </b-card>
        </form>



        <!-- le modal -->
        <div>
            <b-modal v-model="showModal" :title="titleModal" :header-bg-variant="headerBgVariant"
                    :header-text-variant="headerTextVariant" :body-bg-variant="bodyBgVariant"
                    :body-text-variant="bodyTextVariant" :footer-bg-variant="footerBgVariant"
                     :footer-text-variant="footerTextVariant">
                <b-container fluid>
                    <div>
                        <form @submit.prevent="handle_agence">
                        <div class="row">
                            <b-form-group class="col-6" label="Libellé" label-for="libelle_agence">
                                <b-form-input size="sm" type="text" id="libelle_agence" v-model="agence_form.libelle"> </b-form-input>
                            </b-form-group>

                            <b-form-group class="col-6" label="Contact agence" label-for="contact_agence">
                                <b-form-input size="sm" type="text" id="contact_agence" v-model="agence_form.contact"> </b-form-input>
                            </b-form-group>
                        </div>
                        <div class="row">
                            <b-form-group class="col-6" label="Adresse" label-for="adresse_agence">
                                <b-form-input size="sm" type="text" id="adresse_agence" v-model="agence_form.adresse"> </b-form-input>
                            </b-form-group>

                            <b-form-group class="col-6" label="Email de l'agence" label-for="email_agence">
                                <b-form-input size="sm" type="email" id="email_agence" v-model="agence_form.email"> </b-form-input>
                            </b-form-group>
                        </div>
                        <div class="row">
                            <b-form-group  class="col-6">
                                <label for="select_pays_id"> Pays agence: {{agence_form.pays}}</label>
                                <b-form-select id="select_pays_id" size="sm" v-model="agence_form.pays" :options="pays" v-on:input="load_cities" >
                                    <template slot="first">
                                        <option :value="null" disabled> -- Selectionnez un pays --</option>
                                    </template>
                                </b-form-select>
                            </b-form-group>
                            <b-form-group label="Ville agence: " class="col-6">
                                <b-form-select size="sm" v-model="agence_form.ville" :options="villes" required>
                                    <template slot="default">
                                        <option :value="null" disabled> -- Selectionnez une ville --</option>
                                    </template>
                                </b-form-select>
                            </b-form-group>
                        </div>
                    </form>

                    </div>
                </b-container>

                <div slot="modal-footer" class="w-100">
                    <b-button  variant="primary" size="sm" class="float-left" @click="showModal=false" >
                        Annuler
                    </b-button>
                    <b-button type="submit"  variant="primary" size="sm" class="float-right" @click="handle_agence" >
                        Engregistrer
                    </b-button>
                </div>
            </b-modal>
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

                modalShow: false,
                ville_tmp: '',
                detail_partenaire: null,
                agences: [],

                modification: false,


                pays: [] ,
                villes: [],

                partenaire_form : {
                    name: '',
                    site_web: '',
                    adresse_partenaire: '',
                    email_partenaire:'',
                    type_partenaire:'',
                    description: '',
                    numero_tel: '',
                    logo : [],
                    etat: null,
                },

                agence_form: {
                    libelle: '',
                    contact: '',
                    adresse: '',
                    email: '',
                    slug: '',
                    pays: null,
                    ville: null,
                    partenaire: null,
                },

                showModal: false,
               // Config Modal
                titleModal: 'Modification',
                headerBgVariant: 'dark',
                headerTextVariant: 'light',
                bodyBgVariant: 'light',
                bodyTextVariant: 'dark',
                footerBgVariant: 'warning',
                footerTextVariant: 'dark'
            }
        },

        mounted() {
            this.charger_info_partenaire();
            this.load_countries();
        },

        methods: {

            charger_info_partenaire() {

                // On initialise le formulaire
                this.partenaire_form.name = this.partenaire.nom_partenaire;
                this.partenaire_form.site_web = this.partenaire.site_web;
                this.partenaire_form.adresse_partenaire = this.partenaire.adresse;
                this.partenaire_form.description = this.partenaire.description;
                this.partenaire_form.numero_tel = this.partenaire.numero_tel;
                this.partenaire_form.type_partenaire = this.partenaire.type_partenaire;
                this.partenaire_form.logo = this.partenaire.logo;
                this.partenaire_form.etat = this.partenaire.etat;


                // On recupère le partenaire avec toutes ses relations
                axios.get('/api/partenaire/'+this.partenaire.slug)
                    .then( (response) => {
                        this.detail_partenaire = response.data.content;

                        // Calcul du type du partenaire
                        this.type_partenaire = this.detail_partenaire.type == 'Entreprise' ?  true : false;

                        this.agences = [];
                        this.detail_partenaire.agences.forEach( (agence) => {
                            this.ville_id(agence.ville).then(response => {
                                this.agences.push({
                                    libelle: agence.libelle,
                                    contact: agence.contact,
                                    adresse: agence.adresse,
                                    email: agence.email,
                                    ville: response,
                                    slug: agence.slug,
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

            update_agence_modal(agence) {

                this.agence_form.libelle = agence.libelle;
                this.agence_form.contact = agence.contact;
                this.agence_form.adresse = agence.adresse;
                this.agence_form.email = agence.email;
                this.agence_form.slug = agence.slug;
                this.agence_form.pays = agence.pays;
                this.agence_form.ville = agence.ville;
                this.agence_form.partenaire= this.detail_partenaire.id;

                this.modification =  true ;

                this.showModal = !this.showModal;
                this.titleModal = "Modification de l'agence";
            },

            delete_agence(slug) {
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
                        axios.delete('/api/agence/' + slug)
                            .then( (response) => {
                                swal.fire(
                                    'Supprimé!',
                                    'L\'agence a été supprimé.',
                                    'success'
                                );
                                this.charger_info_partenaire();
                            })
                    }
                })
            },


            add_agence_modal() {
                this.agence_form.libelle = '';
                this.agence_form.contact = '';
                this.agence_form.adresse = '';
                this.agence_form.email = '';
                this.agence_form.slug = '';
                this.agence_form.pays = null;
                this.agence_form.ville = null;
                this.agence_form.partenaire= this.detail_partenaire.id;


                this.showModal = !this.showModal;
                this.titleModal = "Ajout d'une agence";
                this.modification = false;
            },

            onSubmit(){
            },

            load_countries() {
                axios.get('/api/pays')
                    .then((response) =>{
                        response.data.content.forEach( (country) => {
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
                axios.get('/api/ville-pays/'+this.agence_form.pays)
                    .then((response) =>{
                        response.data.content.forEach( (city) => {
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

            handle_agence(){
                if (this.modification) {
                    // Nous sommes dans le cas de modification d'une agence
                    axios.put('/api/agence/' + this.agence_form.slug, this.agence_form )
                        .then((response) => {
                            swal.fire(
                                'Modifié!',
                                'L\'agence a été modifié.',
                                'success'
                            );
                            this.charger_info_partenaire();
                            this.showModal = false ;
                        })

                } else {
                    // Nous sommes dans le cas de modification d'une agence

                    axios.post('/api/agence/', this.agence_form )
                        .then((response) => {
                            swal.fire(
                                'Ajout!',
                                'L\'agence a été ajouté.',
                                'success'
                            );
                            this.charger_info_partenaire();
                            this.showModal = false ;
                        })
                }
            }

        },
    }
</script>

<style scoped>

</style>