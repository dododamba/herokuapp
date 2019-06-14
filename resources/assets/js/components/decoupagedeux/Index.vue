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
                    <decoupagedeux-list></decoupagedeux-list>
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
                decoupagedeux_detail:null,
                decoupagedeux_update: null ,
                titre: "Liste",
            }
        },
        mounted() {
            this.$root.$on('decoupagedeux-update' , (decoupagedeux) => {
                this.onUpdate(decoupagedeux);
            });
        },
        methods: {
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste des decoupagedeux ";
            },

            onUpdate(decoupagedeux) {
                this.create = false;
                this.list =false;
                this.update =true;
                this.detail = false;
                this.titre = "Modification du decoupagedeux : ";
                this.decoupagedeux_update = decoupagedeux;
            },

            onDetail(decoupagedeux) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail du decoupagedeux : ";
                this.decoupagedeux_detail= decoupagedeux;
            }
        }
    }
</script>

<style scoped>

</style>