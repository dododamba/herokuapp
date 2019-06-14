<template>
    <div class="card card-default">
        <div class="card-header bg-primary text-white" v-if="list"><h1 class="display-4"> Nos Annonces
            <button class="btn btn-success btn-sm pull-right"  v-on:click="onCreate()" variant="outline-success" >
                <i class="fa fa-plus "></i></button></h1>

        </div>

        <div class="card-header bg-primary text-white" v-if="!list"><h1 class="display-4"> Création Annonce
            <button class="btn btn-success btn-sm pull-right"  v-on:click="onList()" variant="outline-success" >
                <i class="fa fa-arrow-left"></i></button></h1>


        </div>


        <div class="">

            <hr>
        </div>
        <div class="card-body">
            <template v-if="list">
                <annonce-list></annonce-list>
            </template>

            <template v-if="create">
                <createannonce></createannonce>
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
                annonces_detail:null,
                titre: "Liste des Annonces",
            }
        },
        mounted() {
            this.$root.$on('detail-annonces', (annonces) => {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.titre=" Détail du annonces : "+" " +annonces.nom_annonces;
                this.annonces_detail= annonces;
            })
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.detail = false;
                this.titre = "Création d'une Annonce";
            },
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.titre = "Liste des Annonces";
            },
        }
    }
</script>

