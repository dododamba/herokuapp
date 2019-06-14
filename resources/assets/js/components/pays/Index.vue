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
                    <pays-list></pays-list>
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
                pays_detail:null,
                pays_update: null ,
                titre: "Liste du pays",
            }
        },
        mounted() {
            this.$root.$on('pays-update' , (pays) => {
                this.onUpdate(pays);
            });
        },
        methods: {
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste des pays ";
            },

            onUpdate(pays) {
                this.create = false;
                this.list =false;
                this.update =true;
                this.detail = false;
                this.titre = "Modification du pays : ";
                this.pays_update = pays;
            },

            onDetail(pays) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail du pays : ";
                this.pays_detail= pays;
            }
        }
    }
</script>

<style scoped>

</style>