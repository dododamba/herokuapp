<template>
    <div class="card-photo">
        <div class="image-div">
            <img class="rounded" :src=url alt="image de profil">
            <div class="action">
                <b-form-file plain v-model="image" id="inputImage" style="display: none"
                             accept=".jpg, .png, .bmp" @change="load_image"> </b-form-file>
                <b-button variant="info" size="sm"  onclick="document.getElementById('inputImage').click()">
                    <i class="fa fa-camera"></i>&nbsp;&nbsp;Modifier
                </b-button> <br>
                <b-button size="sm" variant="danger" v-on:click="delete_image">
                    <i class="fa fa-trash" ></i>&nbsp;&nbsp;&nbsp;Supprimer
                </b-button>
            </div>
        </div>
        <p v-if="error" style="color: red"> {{error_message}}</p>
    </div>
</template>

<script>
    export default {

        props: ['logo'],
        data() {
            return {
                error : false,
                error_message: '',
                image: null,
                url: "http://www.clubthorax.com/web/images/event/default.png",
            }
        },
        mounted() {
            this.load_url();

        },
        methods: {

            load_url() {
              if(this.logo !== null) {
                  this.url = this.logo;
              }
            },

            load_image(e) {

                if (e.target.files.length === 1) {

                    const file = e.target.files[0];

                    // On charge que des images de moins 1 Mo

                    if (file.size > 1024*1024) {
                        this.error = true;
                        this.error_message = 'Image trop lourde, charger une image de moins de 1 Mo';
                    } else {
                        this.error = false;
                        this.error_message = '' ;

                        // url pour l'affichage
                        this.url = URL.createObjectURL(file);

                        var fileReader = new FileReader();

                        fileReader.readAsDataURL(e.target.files[0]);

                        var type = e.target.files[0].type;
                        var name = e.target.files[0].name;

                        fileReader.onload = (e) => {
                            this.image = e.target.result;
                            this.$root.$emit('image' , this.image);
                        }

                    }
                }

            },
            delete_image() {
                this.error = false;
                this.image = null ;
                this.url = "http://www.clubthorax.com/web/images/event/default.png";
                this.$root.$emit('image' , this.image);
            },

            other(e) {

                if (e.target.files.length === 1) {


                    const file = e.target.files[0];

                    // On charge que des images de moins 1 Mo

                    if (file.size > 1024*1024) {
                        this.error = true;
                        this.error_message = 'Image trop lourde, charger une image de moins de 1 Mo';
                    } else {
                        this.error = false;
                        this.error_message = '' ;

                        // url pour l'affichage
                        this.url = URL.createObjectURL(file);

                        var fileReader = new FileReader();

                        fileReader.readAsDataURL(e.target.files[0]);

                        var type = e.target.files[0].type;
                        var name = e.target.files[0].name;

                        fileReader.onload = (e) => {
                            this.image = e.target.result;
                            this.$root.$emit('image' , this.image);
                        }

                    }
                }

            },
        }
    }
</script>

<style scoped>
    .card-photo{
        position: relative;
    }

    .action {
        position: absolute;
        background-color: rgba(0, 0, 0, .5);
        width: 170px;
        height: 0px;
        transition: height 0.5s;
        bottom: 77px;
        border-radius: 0 0 .25rem .25rem;
        overflow: hidden;
    }
    .action button {
        display: inline-block;
        color: rgba(255, 255, 255, 0.6);
        background: transparent;
        border: none;
        border-radius: 2px;
        width: 164px;
        text-align: start;
        padding-left: 10px;
        margin: 2px;
        cursor: pointer;
    }
    .action button:hover {
        color: rgba(255, 255, 255, 0.9);
        background: #008497;
    }
    .image-div:hover .action {
        visibility: visible;
        height: 60px;
        background-color: rgba(0, 0, 0, 0.5);
    }
    .image-div img{
        width: 200px;
        height: 150px;
    }
    .save {
        position: absolute;
        right: 50px;
        margin-bottom: 50px;
    }
</style>