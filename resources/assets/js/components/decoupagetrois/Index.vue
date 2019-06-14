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
                    <decoupagetrois-list></decoupagetrois-list>
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
                decoupagetrois_detail:null,
                decoupagetrois_update: null ,
                titre: "Liste",
            }
        },
        mounted() {
            this.$root.$on('decoupagetrois-update' , (decoupagetrois) => {
                this.onUpdate(decoupagetrois);
            });
        },
        methods: {
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste";
            },

            onUpdate(decoupagetrois) {
                this.create = false;
                this.list =false;
                this.update =true;
                this.detail = false;
                this.titre = "Modification du decoupagetrois : ";
                this.decoupagetrois_update = decoupagetrois;
            },

            onDetail(decoupagetrois) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail du decoupagetrois : ";
                this.decoupagetrois_detail= decoupagetrois;
            }
        }
    }
</script>

<style scoped>

</style>