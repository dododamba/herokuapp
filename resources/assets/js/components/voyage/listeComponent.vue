<template>
    <div class="row">
        <div class="col-12" v-if="liste_voyages != null">

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
                    :items="liste_voyages"
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
                <template slot="partenaire" slot-scope="row">
                    {{ row.value}}
                </template>

                <template slot="ville_depart" slot-scope="row">
                    {{ row.value}}
                </template>

                <template slot="ville_arrivee" slot-scope="row">
                    {{ row.value}}
                </template>

                <template slot="moyen_transport" slot-scope="row">
                    {{row.value}}
                </template>

                <template slot="date_depart" slot-scope="row">
                    {{ row.value}}
                </template>

                <template slot="libelle_etat" slot-scope="row">
                    {{ row.value}}
                </template>

                <template slot="actions" slot-scope="row">
                    <b-button pill variant="info" v-b-tooltip.hover title="Détail du voyage" size="sm" @click="onShowDetail(row.item)">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                    </b-button>
                    <b-button pill variant="warning" size="sm"  v-b-tooltip.hover title="Modifier" @click="updateVoyage(row.item)">
                        <i class="fa fa-pencil-square-o"></i>
                    </b-button>
                    <b-button pill variant="danger" size="sm"  v-b-tooltip.hover title="Supprimer"
                              @click="removeVoyage(row.item)">
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
        <template v-if="liste_voyages==null" class="row">
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
                        <div class="col-7">
                            <b>Nom du partenaire: </b> {{voyage_detail.partenaire}}
                            <hr>
                            <b>Ville de départ: </b> {{voyage_detail.ville_depart}}
                            <hr>
                            <b>Ville d'arrivée: </b> {{voyage_detail.ville_arrivee}}
                            <hr>
                        </div>
                        <div class="col-5 card-image" style="text-align: right">
                            <img v-if="voyage_detail.image != null" :src="voyage_detail.image.nom" alt="Image du voyage">
                            <img v-else src="/storage/defaults/default_image.png" alt="Image du voyage">
                        </div>
                    </b-row>
                    <b-row>
                        <div class="col-6">

                            <b>Date de départ : </b> {{voyage_detail.date_depart_human}}
                            <hr>
                            <b>Nombre de place : </b> {{voyage_detail.nombre_place}}
                            <hr>
                            <b> date de création : </b> {{voyage_detail.created_at_human}}
                            <hr>
                            <div class="single-table">
                                <table class="table text-center table-bordered">
                                    <thead class="text-uppercase">
                                    <tr >
                                        <th scope="col">Classe </th>
                                        <th scope="col">Prix Enfant </th>
                                        <th scope="col">Prix Adulte </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="t in voyage_detail.tarifs">
                                        <td> {{libelle_classe(t.classe)}} </td>
                                        <td>{{t.prix_enfant}}</td>
                                        <td>{{t.prix_adulte}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-6">
                            <b>Moyen de transport :</b> {{voyage_detail.moyen_transport}}
                            <hr>
                            <b>Etat de la planification : </b> {{libelle_etat(voyage_detail.etat)}}
                            <hr>
                            <b>Description du voyage</b>
                            <p>{{voyage_detail.description}}</p>
                        </div>
                    </b-row>

                <div slot="modal-footer" class="w-100">
                    <b-button  variant="danger" size="sm" class="float-left" @click="showModalDetail=false" >
                        Fermer
                    </b-button>
                    <b-button type="submit"  variant="success" size="sm" class="float-right" @click="change_state(voyage_detail.slug, voyage_detail.etat)" >
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
                liste_voyages : null,


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
                voyage_detail: '',
                button_message: '',

                fields: [
                    {key: 'partenaire', label: 'partenaire',  sortable: true, sortDirection: 'desc'},
                    {key: 'ville_depart', label: 'Ville départ',  sortable: true, sortDirection: 'desc'},
                    {key: 'ville_arrivee', label: 'Ville arrivée',  sortable: true, sortDirection: 'desc'},
                    {key: 'moyen_transport', label: 'Moyen',  sortable: true, sortDirection: 'desc'},
                    {key: 'date_depart_human', label: 'Date départ'},
                    {key: 'libelle_etat', label: 'etat',  sortable: true, sortDirection: 'desc'},
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
            this.all_voyage();
            this.load_classe();
        },

        methods: {

            load_classe() {
                this.liste_classe = [];
                axios.get('/api/classe')
                    .then((response) => {
                        response.data.content.forEach((classe) => {
                            this.liste_classe.push({
                                id: classe.id,
                                libelle: classe.libelle
                            })
                        })
                    }).catch(err => console.log(err));
            },


            name_transport(code) {

                switch (code) {
                    case 1 :
                        return 'Routier';
                    case 2 :
                        return 'Ferroviaire';
                    case 3 :
                        return 'Maritime';
                    case 4 :
                        return 'Aérien'
                }
            },

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

            libelle_classe(id) {
                var libelle = '';
                this.liste_classe.forEach((classe) => {
                    if (classe.id === id)
                        libelle=  classe.libelle;
                });
                return libelle;
            },

            removeVoyage(voyage) {
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
                        axios.delete('/api/voyage/'+voyage.slug)
                            .then( (response) => {
                                swal.fire(
                                    'Supprimé!',
                                    'Le voyage a été supprimé.',
                                    'success'
                                );
                                this.all_voyage();
                            })
                    }
                })
            },

            all_voyage() {
                axios.get('/api/voyage')
                    .then( (response) => {
                        this.liste_voyages = [];
                        let number = false;
                        response.data.content.forEach((voyage) => {
                            number = true;
                            axios.get('/api/itineraire/'+voyage.itineraire.slug)
                            .then((itt) => {
                                    this.liste_voyages.push({
                                        numero: voyage.numero,
                                        date_depart: voyage.date_depart,
                                        moyen_transport: this.name_transport(voyage.moyen_transport),
                                        nombre_place: voyage.nombre_place,
                                        etat: voyage.etat,
                                        libelle_etat: this.libelle_etat(voyage.etat),
                                        image: voyage.image,
                                        heure_depart: voyage.heure_depart,
                                        slug: voyage.slug,
                                        created_at_human: voyage.created_at_human,
                                        date_depart_human: voyage.date_depart_human,
                                        personnel: voyage.valider_par,
                                        ville_depart: itt.data.content.ville_depart.nom,
                                        ville_arrivee: itt.data.content.ville_arrivee.nom,
                                        partenaire: voyage.partenaire.nom_partenaire,
                                        itineraire: voyage.itineraire.id,
                                        tarifs: voyage.tarif,
                                        description: voyage.description,
                                        duree: voyage.duree,
                                    })
                                });

                        });

                        if (!number) this.liste_voyages = null;
                    }).catch( (err) => {
                        this.liste_voyages = null;
                });
            },


            onShowDetail(voyage) {
                // le message du bouton
                switch (voyage.etat) {
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
                this.voyage_detail = voyage;
                this.showModalDetail = true ;
            },

            change_state(slug, etat){
                var message_action = '';
                switch (etat) {
                    case 1 :
                        message_action = 'Voyage a été Validé';
                        break;
                    case 2 :
                        message_action =  'Voyage Publié';
                        break;
                    case 3 :
                        message_action =  'Voyage Désactivé';
                        break;
                    case 4 :
                        message_action =  'Voyage  publié'
                }

                axios.put('/api/change_state_voyage/'+slug)
                    .then((response) => {
                        swal.fire(
                            message_action,
                            'L\'état a été modifié.',
                            'success'
                        );
                        this.showModalDetail = false;
                        this.all_voyage();
                    })
                    .catch(err => console.log(err));
            },

            updateVoyage(voyage) {
                if (voyage.etat !== 3){
                    this.$root.$emit('update-voyage', voyage);
                } else {
                    swal.fire({
                        title: 'Oops !!!!! ',
                        text: 'Vous ne pouvez pas un modifier un voyage déjà publié!',
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