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
                <list-note></list-note>
            </template>

            <template v-if="detail">
                <detail-note :note=note_detail></detail-note>
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
                note_detail:null,
                titre: "Liste des note",
            }
        },
        mounted() {

            this.$root.$on('detail-note', (note) => {
                this.onDetail(note);
            });

        },
        methods: {

            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste des notes";
            },


            onDetail(note) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail du note : "+" " +note.titre;
                this.note_detail= note;
            }
        }
    }
</script>

<style scoped>

</style>