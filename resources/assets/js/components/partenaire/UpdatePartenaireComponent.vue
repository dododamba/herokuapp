<template>
    <div>
        <form @submit.prevent="onSubmit" enctype="multipart/form-data">
            <div class="card card-default">
                <div class="card-header bg-primary">Informations Générales </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-9">
                            <div class="row">
                                <b-form-group label="Nom Partenaire :"  label-for="name" class="col-6">
                                    <b-form-input size="sm" id="name"  v-model="partenaire_form.name" type="text" required></b-form-input>
                                </b-form-group>
                                <b-form-group label="Adresse du partenaire:"  label-for="adresse" class="col-6">
                                    <b-form-input size="sm" id="adresse"  v-model="partenaire_form.adresse_partenaire" type="text" required></b-form-input>
                                </b-form-group>
                            </div>

                            <div class="row">
                                <b-form-group label="Numéro Téléphone :"  label-for="numero_tel" class="col-6">
                                    <b-form-input size="sm" id="numero_tel"  v-model="partenaire_form.numero_tel" type="text"></b-form-input>
                                </b-form-group>


                                <b-form-group  class="col-6">
                                    <label for="typePartenaire"> Type du partenaire: {{partenaire_form.type_partenaire}}</label>
                                    <b-form-select id="typePartenaire" v-model="partenaire_form.type_partenaire" :options="liste_type">
                                        <template slot="first">
                                            <option :value="null" disabled> --Changer le type du partenaire--</option>
                                        </template>
                                    </b-form-select>

                                </b-form-group>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <b-form-group label="Description du partenaire :"  label-for="description" >
                                        <b-form-textarea  id="description"  v-model="partenaire_form.description" ></b-form-textarea>
                                    </b-form-group>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <b-form-group label="Site web du partenaire :"  label-for="site_web">
                                        <b-form-input size="sm" id="site_web"  v-model="partenaire_form.site_web" type="text"></b-form-input>
                                    </b-form-group>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <imageComponent :logo="detail_partenaire.logo"></imageComponent>
                        </div>
                    </div>


                    <!-- Si ce n'est pas un partenaire de type Entreprise alors -->
                    <template v-if="!isEntreprise">
                        <h4> Information agence principale </h4>
                        <hr>
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
                            <b-form-group class="col-6">
                                <label > Pays agence principale</label>
                                <b-form-select v-model="agence_form.pays" :options="pays" v-on:input="charger_ville(agence_form.pays)" >
                                    <template slot="first">
                                        <option :value="null" disabled> -- Selectionnez un pays --</option>
                                    </template>
                                </b-form-select>
                            </b-form-group>
                            <b-form-group class="col-6">
                                <label > Ville agence : {{ville_id(detail_partenaire.agence_principale.ville)}}</label>
                                <b-form-select v-model="agence_form.ville" :options="villes">
                                    <template slot="first">
                                        <option :value="null" disabled> -- Selectionnez une ville --</option>
                                    </template>
                                </b-form-select>
                            </b-form-group>
                        </div>
                    </template>


                    <div class="row">
                        <div class="col-3 offset-9">
                            <br> <br>
                            <b-button block type="submit"  variant="success" size="sm" class="float-right" >
                                Engregistrer
                            </b-button>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <!-- les autres agences du partenaire seulement si c'est un partenaire type entreprise -->
           <template v-if="isEntreprise">
               <div class="card">
                   <div class="card-title"> Manager agences du partenaire </div>
                   <div class="card-body">
                       <div style="text-align: right">
                           <b-button variant="outline-success" v-on:click="add_agence_modal()" size="sm">
                               <i class="fa fa-plus"></i> Ajouter Agence
                           </b-button>
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
                                       <td>{{ ville_id(agence.ville)}}</td>
                                       <td>
                                           <b-button pill variant="warning" size="sm" v-b-tooltip.hover title="Modifier"  @click="update_agence_modal(agence)">
                                               <i class="fa fa-pencil-square-o"></i>
                                           </b-button>
                                           <b-button pill variant="danger" size="sm" v-b-tooltip.hover title="Supprimer"
                                              @click="delete_agence(agence)">
                                               <i class="fa fa-trash-o" aria-hidden="true"></i>
                                           </b-button>

                                       </td>
                                   </tr>

                                   </tbody>
                               </table>
                           </div>
                       </div>

                   </div>
               </div>
           </template>
        </form>



        <!-- le modal -->
        <div>
            <b-modal v-model="showModal" :title="titleModal" :header-bg-variant="headerBgVariant"
                    :header-text-variant="headerTextVariant" :body-bg-variant="bodyBgVariant"
                    :body-text-variant="bodyTextVariant" :footer-bg-variant="footerBgVariant"
                     :footer-text-variant="footerTextVariant" size="lg">
                <b-container fluid>
                    <div>
                        <form @submit.prevent="handle_agence">
                        <b-row class="text-center">
                            <b-form-group class="col-6" label="Nom agence" label-for="libelle_agence">
                                <b-form-input size="sm" type="text" v-model="agence_form.libelle"> </b-form-input>
                                <p v-if="errors_agence.libelle" style="color: red">
                                    {{errors_agence.libelle[0]}}
                                </p>
                            </b-form-group>

                            <b-form-group class="col-6" label="Contact agence" label-for="contact_agence">
                                <b-form-input size="sm" type="text" v-model="agence_form.contact"> </b-form-input>
                                <p v-if="errors_agence.contact" style="color: red">
                                    {{errors_agence.contact[0]}}
                                </p>
                            </b-form-group>

                        </b-row>
                        <div class="row">
                            <b-form-group class="col-6" label="Adresse" label-for="adresse_agence">
                                <b-form-input size="sm" type="text" v-model="agence_form.adresse"> </b-form-input>
                                <p v-if="errors_agence.adresse" style="color: red">
                                    {{errors_agence.adresse[0]}}
                                </p>
                            </b-form-group>

                            <b-form-group class="col-6" label="Email de l'agence" label-for="email_agence">
                                <b-form-input size="sm" type="email" v-model="agence_form.email"> </b-form-input>
                                <p v-if="errors_agence.email" style="color: red">
                                    {{errors_agence.email[0]}}
                                </p>
                            </b-form-group>

                        </div>
                        <div class="row">
                            <b-form-group class="col-6">
                                <label >Pays agence</label>
                                <b-form-select v-model="agence_form.pays" :options="pays" v-on:input="charger_ville(agence_form.pays)" >
                                    <template slot="first">
                                        <option :value="null" disabled> -- Choisir --</option>
                                    </template>
                                </b-form-select>
                            </b-form-group>
                            <b-form-group class="col-6">
                                <label v-if="modification"> Ville Actuelle : {{ville_id(ville_tmp)}}</label>
                                <label v-if="!modification"> Ville agence : </label>
                                <b-form-select v-model="agence_form.ville" :options="villes" required>
                                    <template slot="default">
                                        <option :value="null" disabled> --Choisir--</option>
                                    </template>
                                </b-form-select>
                                <p v-if="errors_agence.ville" style="color: red">
                                    {{errors_agence.ville[0]}}
                                </p>
                            </b-form-group>
                        </div>
                    </form>

                    </div>
                </b-container>

                    <b-row slot="modal-footer" class="w-100" fluid>
                        <div class="col-4"><b-button block variant="danger" @click="showModal=false" >
                            Annuler
                        </b-button></div>
                        <div class="col-3"></div>
                        <div class="col-4"><b-button type="submit" block variant="success" @click="handle_agence" >
                            Engregistrer
                        </b-button> </div>
                        <div class="col-1"></div>
                    </b-row>
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
                isEntreprise: false,

                pays: [] ,
                all_cities: [],
                villes: [],

                partenaire_form : {
                    name: '',
                    site_web: '',
                    adresse_partenaire: '',
                    email_partenaire:'',
                    type_partenaire:'',
                    description: '',
                    numero_tel: '',
                    logo : null,
                    etat: null,
                },


                liste_type: [
                    { value: 'Entreprise', text: 'Entreprise' },
                    { value: 'Particulier', text: 'Particulier' }
                ],

                errors_agence: [],
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


                agence_principale: null,

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
            this.load_all_cities();

            // On écoute le composant image
            this.$root.$on('image' , (image_loaded) => {
                this.put_logo(image_loaded);
            });
        },

        methods: {

            put_logo($image) {
                this.partenaire_form.logo = $image;
            },

            charger_info_partenaire() {

                // On recupère le partenaire avec toutes ses relations
                axios.get('/api/partenaire/'+this.partenaire.slug)
                    .then( (response) => {
                        this.detail_partenaire = response.data.content;

                        // Agn=ence principale
                        this.agence_principale = this.detail_partenaire.agence_principale;


                        // On initialise le formulaire
                        this.partenaire_form.name = this.detail_partenaire.nom;
                        this.partenaire_form.site_web = this.detail_partenaire.site_web;
                        this.partenaire_form.adresse_partenaire = this.detail_partenaire.adresse;
                        this.partenaire_form.description = this.detail_partenaire.description;
                        this.partenaire_form.numero_tel = this.detail_partenaire.numero_tel;
                        this.partenaire_form.type_partenaire = this.detail_partenaire.type;
                        this.partenaire_form.logo = this.detail_partenaire.logo;
                        this.partenaire_form.etat = this.detail_partenaire.etat;

                        // Calcul du type du partenaire
                        this.isEntreprise = (this.detail_partenaire.type === 'Entreprise')?true:false;

                        this.agences = [];

                        if (this.isEntreprise) { // Est-ce un partenaire de type Entreprise
                            // Dans ce cas charger ses agences

                            this.detail_partenaire.agences.forEach( (agence) => {
                                    this.agences.push({
                                        libelle: agence.libelle,
                                        contact: agence.contact,
                                        adresse: agence.adresse,
                                        email: agence.email,
                                        ville: this.ville_id(agence.ville),
                                        id_ville: agence.ville,
                                        slug: agence.slug,
                                        id: agence.id,
                                    });
                            });

                        } else {
                            // On intialise le formulaire agence principale
                            this.agence_form.libelle = this.agence_principale.libelle;
                            this.agence_form.contact = this.agence_principale.contact;
                            this.agence_form.adresse = this.agence_principale.adresse;
                            this.agence_form.email = this.agence_principale.email;
                            this.agence_form.ville = this.agence_principale.ville;
                        }

                        // On charger la ville à partir de l'ID
                        this.ville_principale = this.ville_id(this.detail_partenaire.agence_principale.ville)                    })
                    .catch(error => { console.log(error)})
            },

            update_agence_modal(agence) {

                this.errors_agence = [];
                this.agence_form.libelle = agence.libelle;
                this.agence_form.contact = agence.contact;
                this.agence_form.adresse = agence.adresse;
                this.agence_form.email = agence.email;
                this.agence_form.slug = agence.slug;
                this.agence_form.pays = null;
                this.agence_form.ville = agence.id_ville;
                this.agence_form.partenaire= this.detail_partenaire.id;

                this.ville_tmp = agence.ville;
                this.modification =  true ;

                this.showModal = !this.showModal;
                this.titleModal = "Modification de l'agence";
            },

            delete_agence(agence) {

                // On ne doit pas supprimer l'agence principale
                if (agence.id == this.detail_partenaire.agence_principale.id) {
                    swal.fire({
                        type: 'error',
                        title: 'Oops !!!!!',
                        text: 'Vous ne pouvez pas supprimer l\'agence principale !',
                    })
                }else {
                    swal.fire({
                        title: 'êtes-vous sûr de vouloir supprimer cette agence?',
                        text: "Vous ne pourrez plus le récuperer! ",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui, Supprimer!',
                        cancelButtonText:'Non, annuler'
                    }).then((result) => {
                        if (result.value) {
                            axios.delete('/api/agence/' + agence.slug)
                                .then( (response) => {
                                    swal.fire({
                                        title: 'Supprimé!',
                                        type: 'success',
                                        texte: 'L\'agence a été supprimé.',
                                    });
                                    this.charger_info_partenaire();
                                })
                        }
                    })
                }
            },


            add_agence_modal() {
                this.errors_agence = [];

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

            partenaireChanged() {
                if (this.partenaire_form.name === this.detail_partenaire.nom &&
                    this.partenaire_form.site_web === this.detail_partenaire.site_web &&
                    this.partenaire_form.adresse_partenaire === this.detail_partenaire.adresse &&
                    this.partenaire_form.description === this.detail_partenaire.description &&
                    this.partenaire_form.numero_tel === this.detail_partenaire.numero_tel &&
                    this.partenaire_form.type_partenaire === this.detail_partenaire.type &&
                    this.partenaire_form.logo === this.detail_partenaire.logo &&
                    this.partenaire_form.etat === this.detail_partenaire.etat) {
                    return false

                } else {
                    return true

                }
            },

            agenceChanged() {

               if (this.agence_principale.libelle === this.agence_form.libelle &&
                    this.agence_principale.contact === this.agence_form.contact &&
                    this.agence_principale.adresse === this.agence_form.adresse &&
                    this.agence_principale.email === this.agence_form.email &&
                    this.agence_principale.ville === this.agence_form.ville) {
                   return false;

               } else {
                   return true;
               }
            },

            onSubmit(){

                let isChanged = false;
                // On teste s'il y a eu changement

                if(this.partenaireChanged()){
                    axios.put('/api/partenaire/' + this.detail_partenaire.slug, this.partenaire_form)
                        .then((response) => {
                            if (!this.isEntreprise && this.agenceChanged()) {
                                axios.put('/api/agence/' + this.agence_principale.slug, this.agence_principale)
                                    .then((response) => {
                                        toast.fire({
                                            type: 'success',
                                            title: 'Succès',
                                            html: 'Partenaire Modifié avec succès'
                                        });
                                    })
                            } else {
                                toast.fire({
                                    type: 'success',
                                    title: 'Succès',
                                    html: 'Partenaire Modifié avec succès'
                                });
                            }
                            this.charger_info_partenaire();
                        })
                        .catch(err => console.log(err));
                } else {
                    if (!this.isEntreprise && this.agenceChanged()) {
                        axios.put('/api/agence/' + this.agence_principale.slug, this.agence_principale)
                            .then((response) => {
                                toast.fire({
                                    type: 'success',
                                    title: 'Succès',
                                    html: 'Partenaire Modifié avec succès'
                                });
                                this.charger_info_partenaire();
                            })
                    } else {
                        toast.fire({
                            type: 'error',
                            title: 'Attention !',
                            html: 'Vous n\'avez modifié aucune information'
                        });
                    }
                }
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
            charger_ville(id_pays) {
                this.villes = [];
                this.all_cities.forEach( (city) => {
                    if (city.pays_id === id_pays) {
                        this.villes.push({
                            value: city.id,
                            text: city.nom,
                        });
                    }
                });
            },


            ville_id(id_seek){
                let $ville = id_seek;
                this.all_cities.forEach( (city) => {
                    if (city.id === id_seek) {
                        $ville = city.nom;
                    }
                });
                return $ville;
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
                        }).catch(err => console.log(err))

                } else {
                    // Nous sommes dans la création d'une d'une agence

                    axios.post('/api/agence/', this.agence_form )
                        .then((response) => {
                            if (response.data.status === 1 ) {
                                this.showModal = false ;
                                this.charger_info_partenaire();
                                this.errors_agence = [],
                                swal.fire(
                                    'Ajout!',
                                    'L\'agence a été ajouté.',
                                    'success'
                                );
                            } else  {
                                // Erreurs de validation
                                this.errors_agence = response.data.errors;
                                toast.fire({
                                    type: 'error',
                                    title: 'Ajout!',
                                    html : response.data.message
                                });
                            }
                        }).catch(err => console.log(err))
                }
            }

        },
    }
</script>

<style scoped>

</style>