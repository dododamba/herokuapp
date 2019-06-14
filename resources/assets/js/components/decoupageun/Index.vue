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
                    <decoupageun-list></decoupageun-list>
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
                decoupageun_detail:null,
                decoupageun_update: null ,
                titre: "Liste ",
            }
        },
        mounted() {
            this.$root.$on('decoupageun-update' , (decoupageun) => {
                this.onUpdate(decoupageun);
            });
        },
        methods: {
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste ";
            },

            onUpdate(decoupageun) {
                this.create = false;
                this.list =false;
                this.update =true;
                this.detail = false;
                this.titre = "Modification du decoupageun : ";
                this.decoupageun_update = decoupageun;
            },

            onDetail(decoupageun) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail du decoupageun : ";
                this.decoupageun_detail= decoupageun;
            }
        }
    }
</script>

<style scoped>

</style>