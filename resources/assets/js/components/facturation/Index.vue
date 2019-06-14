<template>
    <b-card>
        <b-card-title>
            <div class="row">
                <div class="col-6">
                    <h4> {{titre}}</h4>
                </div>
                <div class="col-6" style="text-align: right;">
                    <div v-if="list">
                        <b-button variant="outline-success" v-on:click="onCreate()" size="sm">+ Facturation</b-button>
                    </div>

                    <div v-if="!list">
                        <b-button variant="outline-success" v-on:click="onList()" size="sm"> << Liste</b-button>
                    </div>
                </div>
            </div>
            <hr>
        </b-card-title>
        <b-card-text>
            <template v-if="list">
                <list-facturation></list-facturation>
            </template>

            <template v-if="detail">
                <detail-facturation :facturation=facturation_detail></detail-facturation>
            </template>

            <template v-if="create">
                <create-facturation></create-facturation>
            </template>

            <template v-if="update">
                <update-facturation :facturation=facturation_update></update-facturation>
            </template>

        </b-card-text>
    </b-card>
</template>

<script>
    export default {
        data() {
            return {
                list: true,
                create: false,
                detail: false,
                update: false,
                facturation_detail:null,
                facturation_update: null ,
                titre: "Liste des facturations",
            }
        },
        mounted() {

            /*
             *  On écoute les événements pour les modifications et le détail venant
             *  du component listPartenaire
             */
            this.$root.$on('detail-facturation', (facturation) => {
                this.onDetail(facturation);
            });

            this.$root.$on('update-facturation' , (facturation) => {
                this.onUpdate(facturation);
            });
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.detail = false;
                this.update = false;
                this.titre = "Création d'un facturation";
            },
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste des facturations";
            },

            onUpdate(facturation) {
                this.create = false;
                this.list =false;
                this.update =true;
                this.detail = false;
                this.titre = "Modification du facturation : " + " " + facturation.titre;
                this.facturation_update = facturation;
            },

            onDetail(facturation) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail du facturation : "+" " +facturation.titre;
                this.facturation_detail= facturation;
            }
        }
    }
</script>

<style scoped>

</style>