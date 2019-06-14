<template>
        <div class="row">
            <div class="col-md-12" v-if="list_partenaire != null">
                <div class="single-table">
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead class="text-uppercase thead-dark">
                            <tr class="text-white">
                                <th scope="col">Titre</th>
                                <th scope="col">Contenu </th>
                                <th scope="col">Date Debut </th>
                                <th scope="col">Date Fin</th>
                                <th scope="col">Fin</th>
                                <th scope="col">Nombre Caractère</th>
                                <th scope="col">Etat</th>
                                <th scope="col">Date de validation</th>
                                <th scope="col">Date de Création</th>
                                <th scope="col">actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="partenaire in list_partenaire">
                                <td>{{ partenaire.nom_partenaire }}</td>
                                <td>{{ partenaire.type_partenaire }}</td>
                                <td>{{ partenaire.site_web}}</td>
                                <td>{{ partenaire.etat}}</td>
                                <td>
                                    <button v-b-tooltip.hover title="Détail du partenaire" class="mb-1 btn btn-pill btn-info" @click="onDetail(partenaire)">
                                        <i class="mdi mdi-eye"></i>
                                    </button>
                                    <button v-b-tooltip.hover title="Modifier"class="mb-1 btn btn-pill btn-warning" @click="onUpdate(partenaire)">
                                        <i class="mdi mdi-pencil"></i>
                                    </button>
                                    <button  class="mb-1 btn btn-pill btn-danger" v-b-tooltip.hover title="Supprimer"
                                             @click="removePartenaire(partenaire)">
                                        <i class="mdi mdi-delete-forever"></i>
                                    </button>

                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <template v-if="list_partenaire == null" class="row">
                <b-alert show variant="danger">Pas de partenaire enregistré pour le moment</b-alert>
            </template>
        </div>
</template>

<script>
    export default {
        data(){
            return {
                list_partenaire : [],
                partenaire: '',
            }
        },
        mounted() {
            this.all_partenaire();
        },

        methods: {

            removePartenaire(part) {
                swal.fire({
                    title: 'êtes-vous sûr de vouloir supprimer?',
                    text: "Vous ne pourrez plus le récuperer! ",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, Supprimer!',
                    cancelButtonText:'Non, annuler'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/partenaire/'+part.slug)
                            .then( (response) => {
                                swal.fire(
                                    'Supprimé!',
                                    'Le partenaire a été supprimé.',
                                    'success'
                                );
                                this.all_partenaire();
                            })
                    }
                })
            },

            all_partenaire() {
                axios.get('/api/partenaire')
                    .then( (response) => {
                        this.list_partenaire = response.data.content;
                    }).catch( () => {
                    this.list_partenaire = null;
                    console.log(response);
                });
            },

            onDetail(partenaire) {
                this.$root.$emit('detail-partenaire', partenaire );
            },

            onUpdate(partenaire) {
                this.$root.$emit('update-partenaire', partenaire );
            }

        },
    }
</script>

<style scoped>

</style>