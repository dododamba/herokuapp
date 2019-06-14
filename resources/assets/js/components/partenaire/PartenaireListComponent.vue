<template>
    <div class="row">
        <div class="col-12" v-if="list_partenaire != null">

            <!-- User Interface controls -->
            <b-row class="toolbar">
                <b-col md="5" style="text-align: left">
                    <b-row class="my-1">
                        <b-col sm="7" style="text-align: right">
                            <label >Nombre d'éléments par page</label>
                        </b-col>
                        <b-col sm="3" >
                            <b-form-select v-model="perPage" :options="pageOptions" size="sm"></b-form-select>
                        </b-col>
                    </b-row>
                </b-col>
                <b-col md="7" style="text-align: right">
                    <b-row>
                        <b-col md="7" style="text-align: right">
                            <b-form-group label="Recherche par mot clé" >
                            </b-form-group>
                        </b-col>
                        <b-col md="5">
                            <b-form-input v-model="filter" placeholder="Saisir ici"></b-form-input>
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
            <!-- Main table element -->
            <b-table
                stacked="md"
                :items="list_partenaire"
                :fields="fields"
                :current-page="currentPage"
                :per-page="perPage"
                :filter="filter"
                :sort-by.sync="sortBy"
                :sort-desc.sync="sortDesc"
                :sort-direction="sortDirection"
                @filtered="onFiltered"
                head-variant="dark"
                class="table table-striped responsive table-bordered"
            >

                <template slot="status" slot-scope="row">
                    <p v-if="row.item.is_actived" style="color: #1c7430"> <b>Activé</b></p>
                    <p v-else style="color: #772510"> <b>Désactivé</b></p>
                </template>

                <template slot="nom_partenaire" slot-scope="row">
                    <b>{{ row.value}}</b>
                </template>

                <template slot="type_partenaire" slot-scope="row">
                    <b>{{ row.value}}</b>
                </template>

                <template slot="site_web" slot-scope="row">
                    <b>{{ row.value}}</b>
                </template>

                <template slot="is_actived" slot-scope="row">
                    <b-button size="sm" variant="danger" v-if="row.value"
                              v-b-tooltip.hover title="Désactiver le compte du partenaire" @click="desactiver(row.item)">
                        Désactiver
                    </b-button>
                    <b-button size="sm" variant="success" v-else
                              v-b-tooltip.hover title="Activer le compte du partenaire" @click="activer(row.item)">
                        Activer
                    </b-button>
                </template>

                <template slot="actions" slot-scope="row">
                    <b-button pill variant="info" size="sm" v-b-tooltip.hover title="Détail du partenaire"  @click="onDetail(row.item)">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                    </b-button>
                    <b-button pill variant="warning" size="sm" v-b-tooltip.hover title="Modifier" @click="onUpdate(row.item)">
                        <i class="fa fa-pencil-square-o"></i>
                    </b-button>
                    <b-button  pill variant="danger" size="sm" v-b-tooltip.hover title="Supprimer"
                               @click="removePartenaire(row.item)">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </b-button>
                </template>
            </b-table>
            <b-row>
                <hr>
                <b-col class="my-1">
                    <b-pagination
                            v-model="currentPage"
                            :total-rows="totalRows"
                            :per-page="perPage"
                            first-text="Début"
                            prev-text="Précédent"
                            next-text="Suivant"
                            last-text="Fin"
                            class="mt-4"
                    ></b-pagination>

                </b-col>
            </b-row>

        </div>
        <template v-if="list_partenaire == null" class="row">
            <b-alert show variant="danger">Pas de partenaire enregistré pour le moment</b-alert>
        </template>
    </div>
</template>

<script>

    import VueAxios from 'vue-axios';
    import axios from 'axios';
    Vue.use(VueAxios, axios);

    export default {
        data(){
            return {
                list_partenaire : [],
                partenaire: '',



                // Les entêtes du data table
                fields: [
                    { key: 'status', label: 'Status', sortable: true  },
                    { key: 'nom_partenaire', label: 'Nom Partenaire', sortable: true, sortDirection: 'desc' },
                    { key: 'type_partenaire', label: 'Type', sortable: true},
                    { key: 'site_web', label: 'Site Web' },
                    { key: 'is_actived', label: 'Activation', sortable: true },
                    { key: 'actions', label: 'Actions'}
                ],


                // La pagination
                totalRows: 1,
                currentPage: 1,
                perPage: 10,
                pageOptions: [5, 10, 15],
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
            }
        },
        mounted() {
            this.all_partenaire();
        },

        methods: {

            activer(partenaire) {

                swal.fire({
                    title: 'êtes-vous sûr de vouloir Activer ce compte?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, Activer!',
                    cancelButtonText:'Non, annuler'
                }).then((result) => {
                    if (result.value) {
                        axios.get('/api/partenaire/activate/'+partenaire.slug)
                            .then( (response) => {
                                swal.fire(
                                    'Activation!',
                                    'Le Compte a été activé.',
                                    'success'
                                );
                                this.all_partenaire();
                            })
                    }
                })

            },

            desactiver(partenaire) {

                swal.fire({
                    title: 'êtes-vous sûr de vouloir Désactiver ce compte?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, Désactiver!',
                    cancelButtonText:'Non, annuler'
                }).then((result) => {
                    if (result.value) {
                        axios.get('/api/partenaire/desactivate/'+partenaire.slug)
                            .then( (response) => {
                                swal.fire(
                                    'Désactivation!',
                                    'Le partenaire a été désactivé.',
                                    'success'
                                );
                                this.all_partenaire();
                            })
                    }
                })
            },

            removePartenaire(part) {
                swal.fire({
                    title: 'êtes-vous sûr de vouloir supprimer?',
                    text: "Vous ne pourrez plus le récuperer! ",
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
                        this.totalRows = this.list_partenaire.length;
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
            },

            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            }

        },
    }
</script>