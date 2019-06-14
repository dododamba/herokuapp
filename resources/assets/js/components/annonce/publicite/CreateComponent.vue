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
            <form @submit.prevent="onSubmit" enctype="multipart/form-data">


                <div class="row form-group">
                    <div class="col col-md-3"><label for="titre" class=" form-control-label"><strong>Titre</strong> </label></div>
                    <div class="col-12 col-md-9"><input type="text" id="titre" v-model="titre" name="titre" placeholder="entête de l'publicite" class="form-control"><small class="form-text text-muted">saisir le titre</small></div>
                </div>
                <hr>
                <hr>
                <div class="row">
                    <div class="col-auto">
                        <h6 class='text-default'><span>Le Conenue de l'publicite</span> <em class="text-light">(saisir)</em></h6>
                        <VueTrix inputId="contenue" v-model="contenue"/>
                        <p class='text-right text-small' v-bind:class="{'text-danger': hasError }">{{remainingCount}} mots restantes| 1000</p>
                    </div>
                </div>




                <div class="row form-group">
                    <div class="col col-md-3"><label class=" form-control-label"
                                                     for="contenue"><strong>Contenue</strong></label></div>
                    <div class="col-12 col-md-9"><textarea class="form-control" name="hide" style="display:none;"  id="contenue"
                                                           placeholder="Contenue de l'publicite"
                                                           rows="9"></textarea></div>
                </div>

                <div class="row">
                    <div class="form-group col-6">
                        <label class=" form-control-label" for="dateDebut"><strong>Date du Debut</strong> </label>
                        <input class="form-control" id="dateDebut" name="dateDebut" placeholder="début d'publicite"
                               type="date" v-model="dateDebut">
                        <small class="form-text text-muted">début d'publicite</small>

                    </div>
                    <div class="form-group col-6">
                        <label class=" form-control-label" for="dateFin"><strong>Date Fin</strong> </label>
                        <input class="form-control" id="dateFin" name="dateFin" placeholder="date de fin de l'publicite"
                               type="date" v-model="dateFin">
                        <small class="form-text text-muted">fin d'publicite</small>

                    </div>
                </div>


                <div class="row form-group">
                    <div class="col col-md-3"><label class=" form-control-label" for="image"><strong>Ajouter une
                        Image</strong></label></div>
                    <div class="col-12 col-md-9"><input class="form-control-file" id="image" multiple="" name="image"
                                                        type="file"></div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-3"><label class=" form-control-label"><strong>Etat Annonce</strong></label>
                    </div>
                    <div class="col col-md-9">
                        <select class="form-control form-control-sm" id="etat" v-model="etat">
                            <option value="1">Activé</option>
                            <option value="2">Desactivé</option>
                        </select>
                    </div>
                </div>

                <hr>
                <div class="row form-group">
                    <div class="col col-md-3"><label class=" form-control-label"><strong>Etat Annonce</strong></label>
                    </div>
                    <div class="col col-md-9">
                        <select :options="partenaires" class="form-control form-control-sm" id="partenaire"
                                v-model="partenaire"
                                v-on:input="load_partenaire"
                        >
                            <template slot="first">
                                <option :value="null" disabled> -- Choisir le partenaire --</option>
                            </template>
                        </select>
                    </div>
                </div>

                <h2>Information Génerale</h2> <br>


              


                <div class="card-footer">
                    <b-button class="btn btn-success btn-sm" type="submit" v-on:click="onlist()"
                              variant="outline-success">
                        <i class="fa fa-dot-circle-o"></i> <strong>Envoyer</strong>
                    </b-button>
                    <b-button class="btn btn-danger btn-sm" type="reset">
                        <i class="fa fa-ban"></i> <strong>Annuler</strong>
                    </b-button>
                    <b-button class="btn btn-succes btn-sm" type="send">
                        <i class="fa fa-ban"></i> <strong>Payer</strong>
                    </b-button>
                </div>


            </form>


                    </div>

                </div>
            </div>
        </div>



    </div>
</template>


<script>
    import VueTrix from 'vue-trix';
    import axios from 'axios';


    export default {
        components: {
            VueTrix
        },

        data() {
            return {
                titre: '',
                contenue: '',
                dateDebut: '',
                dateFin: '',
                prix: '',
                nombreCaratere: '',
                position: '',
                etat: '',
                date_validation: '',
                utilisateur: '',
                transaction: '',
                image: null,
                type_publicite: '',
                date_creation: '',
                partenaire: '',
                valider_par: '',


            }
        },


        methods: {


            onSubmit() {
                var new_publicite = {
                    'titre': this.titre,
                    'contenue': this.contenue,
                    'dateDebut': this.dateDebut,
                    'dateFin': this.dateFin,
                    'prix': this.prix,
                    'nombreCaratere': this.nombreCaratere,
                    'position': this.position,
                    'etat': this.etat,
                    'date_validation': this.date_validation,
                    'utilisateur': this.utilisateur,
                    'transaction': this.transaction,
                    'image': this.image,
                    'type_publicite': this.type_publicite,
                    'partenaire': this.partenaire,
                    'valider_par': this.valider_par,

                };

                axios.post('/api/annonce', new_publicite)
                    .then(() => {
                        toast.fire({
                            type: 'success',
                            title: 'Record has been added successfully!'
                        })


                    }).catch((response) => {
                    alert("enregistrer");
                    console.log(response);
                });
            },
            load_partenaire() {
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


        }

    }
</script>

<style scoped>

</style>