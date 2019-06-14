

<template>
    <b-card title="Céation d'un Type annonce" >
        <b-card-text>
            <form @submit.prevent="onSubmit" enctype="multipart/form-data">
                <b-alert :show="dismissCountDown"
                         variant="success"
                         @dismissed="dismissCountDown=0"
                         @dismiss-count-down="countDownChanged">
                    Type Annonce créé avec succès !!
                </b-alert>


                <div class="row form-group">
                    <div class="col col-md-3"><label for="libelle" class=" form-control-label"><strong>Titre</strong> </label></div>
                    <div class="col-12 col-md-9"><input type="text" id="libelle" v-model="libelle" name="libelle" placeholder="entête de l'annonce" class="form-control"><small class="form-text text-muted">saisir le titre</small></div>
                </div>


                <div class="card-footer">
                    <b-button type="submit" class="btn btn-success btn-sm">
                        <i class="fa fa-dot-circle-o"></i> <strong>Envoyer</strong>
                    </b-button>
                    <b-button type="reset" class="btn btn-danger btn-sm">
                        <i class="fa fa-ban"></i> <strong>Annuler</strong>
                    </b-button>

                </div>


            </form>



        </b-card-text>

    </b-card>
</template>






<script>
    import axios from 'axios';
    export default {

        data() {
            return {
                libelle: ''


            }
        },

        mounted() {
            this.load_countries();
        },
        methods: {



            onSubmit() {
                var new_annonce = {
                    'libelle': this.libelle,


                };

                axios.post('/api/typeannonces', new_annonce)
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
