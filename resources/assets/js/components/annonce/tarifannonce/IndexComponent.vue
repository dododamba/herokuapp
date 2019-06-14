<template>
    <div class="card card-default">
        <div class="card-header bg-primary text-white" v-if="list"><h1 class="display-4"> Les positions disponible
            <button class="btn btn-success btn-sm pull-right"  v-on:click="onCreate()" variant="outline-success" >
                <i class="fa fa-plus "></i></button></h1>

        </div>

        <div class="card-header bg-primary text-white" v-if="!list"><h1 class="display-4"> Créer une position
            <button class="btn btn-success btn-sm pull-right"  v-on:click="onList()" variant="outline-success" >
                <i class="fa fa-arrow-left"></i></button></h1>


        </div>


        <div class="">

            <hr>
        </div>
        <div class="card-body">
            <template v-if="list">
                <position-list></position-list>
            </template>

            <template v-if="create">
                <positioncreate></positioncreate>
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
                position_detail:null,
                titre: "Liste des positions",
            }
        },
        mounted() {
            this.$root.$on('', () => {
                this.create = false;
                this.list =true;
                this.detail = true;
                this.titre=" Détail du position : "+" " +position.nom_position;
                this.position_detail= position;
            })
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.detail = false;
                this.titre = "Création d'une position Annonce";
            },
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.titre = "Liste des Positions";
            },
        }
    }
</script>

