<template>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-8" style="text-align: left;">
                    <h4> {{titre}} <i v-if="list" class="fa fa-list" aria-hidden="true"></i></h4>
                </div>
                <div class="col-4" style="text-align: right;">
                    <div v-if="list == true">
                        <b-button variant="outline-success" v-on:click="onCreate()" size="sm">Créer un Partenaire</b-button>
                    </div>

                    <div v-if="list==false">
                        <b-button variant="outline-success" v-on:click="onList()" size="sm"> << Retourner à la liste</b-button>
                    </div>
                </div>
            </div>
            <hr>
            <template v-if="list">
                <partenaire-list></partenaire-list>
            </template>

            <template v-if="detail">
                <detail-partenaire :partenaire=partenaire_detail></detail-partenaire>
            </template>

            <template v-if="create">
                <create-partenaire></create-partenaire>
            </template>

            <template v-if="update">
                <update-partenaire :partenaire=partenaire_update></update-partenaire>
            </template>
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
                titre: "Liste des partenaires",
            }
        },
        mounted() {

            /*
             *  On écoute les événements pour les modifications et le détail venant
             *  du component listPartenaire
             */
            this.$root.$on('detail-partenaire', (partenaire) => {
                this.onDetail(partenaire);
            });

            this.$root.$on('update-partenaire' , (partenaire) => {
                this.onUpdate(partenaire);
            });
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.detail = false;
                this.update = false;
                this.titre = "Création d'un partenaire";

            },

            onList() {
                this.create = false;
                this.detail = false;
                this.update = false;
                this.list =true;

                this.partenaire_detail = null,
                this.partenaire_update = null ,
                this.titre = "Liste des partenaires";
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