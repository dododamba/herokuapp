<template>
    <b-card>
        <b-card-title>
            <div class="row">
                <div class="col-6">
                    <h4> {{titre}}</h4>
                </div>
                <div class="col-6" style="text-align: right;">
                    <div v-if="list">
                        <b-button variant="outline-success" v-on:click="onCreate()" size="sm">+ Mode Facturation</b-button>
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
                <list-modefacturation></list-modefacturation>
            </template>

            <template v-if="detail">
                <detail-modefacturation :modefacturation=modefacturation_detail></detail-modefacturation>
            </template>

            <template v-if="create">
                <create-modefacturation></create-modefacturation>
            </template>

            <template v-if="update">
                <update-modefacturation :modefacturation=modefacturation_update></update-modefacturation>
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
                modefacturation_detail:null,
                modefacturation_update: null ,
                titre: "Liste des modefacturations",
            }
        },
        mounted() {

            /*
             *  On écoute les événements pour les modifications et le détail venant
             *  du component listPartenaire
             */
            this.$root.$on('detail-modefacturation', (modefacturation) => {
                this.onDetail(modefacturation);
            });

            this.$root.$on('update-modefacturation' , (modefacturation) => {
                this.onUpdate(modefacturation);
            });
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.detail = false;
                this.update = false;
                this.titre = "Création d'un mode de facturation";
            },
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste des modes de facturations";
            },

            onUpdate(modefacturation) {
                this.create = false;
                this.list =false;
                this.update =true;
                this.detail = false;
                this.titre = "Modification du mode de facturation : " + " " + modefacturation.titre;
                this.modefacturation_update = modefacturation;
            },

            onDetail(modefacturation) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail du mode de facturation : "+" " +modefacturation.titre;
                this.modefacturation_detail= modefacturation;
            }
        }
    }
</script>

<style scoped>

</style>