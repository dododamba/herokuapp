<template>
    <div>
        <b-form @submit="onSubmit">
            <div class="row">
                <div class="col-9">
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="partenaireId"> Partenaire : {{voyage.partenaire}}</label>
                            <select v-model="form_voyage.partenaire" class="form-control" id="partenaireId">
                                <option value="null" disabled selected> -- Changer -- </option>
                                <option :value=partenaire.value v-for="partenaire in partenaires">{{partenaire.text}}</option>
                            </select>
                        </div>
                        <div class="form-group  col-4">
                            <label> Date : {{voyage.date_depart_human}}</label>
                            <date-picker
                                    width="100%"
                                    v-model="form_voyage.date_depart"
                                    type="date" lang="fr" valueType="format" format="DD/MM/YYYY"
                                    :first-day-of-week="1">
                            </date-picker>
                        </div>

                        <div class="form-group col-4">
                            <label> Heure : {{voyage.heure_depart}} </label>
                            <date-picker
                                    width="100%"
                                    v-model="form_voyage.heure_depart" format="HH:mm"
                                    type="time" lang="fr" valueType="format">
                            </date-picker>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="nombre_place" class="form-control-label"> Nombre de place :  {{voyage.nombre_place}}</label>
                            <input type="number"  v-model="form_voyage.nombre_place" class="form-control" id="nombre_place">
                        </div>
                        <div class="form-group col-4">
                            <label for="numero_voyage" class="form-control-label"> Numéro de voyage : {{voyage.numero}} </label>
                            <input v-model="form_voyage.num_voyage" type="text"  class="form-control" id="numero_voyage">
                        </div>
                        <div class="form-group col-4">
                            <label> Durée : {{voyage.duree}} </label>
                            <date-picker
                                    width="100%"
                                    v-model="form_voyage.duree_voyage" format="HH:mm"
                                    type="time" lang="fr" valueType="format">
                            </date-picker>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <imageComponent :logo=image_voyage></imageComponent>
                </div>
            </div>

            <div class="row">
                <div class="form-group  col-3">
                    <label for="pays_depart" class="col-form-label"> Pays de départ</label>
                    <select v-model="form_voyage.pays_depart" id="pays_depart" class="form-control" @click="charger_ville_depart">
                        <option value="null" disabled selected> -- Changer -- </option>
                        <option :value=p.value v-for="p in liste_pays"> {{p.text}}</option>
                    </select>
                </div>
                <div class="form-group  col-3">
                    <label for="ville_depart" class="col-form-label"> Ville de départ : {{voyage.ville_depart}}</label>
                    <select v-model="form_voyage.ville_depart" id="ville_depart" class="form-control">
                        <option value="null" disabled selected> ---- </option>
                        <option :value=v.value v-for="v in liste_ville_depart"> {{v.text}}</option>
                    </select>
                </div>

                <div class="form-group  col-3">
                    <label for="pays_arrive" class="col-form-label"> Pays de départ</label>
                    <select v-model="form_voyage.pays_arrive" id="pays_arrive" class="form-control" @click="charger_ville_arrive">
                        <option value="null" disabled selected> ---- </option>
                        <option :value=p.value v-for="p in liste_pays"> {{p.text}}</option>
                    </select>
                </div>
                <div class="form-group  col-3">
                    <label for="ville_arrivee" class="col-form-label"> Ville arrivée : {{voyage.ville_arrivee}}</label>
                    <select v-model="form_voyage.ville_arrivee" id="ville_arrivee" class="form-control">
                        <option value="null" disabled selected> ---- </option>
                        <option :value=v.value v-for="v in liste_ville_arrivee"> {{v.text}}</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="moyen_transport"> Moyen de transport : {{name_transport(voyage.moyen_transport)}}</label>
                            <select v-model="form_voyage.moyen_transport" class="form-control" id="moyen_transport">
                                <option value="null" disabled selected >-- Changer le moyen de transport --</option>
                                <option :value=mt.value v-for="mt in moyen_transports">{{mt.text}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-12">
                            <label for="description">Description du voyage</label>
                            <textarea v-model="form_voyage.description" class="form-control" id="description" rows="5"></textarea>
                        </div>
                    </div>

                </div>
                <div class="col-6">
                    <table class="table text-center  table-borderless">
                        <thead class="text-uppercase">
                        <tr >
                            <th scope="col">Classes </th>
                            <th scope="col">Prix Enfant (F CFA) </th>
                            <th scope="col">Prix Adulte (F CFA) </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(classe, index) in form_voyage.tarif" :key="index">
                            <td> {{classe.libelle}} </td>
                            <td>
                                <b-form-input size="sm" v-model="form_voyage.tarif[index].prix_enfant" type="number">

                                </b-form-input>
                            </td>
                            <td>
                                <b-form-input size="sm"  v-model="form_voyage.tarif[index].prix_adulte" type="number">

                                </b-form-input>

                            </td>

                        </tr>
                        </tbody>
                    </table>

                    <p v-if="error_tarif" style="color: red">
                        Vous devez renseigner au moins un prix adulte
                    </p>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-block btn-success">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </b-form>
    </div>
</template>


<script>
    import axios from 'axios';
    import DatePicker from 'vue2-datepicker';

    export default {
        props: ['voyage'],
        components: {DatePicker},
        data() {
            return {

                form_voyage: {
                    num_voyage: this.voyage.numero,
                    pays_depart: null,
                    ville_depart: null,
                    pays_arrive: null,
                    ville_arrivee: null,
                    moyen_transport: null,
                    date_depart: this.voyage.date_depart,
                    heure_depart:this.voyage.heure_depart,
                    partenaire: null,
                    description: this.voyage.description,
                    duree: this.voyage.duree,
                    nombre_place: this.voyage.nombre_place,
                    itineraire: this.voyage.itineraire,
                    image: null,

                    tarif: []
                },

                image_voyage: null,
                partenaires: [],
                classes: [],

                error_tarif: false,

                liste_tarif: [],
                liste_ville: [],
                liste_pays: [],
                liste_ville_depart: [],
                liste_ville_arrivee: [],
                moyen_transports: [
                    {text: 'Routier', value: 1},
                    {text: 'Ferroviaire', value: 2},
                    {text: 'Maritime', value: 3},
                    {text: 'Aérien' , value: 4},
                ],

            }
        },
        mounted() {

            this.load_image();
            // Recuperer tous les partenaire de la base de données
            this.recuperer_partenaire();

            // Charger les pays
            this.load_countries();

            //Charger les villes
            this.load_cities();

            // Charger les différents type de classe
            this.load_classe();


            // On écoute le composant image
            this.$root.$on('image' , (image_loaded) => {
                this.change_image(image_loaded);
            });
        },
        methods: {

            has_changed() {
                return (this.form_voyage.num_voyage !==  this.voyage.numero ||
                this.form_voyage.pays_depart !==  null ||
                this.form_voyage.ville_depart !==  null ||
                this.form_voyage.pays_arrive !==  null ||
                this.form_voyage.ville_arrivee !==  null ||
                this.form_voyage.moyen_transport !==  null ||
                this.form_voyage.date_depart !==  this.voyage.date_depart ||
                this.form_voyage.heure_depart !== this.voyage.heure_depart ||
                this.form_voyage.partenaire !==  null ||
                this.form_voyage.description !==  this.voyage.description ||
                this.form_voyage.duree !==  this.voyage.duree ||
                this.form_voyage.nombre_place !==  this.voyage.nombre_place ||
                this.form_voyage.itineraire !==  this.voyage.itineraire ||
                this.form_voyage.image !==  null);
            },

            load_image(){

                if (this.voyage.image !== null) {
                    this.image_voyage = this.voyage.image.nom;
                    this.form_voyage.image = this.voyage.image.nom;
                }
            },

            change_image($image) {
                this.form_voyage.image = $image;
            },
            name_transport(code) {

                switch (code) {
                    case 1 :
                        return 'Routier';
                    case 2 :
                        return 'Ferroviaire';
                    case 3 :
                        return 'Maritime';
                    case 4 :
                        return 'Aérien'
                }
            },
            onSubmit(evt) {
                evt.preventDefault();

                // On doit se rassurer qu'on a saisi au moins un prix adulte
                // pour ce faire on doit parcourir le tableau des tarifs
                var exist = false;
                let i = 0;
                let all_tarif =this.form_voyage.tarif;
                while(i < all_tarif.length && !exist) {
                    if(all_tarif[i].prix_adulte !== null && all_tarif[i].prix_adulte !== '') {
                        exist = true;
                    }
                    i++;
                }

                if(this.has_changed() && exist) {
                    axios.put('/api/voyage/' + this.voyage.slug , this.form_voyage)
                        .then((response) => {
                            toast.fire({
                                type: 'success',
                                title: 'Le voyage a été modifié'
                            });
                        }).catch((response) => {
                        console.log(response);
                    });
                }else {
                    var message_error = '';
                    if(!exist) {
                        this.error_tarif = true;
                        message_error = 'Vous devez renseigner au moins un prix adulte';
                    } else {
                        message_error = 'Vous n\'avez pas effectué de modification';
                    }
                    toast.fire({
                        type: 'error',
                        title: 'Mauvaise mise à jour',
                        html: message_error
                    });
                }


            },

            onRestForm() {
                this.form_voyage = {
                    num_voyage: '',
                    pays_depart: null,
                    ville_depart: null,
                    pays_arrive: null,
                    ville_arrivee: null,
                    moyen_transport: null,
                    date_depart: '',
                    partenaire: null,
                    description: '',

                    tarif: []
                };
            },
            load_classe: function () {
                this.classes = [];
                axios.get('/api/classe')
                    .then((response) => {
                        response.data.content.forEach((classe) => {

                            let trouve = false;
                            this.voyage.tarifs.forEach((t) => {
                                if (t.classe === classe.id) {
                                    this.form_voyage.tarif.push({
                                        id: t.id,
                                        classe: classe.id,
                                        libelle: classe.libelle,
                                        prix_enfant: t.prix_enfant,
                                        prix_adulte: t.prix_adulte
                                    });
                                    trouve = true;
                                }
                            });
                            if (!trouve) {
                                this.form_voyage.tarif.push({
                                    id: null,
                                    classe: classe.id,
                                    libelle: classe.libelle,
                                    prix_enfant: '',
                                    prix_adulte: ''
                                })
                            }
                        });
                    }).catch((response) => {

                });

            },

            // Recupère les partenaire qui ont le droit de faire une planification de voyage
            recuperer_partenaire() {
                let part = [];
                axios.get('/api/partenaire')
                    .then( (response) => {
                        part = response.data.content;

                        // On charge seulement les partenaire qui ont le droit d'effectuer une planification voyage
                        part.forEach((par) => {
                            if (par.type_partenaire === 'Entreprise' && par.is_actived){
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


            // Charger les villes
            load_cities() {
                this.liste_ville = [];
                let villes = [];
                this.axios.get('/api/ville')
                    .then((response) => {
                        villes = response.data.content.data;
                        villes.forEach((ville) => {
                            this.liste_ville.push({
                                id: ville.id,
                                nom: ville.nom,
                                pays_id: ville.pays
                            })
                        })
                    }).catch(err => console.log(err));
            },

            // En fonction du pays de depart
            charger_ville_depart() {
                this.liste_ville_depart = [];
                this.liste_ville.forEach( (city) => {
                    if (city.pays_id === this.form_voyage.pays_depart) {
                        this.liste_ville_depart.push({
                            value: city.id,
                            text: city.nom,
                        });
                    }
                });
            },

            charger_ville_arrive() {
                this.liste_ville_arrivee = [];
                this.liste_ville.forEach( (city) => {
                    if (city.pays_id === this.form_voyage.pays_arrive) {
                        this.liste_ville_arrivee.push({
                            value: city.id,
                            text: city.nom,
                        });
                    }
                });
            },

            load_countries() {
                axios.get('/api/pays')
                    .then((response) =>{
                        response.data.content.pays.data.forEach( (country) => {
                            this.liste_pays.push({
                                value: country.id,
                                text: country.nom,
                            });
                        });

                    }).catch((response) => {
                        console.log(response);
                    }
                );
            },
        }
    }
</script>

