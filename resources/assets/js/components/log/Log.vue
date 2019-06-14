<template>

    <div class="row">


        <div class="col-md-12" v-if="items">
            <div class="single-table">
                <div class="table-responsive">
                    <table class="table table-striped  table-hover text-center">
                        <thead class="text-uppercase thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Action</th>
                            <th>IP</th>
                            <th>Utilisateur</th>
                            <th>Table</th>
                            <th>Date de création</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="log in items.data">
                            <td>{{ log.id }}</td>
                            <td>{{ log.action }}</td>
                            <td>{{ log.adresseIp }}</td>
                            <td>{{ log.user }}</td>
                            <td>{{ log.table }}</td>
                            <td>{{ log.created_at}}</td>
                        </tr>

                        </tbody>

                    </table>

                    <nav aria-label="Page navigation example">
                        <ul class="pagination pagination-seperated pagination-seperated-rounded">


                            <li class="page-item" v-if="items.prev_page_url != null">
                                <button @click="list(items.prev_page_url)" class="page-link">
                                   <<
                                </button>
                            </li>

                            <li class="page-item" v-if="items.prev_page_url != null || items.prev_page_url > 0 ">
                                <button @click="list(items.prev_page_url)" class="page-link">{{ items.current_page -1  }}</button>
                            </li>


                            <li class="page-item active">
                                <a class="page-link" >{{ items.current_page }}</a>
                            </li>


                            <li class="page-item" v-if="items.next_page_url != null">
                                <button @click="list(items.next_page_url)" class="page-link">{{ items.current_page +1  }}</button>
                            </li>



                            <li class="page-item" v-if="items.next_page_url != null">
                                <button class="page-link" @click="list(items.next_page_url)">
                                   >>
                                </button>
                            </li>



                            <li class="page-item pull-right">
                                <button type="button" class="page-link btn-danger">Total : {{ items.per_page }} / {{ items.total }}</button>
                            </li>
                        </ul>
                    </nav>

                </div>

            </div>
        </div>





  </div>
</template>

<script>
import VueAxios from 'vue-axios';
import axios from 'axios';
import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);

Vue.use(VueAxios, axios);
    export default {
        activate : '#activate',
         el:'#app',

         data(){
             return {
                 items : [],
                 item : '',
             }
         },
          mounted() {
            this.list('/api/log?page=0');
          },


        methods: {
            list(url)
            {
                let ar = this;
                axios.get(url)
                    .then(function(response){
                        ar.items = response.data.meta;
                        ar.current_page_ = ar.items.current_page;
                        console.log(ar.items);
                    }).catch(function(response){});

            },

           show(c){
            this.$refs['show'].show()
            },
    }
     }
</script>
<style>
    
#redone{
    color: red;
}

#green{
    color: green;
}

#transparent{
    color: transparent;
}

.bg-sensei {
  background-color : #4c84ff;
}

.bg-sensei tr th{
  color:  #ffffff;
  text-transform: capitalize;
}
</style>
<style lang="scss">
    .panel-o {
        padding: 1.5rem 2rem;
        /* position: absolute; */
        background-color: #fff;
        width: 100%;
        height: 100%;
        border: none;
        overflow: hidden;
    }
    .meta {
        top: 0;
        left: 0;
        z-index: 1;
        margin: 0;
        position: relative;
        text-align: center;
        padding: 2rem 4rem;
        border-right: 1px solid transparent;

        picture {
            position: relative;
            display: inline-block;
        }

        img {
            object-fit: cover;
        }
        .avatar {
            border-radius: 50%;
        }

        .company-logo {
            position: absolute;
            bottom: -0.5rem;
            right: 0;
        }
        .name {
            font-size: 2rem;
            text-align: center;
            margin-top: 1rem;
            font-weight: 300;
        }

        .title {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 1rem 0 0;
        }
    }

</style>