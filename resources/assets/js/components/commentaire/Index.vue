<template>
    <b-card>
        <b-card-title>
            <div class="row">
                <div class="col-6">
                    <h4> {{titre}}</h4>
                </div>
            </div>
            <hr>
        </b-card-title>
        <b-card-text>
            <template v-if="list">
                <list-commentaire></list-commentaire>
            </template>

            <template v-if="detail">
                <detail-commentaire :commentaire=commentaire_detail></detail-commentaire>
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
                commentaire_detail:null,
                titre: "Liste des commentaire",
            }
        },
        mounted() {

            this.$root.$on('detail-commentaire', (commentaire) => {
                this.onDetail(commentaire);
            });

        },
        methods: {

            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste des Commentaires";
            },


            onDetail(commentaire) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail du Commentaires : "+" " +commentaire.titre;
                this.commentaire_detail= commentaire;
            }
        }
    }
</script>

<style scoped>

</style>