<template>

	<modal-layouts name="editRecord" id="editRecord">
		
		<template slot="heading">Editions : {{editRec.libelle}}</template>

		<template slot="main">







			<div class="form-group">
				<label for="libelle">Libelle :</label>

				<input type="text" 
					   name="libelle"
					   id="libelle"
					   class="form-control text-primary"
					   v-model="editRec.libelle"
					   @keydown="delete errors.libelle">

				<span v-if="errors.libelle" class="text-danger">
					<small v-text="errors.libelle[0]"></small>
				</span>
			</div>

			<div class="form-group">
				<label for="description">Description :</label>

				<textarea name="description" id="description" v-model="editRec.description"
						  @keydown="delete errors.description"
						  rows="9" placeholder="Contenue de l'annonce" class="form-control text-primary"></textarea>

				<span v-if="errors.description" class="text-danger">
					<small v-text="errors.description[0]"></small>
				</span>
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
	Vue.use( axios);

	export default {
		props: ['editRec'],

		data() {
			return {
				errors: [],
			}
		},

		components: { ModalLayouts },

		methods: {
			updateRecord() {
				axios.put(`/api/positionannonce/${this.editRec.slug}`, this.editRec)
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