

    <template>

        <div class="container m-lg-auto">
            <div class="row justify-content-center">
                <div class="col-md-auto">
                    <div class="card card-default"><h1>
                        <div class="card-header bg-transparent text-primary">Gvoyage
                            <button class="btn btn-link btn-sm pull-right" data-target="#addRecord" data-toggle="modal">
                                <i class="fa  fa-sign-language" aria-hidden="true"></i></button>
                        </div>
                    </h1>
            <div class="card-body">
                <form @submit.prevent="onSubmit" enctype="multipart/form-data">



                    <div class="row form-group">
                        <div class="col col-md-3"><label for="titre" class=" form-control-label"><strong>Titre</strong> </label></div>
                        <div class="col-12 col-md-9"><input type="text" id="titre" v-model="titre" name="titre" placeholder="entête de l'annonce" class="form-control"><small class="form-text text-muted">saisir le titre</small></div>
                    </div>
                    <hr>
                    <hr>
                        <div class="row">
                            <div class="col-auto">
                                <h6 class='text-default'><span>Le Conenue de l'annonce</span> <em class="text-light">(saisir)</em></h6>
                                <textarea class="form-control" id="contenue" cols="70" rows="60" v-on:keyup="countdown" v-model="contenue" placeholder="Contenue de l'annonce"></textarea>
                                <p class='text-right text-small' v-bind:class="{'text-danger': hasError }">{{remainingCount}} mots restantes| 1000</p>
                            </div>
                        </div>
                    <div class="col col-md-3"><label for="contenue" class=" form-control-label " style="display:none;"><strong>Contenue</strong></label></div>




                    <hr>


                <div class="row">
                    <div class="form-group col-6">
                        <label for="dateDebut" class=" form-control-label"><strong>Date du Debut</strong> </label>
                      <input type="date" id="dateDebut" name="dateDebut" placeholder="début d'annonce" v-model="dateDebut" class="form-control"><small class="form-text text-muted">début d'annonce</small>

                    </div>
                    <div class="form-group col-6">
                      <label for="dateFin" class=" form-control-label"><strong>Date Fin</strong> </label>
                   <input type="date" id="dateFin" name="dateFin" placeholder="date de fin de l'annonce"  v-model="dateFin"  class="form-control"><small class="form-text text-muted">fin d'annonce</small>

                    </div>
                </div>

                    <hr>
                    <div class="row ">

                        <div class="form-group col-6">
                            <label class=" form-control-label"><strong>Position sur Ecran</strong></label>
                            <select class="browser-default custom-select custom-select-lg mb-3  text-primary form-control-sm" id="position" name="position" v-model="position" >
                                <option selected>Selectionner</option>
                               
                                <option value="2">laterale</option>
                                <option value="1">laterale</option>
                        
                                <option v-for="option in types" v-bind:value="option.value">
                                    {{ option.text }}
                                </option>
                            </select>
                            <span>Sélectionné : {{ selected }}</span>

                        </div>
                        <div class="form-group col-6">
                            <label class=" form-control-label"><strong>Type Annonce </strong></label>
                            <select class="browser-default custom-select custom-select-lg mb-3  text-primary form-control-sm" id="type" name="type" v-model="type" >
                                <option selected>Selectionner</option>
                                
                                <option value="2">pub</option>
                                <option value="1">autre</option>
                                <option value="3">hebdomadaire</option>
                                <option v-for="option in types" v-bind:value="option.value">
                                    {{ option.text }}
                                </option>
                            </select>
                            <span>Sélectionné : {{ selected }}</span>


                        </div>
                    </div>
                    <hr>


                    <div class="row ">

                        <div class="form-group col-6">
                            <label class=" form-control-label"><strong>Etat de L'Annonce</strong></label>
                            <select class="browser-default custom-select custom-select-lg mb-3 " id="etat" name="etat" v-model="etat">
                                <option selected>Selectionner</option>
                                <option value="2">Activé</option>
                                <option value="1">Desactivé</option>
                                <option value="3">En atente</option>
                            </select>

                        </div>
                        <div class="form-group col-6">
                            <label class=" form-control-label"><strong>Créateur </strong></label>
                            <select class="browser-default custom-select custom-select-lg mb-3  text-primary form-control-sm" id="partenaire" name="partenaire" v-model="partenaire" >
                                <option selected>Selectionner</option>
                                <option v-for="option in partenaires" v-bind:value="option.value">
                                    {{ option.text }}
                                </option>
                            </select>
                            <span>Sélectionné : {{ selected }}</span>


                        </div>
                          </div>


                    <div class="row form-group">

                        <label class="text-succes  form-control-label"><strong>Ajouter une Image <i class="fa fa-camera fa-2x" aria-hidden="true"></i>
                        </strong></label>
                        <div id="my-strictly-unique-vue-upload-multiple-image" style="display: flex; justify-content: center;">
                            <vue-upload-multiple-image
                                    @upload-success="uploadImageSuccess"
                                    @before-remove="beforeRemove"
                                    @edit-image="editImage"
                                    @data-change="dataChange"
                                    :data-images="images"
                            ></vue-upload-multiple-image>
                        </div>
                     </div>

                <hr>




                <h2>Information Génerale</h2> <br>


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
                                                        <div class="stat-text"><span class="count">{{1000-remainingCount}}</span></div>
                                                        <div class="stat-heading">Caractéres Restant</div>
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
                                                <div class="stat-text"><span class="count"></span>F</div>
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
                                                <div class="stat-text"><span class="count"></span>F</div>
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
                                                <div class="stat-text"><span class="count"></span>F</div>
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

                        <button class="btn btn-success btn-sm pull-right"  v-on:click="onList()" variant="outline-success" >
                            <i class="fa fa-arrow-left"></i></button>
                        <b-button type="submit" variant="outline-success" v-on:click="onlist()" class="btn btn-success btn-sm">
                            <i class="fa fa-dot-circle-o"></i> <strong>Soumettre</strong>
                        </b-button>
                        <b-button type="reset" class="btn btn-danger btn-sm">
                            <i class="fa fa-ban"></i> <strong>Annuler</strong>
                        </b-button>
                        <b-button type="send" class="btn btn-succes btn-sm">
                            <i class="fa fa-ban"></i> <strong>Payer</strong>
                        </b-button>



                    </div>


                </form>




            </div>

                    </div>
                </div>
                </div>



            </div>


    </template>






<script>
    import axios from 'axios';
    import VueTrix from 'vue-trix';

    export default {
        components: {
            VueTrix
        },




        data() {
            return {

                maxCount: 1000,
                remainingCount: 1000,
                message: '',
                hasError: false,
                titre: '',
                contenue: '',
                dateDebut: '',
                dateFin:'',
                prix:'',
                nombreCaratere:'',
                position:'',
                etat: '',
                date_validation:'',
                utilisateur:'',
                transaction:'',
                image: null,
                type_annonce:'',
                date_creation:'',
                partenaire:'',
                partenaires:[],
                selected: 'un partenaire',
                selected1: 'Une TYPE',
                selected2: 'Une POSITION',
                valider_par:'',
                postion:'',
                position:[],
                types:[],
                type:'',
                images: [],



            }
        },
        mounted() {
            this.load_partenaire();
            this.load_position();
            this.load_type();
        },



        methods: {
            countdown: function() {
                this.remainingCount = this.maxCount - this.contenue.length;
                this.hasError = this.remainingCount < 0;
            },

            load_partenaire() {

                axios.get('/api/partenaire')
                    .then((response) =>{
                        response.data.content.forEach( (partenaire) => {
                            this.partenaires.push({
                                value: partenaire.id,
                                text: partenaire.nom_partenaire,
                            });
                        });
                        console.log(this.partenaires);


                    }).catch((response) => {
                        console.log(response);
                    }
                );
            },
            load_position() {

                axios.get('/api/positionannonce')
                    .then((response) =>{
                        response.data.content.forEach( (position) => {
                            this.positions.push({
                                value: position.id,
                                text: position.libelle,
                            });
                        });
                        console.log(this.positions);


                    }).catch((response) => {
                        console.log(response);
                    }
                );
            },
            load_type() {

                axios.get('/api/typeannonce')
                    .then((response) =>{
                        response.data.forEach( (type) => {
                            this.types.push({
                                value: type.id,
                                text: type.libelle,
                            });
                        });
                        console.log(this.types);


                    }).catch((response) => {
                        console.log(response);
                    }
                );
            },



            onSubmit() {
                var new_annonce = {
                    'titre': this.titre,
                    'contenue': this.contenue,
                    'dateDebut': this.dateDebut,
                    'dateFin': this.dateFin,
                    'prix': this.prix,
                    'nombreCaratere': this.nombreCaratere,
                    'position': this.position,
                    'etat': this.etat,
                    'date_validation': this.date_validation,
                    'utilisateur': this.utilisateur,
                    'transaction': this.transaction,
                    'image': this.image,
                    'type_annonce': this.type,
                    'partenaire': this.partenaire,
                    'valider_par': this.valider_par,

                };

                axios.post('/api/annonce', new_annonce)
                    .then(() => {
                        toast.fire({
                            type: 'success',
                            title: 'Enregistrer avec succes!'
                        })


                    }).catch((response) => {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Eurreur d\'soummission!',
                        footer: '<a href>BESOIN D\'Aide?</a>'
                    })
                    console.log(response);
                });
            },

            uploadImageSuccess(formData, index, fileList) {
                console.log('data', formData.object, index, fileList)
                // Upload image api
                axios.post('api/image', { data: formData.object }).then(response => {
                  console.log(response)
                 }).catch(err => console.log(err))
            },
            beforeRemove (index, done, fileList) {
                console.log('index', index, fileList)
                var r = confirm("remove image")
                if (r == true) {
                    done()
                } else {
                }
            },
            editImage (formData, index, fileList) {
                console.log('edit data', formData, index, fileList)
            },
            dataChange (data) {
                console.log(data)
            },

            limitExceeded(amount){
                console.log(amount)
            }


        }

    }
</script>

<style scoped>


    #my-strictly-unique-vue-upload-multiple-image {
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
        margin-top: 60px;
    }

    h1, h2 {
        font-weight: normal;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        display: inline-block;
        margin: 0 10px;
    }

    a {
        color: #42b983;
    }


</style>