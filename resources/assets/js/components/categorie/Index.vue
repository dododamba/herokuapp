<template>
    <b-card>
        <b-card-title>
            <div class="row">
                <div class="col-6">
                    <h4> {{titre}}</h4>
                </div>
                <div class="col-6" style="text-align: right;">
                    <div v-if="list">
                        <b-button variant="outline-success" v-on:click="onCreate()" size="sm">+ Catégorie</b-button>
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
                <list-categorie></list-categorie>
            </template>

            <template v-if="detail">
                <detail-categorie :categorie=categorie_detail></detail-categorie>
            </template>

            <template v-if="create">
                <create-categorie></create-categorie>
            </template>

            <template v-if="update">
                <update-categorie :categorie=categorie_update></update-categorie>
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
                categorie_detail:null,
                categorie_update: null ,
                titre: "Liste des categorie",
            }
        },
        mounted() {

            /*
             *  On écoute les événements pour les modifications et le détail venant
             *  du component listPartenaire
             */
            this.$root.$on('detail-categorie', (categorie) => {
                this.onDetail(categorie);
            });

            this.$root.$on('update-categorie' , (categorie) => {
                this.onUpdate(categorie);
            });
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.detail = false;
                this.update = false;
                this.titre = "Création d'une Categorie";
            },
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste des Categories";
            },

            onUpdate(categorie) {
                this.create = false;
                this.list =false;
                this.update =true;
                this.detail = false;
                this.titre = "Modification du Categorie : " + " " + categorie.titre;
                this.categorie_update = categorie;
            },

            onDetail(categorie) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail du Categorie : "+" " +categorie.titre;
                this.categorie_detail= categorie;
            }
        }
    }
</script>

<style scoped>

</style>