<template>
    <div class="row">
        <div class="col-12" v-if="liste_locations != null">

            <!-- User Interface controls -->
            <b-row class="toolbar">
                <b-col md="5" style="text-align: left">
                    <b-row class="my-1">
                        <b-col sm="7" style="text-align: right">
                            <label >Nombre d'éléments par page</label>
                        </b-col>
                        <b-col sm="3" style="text-align: left">
                            <b-form-select v-model="perPage" :options="pageOptions" size="sm"></b-form-select>
                        </b-col>
                    </b-row>
                </b-col>
                <b-col md="7" style="text-align: right">
                    <b-row>
                        <b-col md="7" style="text-align: right">
                            <b-form-group label="Recherche" >
                            </b-form-group>
                        </b-col>
                        <b-col md="5">
                            <b-form-input v-model="filter" placeholder="Saisir ici"></b-form-input>
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
            <b-table
                    stacked="md"
                    :items="liste_locations"
                    :fields="fields"
                    :current-page="currentPage"
                    :per-page="perPage"
                    :filter="filter"
                    :sort-by.sync="sortBy"
                    :sort-desc.sync="sortDesc"
                    :sort-direction="sortDirection"
                    @filtered="onFiltered"
                    class="table responsive table-bordered"
            >
                <template slot="get_partenaire" slot-scope="row">
                    {{ row.value.nom_partenaire}}
                </template>

                <template slot="get_ville" slot-scope="row">
                    {{ row.value.nom}}
                </template>

                <template slot="titre" slot-scope="row">
                    {{ row.value}}
                </template>

                <template slot="date_debut_human" slot-scope="row">
                    {{ row.value}}
                </template>

                <template slot="date_fin_human" slot-scope="row">
                    {{ row.value}}
                </template>

                <template slot="etat" slot-scope="row">
                    {{ libelle_etat(row.value)}}
                </template>

                <template slot="actions" slot-scope="row">
                    <b-button pill variant="info" v-b-tooltip.hover title="Détail du voyage" size="sm" @click="onShowDetail(row.item)">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                    </b-button>
                    <b-button pill variant="warning" size="sm"  v-b-tooltip.hover title="Modifier" @click="updateLocation(row.item)">
                        <i class="fa fa-pencil-square-o"></i>
                    </b-button>
                    <b-button pill variant="danger" size="sm"  v-b-tooltip.hover title="Supprimer"
                              @click="removeLocation(row.item)">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </b-button>
                </template>
            </b-table>
            <b-row>
                <hr>
                <div class="offset-8 col-4" style="text-align: right">
                    <b-pagination
                            v-model="currentPage"
                            :total-rows="totalRows"
                            :per-page="perPage"
                            first-text="⏮"
                            prev-text="⏪"
                            next-text="⏩"
                            last-text="⏭"
                            class="mt-4"
                    ></b-pagination>

                </div>
            </b-row>
        </div>
        <template v-if="liste_locations==null" class="row">
            <b-alert show variant="danger" class="col-12">Pas de Voyage enregistré pour le moment</b-alert>
        </template>

        <!-- le modal details -->
        <div>
            <b-modal  v-model="showModalDetail"
                      title="Détail du voyage"
                      :header-bg-variant="headerBgVariant"
                      :header-text-variant="headerTextVariant"
                      :body-bg-variant="bodyBgVariant"
                      :body-text-variant="bodyTextVariant"
                      :footer-bg-variant="footerBgVariant"
                      :footer-text-variant="footerTextVariant"
                      size="lg">
                <b-row>
                    <div class="col-6">
                        <b>Nom du partenaire: </b> {{location_detail.partenaire}}
                        <hr>
                        <b>Titre: </b> {{location_detail.titre}}
                        <hr>
                        <b>Début de disponibilité : </b> {{location_detail.date_debut_human}}
                        <hr>
                        <b>Fin de disponibilité : </b> {{location_detail.date_fin_human}}
                        <hr>
                    </div>
                    <div class="col-6">
                        <b>Description : </b>
                        <hr>
                        {{location_detail.description}}
                    </div>
                </b-row>
                <b-row>
                </b-row>

                <div slot="modal-footer" class="w-100">
                    <b-button  variant="danger" size="sm" class="float-left" @click="showModalDetail=false" >
                        Fermer
                    </b-button>
                    <b-button type="submit"  variant="success" size="sm" class="float-right" @click="change_state(location_detail.slug, location_detail.etat)" >
                        {{button_message}}
                    </b-button>
                </div>
            </b-modal>
        </div>
    </div>
</template>

<script>

    import VueAxios from 'vue-axios';
    import axios from 'axios';
    Vue.use(VueAxios, axios);

    export default {
        data(){
            return {
                liste_locations : null,


                showModalDetail: false,

                // Config Modal
                headerBgVariant: 'dark',
                headerTextVariant: 'light',
                bodyBgVariant: 'light',
                bodyTextVariant: 'dark',
                footerBgVariant: 'warning',
                footerTextVariant: 'dark',

                liste_classe: null,

                // Voyage à détailler
                location_detail: '',
                button_message: '',

                fields: [
                    {key: 'get_partenaire', label: 'partenaire',  sortable: true, sortDirection: 'desc'},
                    {key: 'get_ville', label: 'Ville',  sortable: true, sortDirection: 'desc'},
                    {key: 'titre', label: 'titre',  sortable: true, sortDirection: 'desc'},
                    {key: 'date_debut_human', label: 'Date début',  sortable: true, sortDirection: 'desc'},
                    {key: 'date_fin_human', label: 'Date fin'},
                    {key: 'etat', label: 'etat',  sortable: true, sortDirection: 'desc'},
                    {key: 'actions', label: 'Actions'},
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
            this.all_location();
        },

        methods: {
            libelle_etat(code_etat) {
                switch (code_etat) {
                    case 1 :
                        return 'Non Validé';
                    case 2 :
                        return 'Validé';
                    case 3 :
                        return 'publié';
                    case 4 :
                        return 'Désactivé'
                }
            },


            removeLocation(location) {
                swal.fire({
                    title: 'êtes-vous sûr de vouloir  supprimer?',
                    text: "Vous ne pourrez plus le récuperer! ",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, Supprimer!',
                    cancelButtonText:'Non, annuler'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/location/'+location.slug)
                            .then( (response) => {
                                swal.fire(
                                    'Supprimé!',
                                    'La location a été supprimé.',
                                    'success'
                                );
                                this.all_location();
                            })
                    }
                })
            },

            all_location() {
                this.liste_locations = [];
                axios.get('/api/location')
                .then((response) => {
                    this.liste_locations = response.data.content.data;
                }).catch( (err) => {
                    this.liste_locations = null;
                });
            },


            onShowDetail(location) {
                // le message du bouton
                switch (location.etat) {
                    case 1 :
                        this.button_message = 'Valider la planification';
                        break;
                    case 2 :
                        this.button_message =  'Publier le voyage';
                        break;
                    case 3 :
                        this.button_message =  'Désactiver le voyage';
                        break;
                    case 4 :
                        this.button_message =  'Publier le voyage'
                }
                this.location_detail = location;
                this.showModalDetail = true ;
            },

            change_state(slug, etat){
                var message_action = '';
                switch (etat) {
                    case 1 :
                        message_action = 'Location a été Validé';
                        break;
                    case 2 :
                        message_action =  'Location Publié';
                        break;
                    case 3 :
                        message_action =  'Location Désactivé';
                        break;
                    case 4 :
                        message_action =  'Location  publié'
                }

                axios.put('/api/change_state_location/'+slug)
                    .then((response) => {
                        swal.fire(
                            message_action,
                            'L\'état a été modifié.',
                            'success'
                        );
                        this.showModalDetail = false;
                        this.all_location();
                    })
                    .catch(err => console.log(err));
            },

            updateLocation(location) {
                if (location.etat !== 3){
                    this.$root.$emit('update_location', location);
                } else {
                    swal.fire({
                        title: 'Oops...',
                        text: 'Vous ne pouvez pas un modifier une location déjà publié! \n desactivez la publication',
                    })
                }
            },

            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            }
        },
    }
</script>


<style scoped>
    .image-div img{
        width: 200px;
        height: 150px;
    }

</style>