<template>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <h4> {{titre}}
                        <i v-if="create" class="fa fa-plus" aria-hidden="true"></i>
                        <i v-if="update" class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        <i v-if="list" class="fa fa-bars" aria-hidden="true"></i>
                    </h4>
                </div>
                <div class="col-6" style="text-align: right;">
                    <div v-if="list">
                        <b-button variant="outline-success" v-on:click="onCreate()" size="sm">Planifier un voyage </b-button>
                    </div>

                    <div v-if="!list">
                        <b-button variant="outline-success" v-on:click="onList()" size="sm"> << Retourner à la liste</b-button>
                    </div>
                </div>
            </div>
            <hr>
            <template v-if="list">
                <liste-voyage></liste-voyage>
            </template>
            <template v-if="update">
                <update-voyage :voyage=voyage_update></update-voyage>
            </template>
            <template v-if="create">
                <create-voyage></create-voyage>
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
                update: false,
                voyage_update:null,
                titre: "Liste des voyages",
            }
        },
        mounted() {
            this.$root.$on('update-voyage', (voyage) => {
                this.create = false;
                this.list =false;
                this.update = true;
                this.titre=" Modification du voyage ";
                this.voyage_update = voyage;
            })
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.update = false;
                this.titre = "Création d'un voyage";
            },
            onList() {
                this.create = false;
                this.list =true;
                this.update = false;
                this.titre = "Liste des voyages";
            },
        }
    }
</script>

<style scoped>

</style>