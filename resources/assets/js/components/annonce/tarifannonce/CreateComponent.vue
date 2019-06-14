

    <script src="../../../app.js"></script>
    <template>
        <b-card title="Céation  Positions annonce" >
            <b-card-text>
                <form @submit.prevent="onSubmit" enctype="multipart/form-data">



                    <div class="row form-group">
                        <div class="col col-md-3"><label for="libelle" class=" form-control-label"><strong>Titre :</strong> </label></div>
                        <div class="col-12 col-md-9"><input type="text" id="libelle" v-model="libelle" name="libelle" placeholder="titre du position l'annonce" class="form-control"><small class="form-text text-muted">saisir le titre</small></div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3"><label for="description" class=" form-control-label"><strong>Description :</strong></label></div>
                        <div class="col-12 col-md-9"><textarea name="description" id="description" v-model="description"  rows="9" placeholder="description de l'annonce" class="form-control"></textarea></div>
                    </div>

                    <hr>
                <h2>Liste Types Annonces</h2> <br>


                <div class="row">
                    <div class="form-group col-6">
                        <label  class=" form-control-label">Nombre Caractére</label>
                        <div class="animated fadeIn">
                            <!-- Widgets  -->
                            <div class="row">
                                <div class="col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="stat-widget-five">
                                                <div class="stat-icon dib flat-color-1">
                                                    <i class="pe-7s-cash"></i>
                                                </div>
                                                <div class="stat-content">
                                                    <div class="text-left dib">
                                                        <div class="stat-text"><span class="count">450</span></div>
                                                        <div class="stat-heading">Caractéres</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label  class=" form-control-label">Prix  Caractéres </label>
                        <div class="animated fadeIn">
                            <!-- Widgets  -->
                            <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="stat-widget-five">
                                        <div class="stat-icon dib flat-color-2">
                                            <i class="pe-7s-cart"></i>
                                        </div>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text"><span class="count">3435</span>F</div>
                                                <div class="stat-heading">Prix  cractére</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label  class=" form-control-label">Cout Images </label>
                        <div class="animated fadeIn">
                            <!-- Widgets  -->
                            <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="stat-widget-five">
                                        <div class="stat-icon dib flat-color-3">
                                            <i class="pe-7s-browser"></i>
                                        </div>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text"><span class="count">349</span>F</div>
                                                <div class="stat-heading">Cout Image</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-6">

                        <label  class=" form-control-label">Cout Totale </label>
                        <div class="animated fadeIn">
                            <!-- Widgets  -->
                            <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="stat-widget-five">
                                        <div class="stat-icon dib flat-color-4">
                                            <i class="pe-7s-users"></i>
                                        </div>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text"><span class="count">2986</span>F</div>
                                                <div class="stat-heading">Total</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            </div></div>
                    </div>
                </div>


                    <div class="card-footer">
                        <b-button type="submit" variant="outline-success" v-on:click="onlist()" class="btn btn-success btn-sm">
                            <i class="fa fa-dot-circle-o"></i> <strong>Envoyer</strong>
                        </b-button>
                        <b-button type="reset" class="btn btn-danger btn-sm">
                            <i class="fa fa-ban"></i> <strong>Annuler</strong>
                        </b-button>
                        <b-button type="send" class="btn btn-succes btn-sm">
                            <i class="fa fa-ban"></i> <strong>Payer</strong>
                        </b-button>
                    </div>


                </form>



            </b-card-text>

        </b-card>
    </template>






<script>
    import axios from 'axios';
    export default {

        data() {
            return {
                libelle: '',
                description: '',

            }
        },

        mounted() {
            this.load_countries();
        },
        methods: {



            onSubmit() {
                var new_annonce = {
                    'libelle': this.libelle,
                    'description': this.description,


                };

                axios.post('/api/positionannonce', new_annonce)
                    .then(() => {
                        toast.fire({
                            type: 'success',
                            title: 'Record has been added successfully!'
                        })


                    }).catch((response) => {
                        alert("enregistrer")
                    console.log(response);
                });
            },
        }

    }
</script>

<style scoped>

</style>