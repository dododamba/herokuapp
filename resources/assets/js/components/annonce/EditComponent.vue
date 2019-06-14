<template>
    <div class="content">
        <form @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="row form-group">
                <div class="col col-md-3"><label for="titre" class=" form-control-label"><strong>Titre</strong> </label></div>
                <div class="col-12 col-md-9"><input type="text" id="titre" v-model="titre" name="titre" placeholder="entête de l'annonce" class="form-control"><small class="form-text text-muted">saisir le titre</small></div>
            </div>

            <div class="row form-group">
                <div class="col col-md-3"><label for="contenue" class=" form-control-label"><strong>Contenue</strong></label></div>
                <div class="col-12 col-md-9"><textarea name="contenue" id="contenue" v-model="contenue"  rows="9" placeholder="Contenue de l'annonce" class="form-control"></textarea></div>
            </div>


            <div class="row form-group">
                <div class="col col-md-3"><label for="file-multiple-input" class=" form-control-label"><strong>Ajouter une Image</strong></label></div>
                <div class="col-12 col-md-9"><input type="file" id="image" name="image" multiple="" class="form-control-file"></div>
            </div>
            <div class="row form-group">
                <div class="col col-md-3"><label for="text-input" class=" form-control-label"><strong>Date du Debut</strong> </label></div>
                <div class="col-12 col-md-9"><input type="date" id="dateDebut" name="dateDebut" placeholder="début d'annonce" class="form-control"><small class="form-text text-muted">début d'annonce</small></div>
            </div>
            <div class="row form-group">
                <div class="col col-md-3"><label for="text-input" class=" form-control-label"><strong>Date Fin</strong> </label></div>
                <div class="col-12 col-md-9"><input type="date" id="text-input" name="Text" placeholder="date de fin de l'annonce" class="form-control"><small class="form-text text-muted">fin d'annonce</small></div>
            </div>

            <div class="row form-group">
                <div class="col col-md-3"><label class=" form-control-label"><strong>Etat Annonce</strong></label></div>
                <div class="col col-md-9">
                    <div class="form-check">
                        <div class="checkbox">
                            <label for="checkbox1" class="form-check-label ">
                                <input type="checkbox" id="etat1" name="etat" value="1" class="form-check-input">Active
                            </label>
                        </div>
                        <div class="checkbox">
                            <label for="checkbox2" class="form-check-label ">
                                <input type="checkbox" id="etat" name="etat2" value="2" class="form-check-input"> Desactive
                            </label>
                        </div>
                        <div class="checkbox">
                            <label for="checkbox3" class="form-check-label ">
                                <input type="checkbox" id="etat" name="etat3" value="3" class="form-check-input"> En Attente
                            </label>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-6">
                    <b-form-select v-model="pays_agence" :options="pays" v-on:input="load_cities">
                        <template slot="first">
                            <option :value="null" disabled> -- Selectionnez le type de l'annonce--</option>
                        </template>
                    </b-form-select>
                </div>
                <div class="form-group col-6">
                    <b-form-select v-model="ville_agence" :options="villes" required>
                        <template slot="default">
                            <option :value="null" disabled> -- Selectionnez une ville --</option>
                        </template>
                    </b-form-select>
                </div>
            </div>

            <div class="card-footer">
                <b-button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa fa-dot-circle-o"></i> <strong>Publier</strong>
                </b-button>
                <b-button type="reset" class="btn btn-danger btn-sm">
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
                dateFin:'',
                prix:'',
                nombreCaratere:'',
                position:'',
                etat: '',
                date_validation:'',
                utilisateur:'',
                transaction:'',
                image: null,
                type_annonce:'',
                partenaire:'',
                valider_par:'',

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
                    alert("enregistrer")
                    console.log(response);
                });
            },
        }

    }
</script>

<style scoped>

</style>