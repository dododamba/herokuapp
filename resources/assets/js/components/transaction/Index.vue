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
                <list-transaction></list-transaction>
            </template>

            <template v-if="detail">
                <detail-transaction :transaction=transaction_detail></detail-transaction>
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
                transaction_detail:null,
                titre: "Liste des transaction",
            }
        },
        mounted() {

            this.$root.$on('detail-transaction', (transaction) => {
                this.onDetail(transaction);
            });

        },
        methods: {

            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste des transactions";
            },


            onDetail(transaction) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail du transaction : "+" " +transaction.titre;
                this.transaction_detail= transaction;
            }
        }
    }
</script>

<style scoped>

</style>