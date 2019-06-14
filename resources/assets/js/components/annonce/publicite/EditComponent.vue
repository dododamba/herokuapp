<template>
    <div class="content">
        <form @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="row form-group">
                <div class="col col-md-3"><label class=" form-control-label" for="titre"><strong>Titre</strong> </label>
                </div>
                <div class="col-12 col-md-9"><input class="form-control" id="titre" name="titre"
                                                    placeholder="entête de l'annonce"
                                                    type="text" v-model="titre">
                    <small class="form-text text-muted">saisir le titre</small>
                </div>
            </div>

            <div class="row form-group">
                <div class="col col-md-3"><label class=" form-control-label"
                                                 for="contenue"><strong>Contenue</strong></label></div>
                <div class="col-12 col-md-9"><textarea class="form-control" id="contenue" name="contenue"
                                                       placeholder="Contenue de l'annonce"
                                                       rows="9"
                                                       v-model="contenue"></textarea></div>
            </div>


            <div class="row form-group">
                <div class="col col-md-3"><label class=" form-control-label" for="file-multiple-input"><strong>Ajouter
                    une Image</strong></label></div>
                <div class="col-12 col-md-9"><input class="form-control-file" id="image" multiple="" name="image"
                                                    type="file"></div>
            </div>
            <div class="row form-group">
                <div class="col col-md-3"><label class=" form-control-label" for="text-input"><strong>Date du
                    Debut</strong> </label></div>
                <div class="col-12 col-md-9"><input class="form-control" id="dateDebut" name="dateDebut"
                                                    placeholder="début d'annonce" type="date">
                    <small class="form-text text-muted">début d'annonce</small>
                </div>
            </div>
            <div class="row form-group">
                <div class="col col-md-3"><label class=" form-control-label" for="text-input"><strong>Date Fin</strong>
                </label></div>
                <div class="col-12 col-md-9"><input class="form-control" id="text-input" name="Text"
                                                    placeholder="date de fin de l'annonce" type="date">
                    <small class="form-text text-muted">fin d'annonce</small>
                </div>
            </div>

            <div class="row form-group">
                <div class="col col-md-3"><label class=" form-control-label"><strong>Etat Annonce</strong></label></div>
                <div class="col col-md-9">
                    <div class="form-check">
                        <div class="checkbox">
                            <label class="form-check-label " for="checkbox1">
                                <input class="form-check-input" id="etat1" name="etat" type="checkbox" value="1">Active
                            </label>
                        </div>
                        <div class="checkbox">
                            <label class="form-check-label " for="checkbox2">
                                <input class="form-check-input" id="etat" name="etat2" type="checkbox" value="2">
                                Desactive
                            </label>
                        </div>
                        <div class="checkbox">
                            <label class="form-check-label " for="checkbox3">
                                <input class="form-check-input" id="etat" name="etat3" type="checkbox" value="3"> En
                                Attente
                            </label>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-6">
                    <b-form-select :options="pays" v-model="pays_agence" v-on:input="load_cities">
                        <template slot="first">
                            <option :value="null" disabled> -- Selectionnez le type de l'annonce--</option>
                        </template>
                    </b-form-select>
                </div>
                <div class="form-group col-6">
                    <b-form-select :options="villes" required v-model="ville_agence">
                        <template slot="default">
                            <option :value="null" disabled> -- Selectionnez une ville --</option>
                        </template>
                    </b-form-select>
                </div>
            </div>

            <div class="card-footer">
                <b-button class="btn btn-primary btn-sm" type="submit">
                    <i class="fa fa-dot-circle-o"></i> <strong>Publier</strong>
                </b-button>
                <b-button class="btn btn-danger btn-sm" type="reset">
                    <i class="fa fa-ban"></i> <strong>Annuler</strong>
                </b-button>
            </div>


        </form>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {

        data() {
            return {
                libele: '',
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
                type_annonce: '',
                partenaire: '',
                valider_par: '',

            }
        },

        mounted() {
            this.load_countries();
        },
        methods: {


            onSubmit() {
                var new_annonce = {
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
                    'type_annonce': this.type_annonce,
                    'partenaire': this.partenaire,
                    'valider_par': this.valider_par,

                };

                axios.post('/api/annonce', new_annonce)
                    .then(() => {

                    }).catch((response) => {
                    alert("enregistrer");
                    console.log(response);
                });
            },
        }

    }
</script>

<style scoped>

</style>