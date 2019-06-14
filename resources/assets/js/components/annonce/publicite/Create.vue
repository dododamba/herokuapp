<template>

    <modal-layouts @click.left="clearModal" @keydown.esc="clearModal" id="addRecord" name="addRecord">

        <template slot="heading"> Creer Annonce</template>

        <template slot="main">

            <div class="form-group">
                <label for="name">Name</label>

                <input @keydown="delete errors.name"
                       class="form-control"
                       id="name"
                       name="name"
                       type="text"
                       v-model="record.name">

                <span class="text-danger" v-if="errors.name">
					<small v-text="errors.name[0]"></small>
				</span>
            </div>

            <div class="form-group">
                <label for="email">E-Mail</label>

                <input @keydown="delete errors.email"
                       class="form-control"
                       id="email"
                       name="email"
                       type="email"
                       v-model="record.email">

                <span class="text-danger" v-if="errors.email">
					<small v-text="errors.email[0]"></small>
				</span>
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>

                <input @keydown="delete errors.phone"
                       class="form-control"
                       id="phone"
                       name="phone"
                       type="text"
                       v-model="record.phone">

                <span class="text-danger" v-if="errors.phone">
					<small v-text="errors.phone[0]"></small>
				</span>
            </div>
        </template>

        <template slot="footer">
            <button @click="clearModal"
                    class="btn btn-outline-secondary"
                    data-dismiss="modal"
                    type="button">Close
            </button>

            <button @click="saveRecord" class="btn btn-outline-primary" type="submit">Save</button>
        </template>

    </modal-layouts>

</template>

<script>
    import ModalLayouts from '../partials/ModalLayouts'

    export default {
        data() {
            return {
                record: {},
                errors: [],
            }
        },

        components: {ModalLayouts},

        methods: {
            saveRecord() {
                axios.post('/phonebooks', this.record)
                    .then(data => {
                        this.$emit('recordAdded', data);

                        toast({
                            type: 'success',
                            title: 'Record has been added successfully!'
                        });

                        this.record = {};
                        $('#addRecord').modal('hide');
                    })
                    .catch(error => this.errors = error.response.data.errors)
            },

            clearModal() {
                this.errors = [];
                this.record = {};
            }
        }
    };
</script>