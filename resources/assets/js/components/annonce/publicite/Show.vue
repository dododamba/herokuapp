<template>

    <modal-layouts name="viewRecord">



        <template  slot="heading">
            <div class=""><h5>
                <div class ="text-primary">
                    Details de La pUb
                </div>
            </h5>
            </div>
        </template>

        <template slot="main">






            <hr>
            <div class="card" style="">
                <div class="card-img-top image-div">
                </div>
                <hr>
                <hr>
                <div class="card-body">
                    <h5 class="card-title">
                        <label  class="text-dark form-control-label"><strong>Titre :</strong></label>

                        <label class=" form-control-label text-primary">
                            <strong>
                                {{viewRec.titre}}
                            </strong>
                        </label></h5>
                    <p class="card-text"></p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-info">

                        <div class="row form-group">
                            <label  class="text-dark form-control-label"><strong>Créer:</strong></label>


                            <label class=" form-control-label text-primary">
                                <strong>
                                    Le {{viewRec.created_at_human}}
                                </strong>
                            </label>


                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row form-group">

                            <label  class="text-dark"><strong>Creer Par :</strong></label>

                            <label class="  text-primary">
                                <strong>
                                    {{viewRec.partenaire}}
                                </strong>
                            </label>

                        </div>
                    </li>
                    <li class="list-group-item "><div class="row form-group">

                        <label  class="text-dark"><strong>Contenue :</strong></label>

                        <label class="">
                            <div v-html="viewRec.contenue"></div>
                        </label>

                    </div>
                    </li>
                    <li class="list-group-item list-group-item-primary">
                        <div class="row form-group">

                            <label  class="text-dark form-control-label"><strong>Début Programmée :</strong></label>

                            <label class=" form-control-label text-primary">
                                <strong>
                                    le {{viewRec.dateDebut}}
                                </strong>
                            </label>

                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row form-group">

                            <label  class="text-dark form-control-label"><strong>fin planifier  de l'publicite :</strong></label>

                            <label class=" form-control-label text-primary">
                                <strong>
                                    {{viewRec.dateFin}}
                                </strong>
                            </label>

                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row form-group">

                            <label  class="text-dark form-control-label"><strong>Type  de l'publicite :</strong></label>


                                <label class=" form-control-label text-primary">
                                    <strong>
                                        PUBLICITE
                                    </strong>
                                </label>


                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row form-group">

                            <label  class="text-dark form-control-label"><strong>Position de l'publicite :</strong></label>

                            <label class=" form-control-label text-primary">
                                <strong>
                                    {{viewRec.position}}
                                </strong>
                            </label>

                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row form-group">

                            <label  class="text-dark form-control-label"><strong>Etat de l'publicite :</strong></label>

                            <label class=" form-control-label text-primary">
                                <strong>
                                    <button v-if="viewRec.etat == 2 " class="btn btn-success btn-link"
                                            data-toggle="modal" data-target="#viewRecord" @click="get(record.slug)"> Active
                                    </button>
                                    <button v-else class="btn btn-danger btn-xs  btn-link" data-toggle="modal" data-target="#viewRecord" @click="get(record.slug)">
                                        Désactive
                                    </button>
                                </strong>
                            </label>

                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row form-group">

                            <label  class="text-dark form-control-label"><strong>Etat payement :</strong></label>

                            <label class=" form-control-label text-primary">
                                <strong>
                                    {{viewRec.etat}}
                                </strong>
                            </label>
                        </div>

                    </li>

                </ul>
                <div class="card-body">


                    <a href="#" class="card-link">Activer ?</a>
                </div>
            </div>







        </template>


        <template slot="footer">


            <button class=" btn btn-outline-primary btn-sm" data-toggle="modal" data-dismiss="modal" data-target="#editRecord" @click="get(record.slug)">Modifier<i class="fa fa-edit"></i></button>

            <button class="btn btn-outline-danger btn-sm" data-dismiss="modal" @click="remove(record.slug)">Supprimer<i class="fa fa-trash"></i></button>



            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Retour</button>
        </template>

    </modal-layouts>
</template>

<script>
    import ModalLayouts from '../partials/ModalLayouts'

    export default {
        props: ['viewRec'],

        components: {ModalLayouts}
    };
</script>