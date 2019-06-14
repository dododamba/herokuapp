<template>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <h4> {{titre}}
                        <i v-if="create" class="fa fa-plus" aria-hidden="true"></i>
                        <i v-if="list" class="fa fa-bars" aria-hidden="true"></i>
                    </h4>
                </div>
                <div class="col-6" style="text-align: right;">
                    <div v-if="list">
                        <b-button variant="outline-success" v-on:click="onCreate()" size="sm">Planifier une location </b-button>
                    </div>

                    <div v-if="!list">
                        <b-button variant="outline-success" v-on:click="onList()" size="sm"> ⏮ Retourner à la liste</b-button>
                    </div>
                </div>
            </div>
            <hr>
            <template v-if="list">
                <liste-location></liste-location>
            </template>
            <template v-if="create">
                <create-location :location=location_update></create-location>
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
                location_update:null,
                titre: "Liste des Locations",
            }
        },
        mounted() {
            this.$root.$on('update_location', (location) => {
                this.create = true;
                this.list =false;
                this.titre="Modification du Location ";
                this.location_update= location;
            })
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.titre = "Planification d'une location";
            },
            onList() {
                this.create = false;
                this.list =true;
                this.titre = "Liste des locations";
            },
        }
    }
</script>

<style scoped>

</style>