<template>
    <div class="card">
        <div>
            <div class="card-title">
                <div class="row">
                    <div class="col-6">
                        <h4> {{titre}}</h4>
                    </div>
                </div>
                <hr>
            </div>
            <div class="card-text">

                <div v-if="list">
                    <ville-list></ville-list>
                </div>


            </div>
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
                update: false,
                ville_detail:null,
                ville_update: null ,
                titre: "Liste du ville",
            }
        },
        mounted() {
            this.$root.$on('ville-update' , (ville) => {
                this.onUpdate(ville);
            });
        },
        methods: {
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste des ville ";
            },

            onUpdate(ville) {
                this.create = false;
                this.list =false;
                this.update =true;
                this.detail = false;
                this.titre = "Modification du ville : ";
                this.ville_update = ville;
            },

            onDetail(ville) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail du ville : ";
                this.ville_detail= ville;
            }
        }
    }
</script>

<style scoped>

</style>