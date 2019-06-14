<template>

      <div class="col-md-11">


          <form v-on:submit.prevent="store()">


              <div v-if="status_ === 1">
                  <div class="sufee-success alert with-close alert-success alert-dismissible fade show">
                      <span class="badge badge-pill badge-errot">Succès</span>
                      {{ message_ }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
              </div>


              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <input type="text" class="form-control" v-model="personnel.nom" placeholder="Nom">
                      </div>
                      <p v-if="validations" id="red">
                          {{ validations.nom }}
                      </p>
                      <p style="font-size: 90%">ex. John</p>
                  </div>


                  <div class="col-md-6">
                      <div class="form-group">
                          <input type="text" class="form-control" v-model="personnel.prenom" placeholder="Prénom">
                      </div>
                      <p v-if="validations" id="red">
                          {{ validations.prenom }}
                      </p>
                      <p style="font-size: 90%">ex. Snow</p>
                  </div>


              </div>

              <div class="row">
                  <div class="col-md-6">
                      <label class="text-dark mt-4 font-weight-medium" for="">Matricule</label>
                      <div class="form-group">
                          <input type="text" class="form-control" v-model="personnel.matricule">
                      </div>
                      <p v-if="validations" id="red">
                          {{ validations.matricule }}
                      </p>
                      <p style="font-size: 90%">ex. ITC094-R2</p>
                  </div>


                  <div class="col-md-6">
                      <label class="text-dark mt-4 font-weight-medium" for="">Sexe</label>
                      <select v-model="personnel.sexe" class="form-control">
                          <option value="">Selectioner le sexe</option>
                          <option value="M">Masculin</option>
                          <option value="F">Féminin</option>
                      </select>
                      <p style="font-size: 90%">ex. Femme</p>
                  </div>

              </div>

              <div class="row">
                  <div class="col-md-6">
                      <label class="text-dark mt-4 font-weight-medium" for="">Email</label>
                      <div class="form-group">
                          <input type="email" class="form-control" v-model="personnel.email">
                      </div>
                      <p v-if="validations" id="red">
                          {{ validations.email }}
                      </p>
                      <p style="font-size: 90%">ex. info@techomegapartners.com</p>
                  </div>


                  <div class="col-md-6">
                      <label class="text-dark mt-4 font-weight-medium" for="">Téléphone</label>
                      <div class="form-group">
                          <input type="text" class="form-control" v-model="personnel.telephone">
                      </div>
                      <p style="font-size: 90%">ex. +24100000000</p>
                  </div>

              </div>

              <div class="row">

                  <div class="col-md-6">
                      <label class="text-dark font-weight-medium" for="">Date d'embauche</label>
                      <div class="form-group">
                          <input type="date" class="form-control" v-model="personnel.date_embauche">
                      </div>
                      <p v-if="validations" id="red">
                          {{ validations.date_embauche }}
                      </p>
                      <p style="font-size: 90%">ex. 08/08/2008</p>
                  </div>



                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="text-dark font-weight-medium" for="">Date de Naissance</label>
                          <input type="date" class="form-control" v-model="personnel.date_naissance">
                      </div>
                      <p v-if="validations" id="red">
                          {{ validations.date_naissance }}
                      </p>
                      <p style="font-size: 90%">ex. 08/08/2008</p>
                  </div>

              </div>


              <div class="row">
                  <div class="col-md-6">
                      <label class="text-dark mt-4 font-weight-medium" for="">Langue</label>
                      <div class="form-group">
                          <select v-model="personnel.langue" class="form-control">
                              <option value="">Selectioner une langue</option>
                              <option value="fr">Fr</option>
                              <option value="en">En</option>

                          </select>
                      </div>
                      <p style="font-size: 90%">ex. Fr</p>
                  </div>

                  <div class="col-md-6">
                      <label class="text-dark font-weight-medium" for="">Role</label>
                      <div class="form-group">
                          <select class="form-control" v-model="personnel.role">
                              <option disabled>Selectioner un role</option>
                              <option value=""></option>
                              <option v-for="r in roles_" v-bind:value="r.id">{{ r.name }}</option>
                          </select>
                      </div>
                      <p v-if="validations" id="red">
                          {{ validations.role }}
                      </p>
                      <p style="font-size: 90%">ex. Role</p>
                  </div>
              </div>





              <hr>
              <div class="row">
                  <button class="btn btn-primary" type="submit">Valider</button>
                  <button class="btn btn-default" type="reset">Recommencer</button>
              </div>
          </form>
      </div>

</template>

<script>
    import axios from 'axios';
    import Swal from 'sweetalert2';
    import BootstrapVue from 'bootstrap-vue';


    Vue.use(axios);
    export default {
        name: "Create",
        data() {
            return {
                is_completed: [],
                roles_: [],
                message: '',
                message_: '',
                dismissSecs: 7,
                dismissCountDown: 0,
                role_: '',
                status_: '',
                email_: '',
                birth_: '',
                password_confirmation: '',
                password: '',
                phone_: '',
                lang_: '',
                login_: '',
                created_: '',
                validations: [],
                current_page_: '',
                date_embauche: '',
                personnel: {
                    nom: '',
                    prenom: '',
                    matricule: '',
                    date_embauche: '',
                    matricule: '',
                    email: '',
                    role: '',
                    telephone: '',
                    langue: '',
                    sexe: '',
                    date_naissance: '',

                },
                compte: {
                    email: '',
                    role: '',
                    slug: '',
                    telephone: '',
                    langue: '',
                    role: '',
                    password: '',
                    password_confirmation: '',
                },
                password_: '',
                password_confirmation_: '',
            }
        },
        mounted() {
            this.getRole();
        },
        methods: {
            getRole() {
                let app = this;
                axios.get('api/role-personnel')
                    .then(function (response) {
                        app.roles_ = response.data.content.roles;
                    })
                    .catch();
            },

            store() {
                var app = this;
                var newPersonnel = app.personnel;
               axios.post('/api/create/personnel', newPersonnel)
                    .then(function (response) {
                        app.message_ = response.data.content.message;
                        app.status_ = response.data.content.status;
                        app.validations = response.data.content.error;

                        console.log(app.message_,app.validations,app.status_)
                        if (app.status === 0){
                            Swal.fire(
                                'Echec!',
                                app.message_,
                                'error'
                            )
                        }

                    }).catch(function (response) {});
            },



        }


    }
</script>

<style scoped>
 #red{
     color: red;
 }
</style>