<template>
    <b-card>
        <b-card-title>
            <div class="row">
                <div class="col-6">
                    <h4> {{titre}}</h4>
                </div>
                <div class="col-6" style="text-align: right;">
                    <div v-if="list">
                        <b-button variant="outline-success" v-on:click="onCreate()" size="sm">+ Site</b-button>
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
                <list-site></list-site>
            </template>

            <template v-if="detail">
                <detail-site :site=site_detail></detail-site>
            </template>

            <template v-if="create">
                <create-site></create-site>
            </template>

            <template v-if="update">
                <update-site :site=site_update></update-site>
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
                site_detail:null,
                site_update: null ,
                titre: "Liste des sites",
            }
        },
        mounted() {

            /*
             *  On écoute les événements pour les modifications et le détail venant
             *  du component listPartenaire
             */
            this.$root.$on('detail-site', (site) => {
                this.onDetail(site);
            });

            this.$root.$on('update-site' , (site) => {
                this.onUpdate(site);
            });
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.detail = false;
                this.update = false;
                this.titre = "Création d'un site";
            },
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste des sites";
            },

            onUpdate(site) {
                this.create = false;
                this.list =false;
                this.update =true;
                this.detail = false;
                this.titre = "Modification du site : " + " " + site.titre;
                this.site_update = site;
            },

            onDetail(site) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail du site : "+" " +site.titre;
                this.site_detail= site;
            }
        }
    }
</script>

<style scoped>

</style>