<template>
    <div class="card">
        <div>
            <div class="card-title">
                <div class="row">
                    <div class="col-6">
                        <h4> {{titre}}</h4>
                    </div>
                    <div class="col-6" style="text-align: right;">
                        <div v-if="list">
                            <b-button variant="outline-success" v-on:click="onCreate()" size="sm">+ Personnel</b-button>
                        </div>

                        <div v-if="!list">
                            <b-button variant="outline-success" v-on:click="onList()" size="sm"> << Retourner</b-button>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
            <div class="card-text">

                <div v-if="list">
                    <personnel></personnel>
                </div>
                <div   v-if="create">
                    <personnel-create></personnel-create>
                </div>

                <div  v-if="update">
                    <personnel-update></personnel-update>
                </div>


            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                list: true,
                create: false,
                detail: false,
                update: false,
                partenaire_detail:null,
                partenaire_update: null ,
                titre: "Liste du personnel",
            }
        },
        mounted() {
            this.$root.$on('personnel-update' , (personnel) => {
                this.onUpdate(personnel);
            });
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.detail = false;
                this.update = false;
                this.titre = "Enregistrement du Personnel";
            },
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste du personnel ";
            },

            onUpdate(partenaire) {
                this.create = false;
                this.list =false;
                this.update =true;
                this.detail = false;
                this.titre = "Modification du partenaire : " + " " + partenaire.nom_partenaire;
                this.partenaire_update = partenaire;
            },

            onDetail(partenaire) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail du partenaire : "+" " +partenaire.nom_partenaire;
                this.partenaire_detail= partenaire;
            }
        }
    }
</script>

<style scoped>

</style>