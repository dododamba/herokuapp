<template>

    <div class="card card-default">
                <div class="card-header bg-primary text-white" v-if="list"><h1 class="display-4"> NOS PUBS
                    <button class="btn btn-success btn-sm pull-right"  v-on:click="onCreate()" variant="outline-success" >
                        <i class="fa fa-plus "></i></button></h1>

                </div>

                <div class="card-header bg-primary text-white" v-if="!list"><h1 class="display-4"> Créer une pUb
                    <button class="btn btn-success btn-sm pull-right"  v-on:click="onList()" variant="outline-success" >
                        <i class="fa fa-arrow-left"></i></button></h1>


                </div>


            <div class="">

            <hr>
        </div>
        <div class="card-body">
            <template v-if="list">
                <pub-list></pub-list>
            </template>

            <template v-if="create">
                <createpublicite></createpublicite>
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
                pub_detail: null,
                titre: "Liste des pUb",
            }
        },
        mounted() {
            this.$root.$on('listepub', (pub) => {
                this.create = false;
                this.list = false;
                this.detail = true;
                this.titre = " Détail du pub : " + " " + pub.nom_pub;
                this.pub_detail = pub;
            })
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list = false;
                this.detail = false;
                this.titre = "Création d'une pUb";
            },
            onList() {
                this.create = false;
                this.list = true;
                this.detail = false;
                this.titre = "Liste des pUbs";
            },
        }
    }
</script>

