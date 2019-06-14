<template>
    <b-card>
        <b-card-title>
            <div class="row">
                <div class="col-6">
                    <h4> {{titre}}</h4>
                </div>
                <div class="col-6" style="text-align: right;">
                    <div v-if="list">
                        <b-button variant="outline-success" v-on:click="onCreate()" size="sm">+ Article</b-button>
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
                <list-article></list-article>
            </template>

            <template v-if="detail">
                <detail-article :article=article_detail></detail-article>
            </template>

            <template v-if="create">
                <create-article></create-article>
            </template>

            <template v-if="update">
                <update-article :article=article_update></update-article>
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
                article_detail:null,
                article_update: null ,
                titre: "Liste des articles",
            }
        },
        mounted() {

            /*
             *  On écoute les événements pour les modifications et le détail venant
             *  du component listPartenaire
             */
            this.$root.$on('detail-article', (article) => {
                this.onDetail(article);
            });

            this.$root.$on('update-article' , (article) => {
                this.onUpdate(article);
            });
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.detail = false;
                this.update = false;
                this.titre = "Création d'un article";
            },
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste des articles";
            },

            onUpdate(article) {
                this.create = false;
                this.list =false;
                this.update =true;
                this.detail = false;
                this.titre = "Modification du article : " + " " + article.titre;
                this.article_update = article;
            },

            onDetail(article) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail du article : "+" " +article.titre;
                this.article_detail= article;
            }
        }
    }
</script>

<style scoped>

</style>