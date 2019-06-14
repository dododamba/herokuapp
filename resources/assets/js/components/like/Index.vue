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
                <list-like></list-like>
            </template>

            <template v-if="detail">
                <detail-like :like=like_detail></detail-like>
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
                like_detail:null,
                titre: "Liste des like",
            }
        },
        mounted() {

            this.$root.$on('detail-like', (like) => {
                this.onDetail(like);
            });

        },
        methods: {

            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste des likes";
            },


            onDetail(like) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail du like : "+" " +like.titre;
                this.like_detail= like;
            }
        }
    }
</script>

<style scoped>

</style>