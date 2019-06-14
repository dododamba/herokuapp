<template>

    <modal-layouts name="editRecord" id="editRecord">

        <template slot="heading">Editer L'publicite</template>

        <template slot="main">



            <hr>
            <hr>





            <div class="form-group">
                <label for="titre">Titre</label>

                <input type="text"
                       name="titre"
                       id="titre"
                       class="form-control"
                       v-model="editRec.titre"
                       @keydown="delete errors.titre">

                <span v-if="errors.titre" class="text-danger">
					<small v-text="errors.titre[0]"></small>
				</span>
            </div>
            <div class="form-group">
                <h6 class='text-default'><span>Le Conenue de La publicite</span> <em class="text-light">(saisir)</em></h6>

                <textarea @keydown="delete errors.contenue" class="form-control" id="contenue"
                          name="contenue"
                          placeholder="Contenue de l'publicite" rows="9"  v-html="viewRec.contenue"></textarea>

                <p class='text-right text-small' v-bind:class="{'text-danger': hasError }">{{remainingCount}} mots restantes| 1000</p>

                <span class="text-danger" v-if="errors.contenue">
					<small v-text="errors.contenue[0]"></small>
				</span>
            </div>




            <hr>


            <div class="row">
                <div class="form-group col-6">
                    <label for="dateDebut" class=" form-control-label"><strong>Date du Debut</strong> </label>
                    <input type="date" id="dateDebut" name="dateDebut" placeholder="début d'publicite" v-model="editRec.dateDebut" class="form-control"><small class="form-text text-muted">début d'publicite</small>

                </div>
                <div class="form-group col-6">
                    <label for="dateFin" class=" form-control-label"><strong>Date Fin</strong> </label>
                    <input type="date" id="dateFin" name="dateFin" placeholder="date de fin de l'publicite"  v-model="editRec.dateFin"  class="form-control"><small class="form-text text-muted">fin d'publicite</small>

                </div>
            </div>

            <hr>


            <div class="row ">

                <div class="form-group col-6">
                    <label class=" form-control-label"><strong>Etat de L'Annonce</strong></label>
                    <select class="browser-default custom-select custom-select-lg mb-3 " id="etat" name="etat" v-model="editRec.etat">
                        <option selected>Selectionner</option>
                        <option value="2">Activé</option>
                        <option value="1">Desactivé</option>
                        <option value="3">En atente</option>
                    </select>

                </div>
                <div class="form-group col-6">
                    <label class=" form-control-label"><strong>Créateur </strong></label>
                    <select class="browser-default custom-select custom-select-lg mb-3  text-primary form-control-sm" id="partenaire" name="partenaire" v-model="editRec.partenaire" >
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
                <div class="text-center" id="my-strictly-unique-vue-upload-multiple-image" style="display: flex; justify-content: center;">

                    <vue-upload-multiple-image   v-model="image"
                                                 @upload-success="uploadImageSuccess"
                                                 @before-remove="beforeRemove"
                                                 @edit-image="editImage"
                                                 @data-change="dataChange"
                                                 @limit-exceeded="limitExceeded"
                    ></vue-upload-multiple-image>

                </div>
            </div>





        </template>

        <template slot="footer">
            <button type="button"
                    class="btn btn-outline-secondary"
                    @click="clearModal"
                    data-dismiss="modal">Close</button>

            <button type="submit"
                    class="btn btn-outline-primary"
                    @click="updateRecord"
                    data-dismiss="modal">Save Changes</button>
        </template>

    </modal-layouts>


</template>

<script>

    import ModalLayouts from '../partials/ModalLayouts'
    import axios from 'axios';

    Vue.use(axios);

    export default {
        props: ['editRec'],

        data() {
            return {
                errors: [],
            }
        },

        components: {ModalLayouts},

        methods: {
            updateRecord() {
                axios.put(`/api/publicite/${this.editRec.slug}`, this.editRec)
                    .then(response => {
                        this.$emit('recordUpdated', response);

                        toast.fire({
                            type: 'success',
                            title: 'Record has been updated successfully!'
                        });

                        $('#editRecord').modal('hide');


                    })
                    .catch(error => this.errors = error.response.data.errors)
            },

            clearModal() {
                this.errors = [];
            }
        }
    };
</script>