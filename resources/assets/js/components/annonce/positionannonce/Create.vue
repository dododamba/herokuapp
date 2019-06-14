<template>
	
	<modal-layouts name="addRecord" id="addRecord" @keydown.esc="clearModal" @click.left="clearModal">
		
		<template slot="heading">AJOUT D'UNE POSITION</template>

		<template slot="main">



			<div class="form-group">
				<label for="libelle">Libelle :</label>

				<input type="text" 
					   name="libelle"
					   id="libelle"
					   class="form-control" 
					   v-model="record.libelle"
					   @keydown="delete errors.libelle">

				<span v-if="errors.libelle" class="text-danger">
					<small v-text="errors.name[0]"></small>
				</span>
			</div>

			<div class="form-group">
				<label for="description">Description :</label>

				<textarea type="text"
					   name="description"
					   id="description"
					   class="form-control" 
					   v-model="record.description"
						  @keydown="delete errors.description"></textarea>

				<span v-if="errors.contenue" class="text-danger">
					<small v-text="errors.description[0]"></small>
				</span>
			</div>


		</template>

		<template slot="footer">
			<button type="button" 
					class="btn btn-outline-secondary" 
					@click="clearModal" 
					data-dismiss="modal">Fermer</button>

			<button type="submit" class="btn btn-outline-primary" @click="saveRecord">Enregistrer</button>
		</template>

	</modal-layouts>

</template>

<script>
	import ModalLayouts from '../partials/ModalLayouts';
	import axios from 'axios';


	export default {
		data() {
			return {
				record: {},
				errors: [],
			}
		},

		components: { ModalLayouts },

		methods: {
			saveRecord() {
				axios.post('/api/positionannonce', this.record)
					.then(data => {
						this.$emit('recordAdded', data);

						toast({
						  type: 'success',
						  title: 'Position ajouter avec succes!'
						})

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