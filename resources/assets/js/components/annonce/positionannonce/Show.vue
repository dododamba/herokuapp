 <template>
	
	<modal-layouts name="viewRecord">
		
		<template slot="heading">Detail : {{viewRec.libelle}}</template>

		<template slot="main">
			<div class="card-body">
				<h5 class="card-title">
					<label  class="text-dark form-control-label"><strong>Titre :</strong></label>

					<label class=" form-control-label text-primary">
						<strong>
							{{viewRec.libelle}}
						</strong>
					</label></h5>
				<p class="card-text"></p>
			</div>
			<div class="row form-group">
				<label  class="text-dark form-control-label"><strong>Créer:</strong></label>


				<label class=" form-control-label text-primary">
					<strong>
						Le {{viewRec.description}}
					</strong>
				</label>


			</div>
		</template>

		<template slot="footer">
			<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Fermer</button>
		</template>

	</modal-layouts>

</template>

<script>
	import ModalLayouts from '../partials/ModalLayouts'

	export default {
		props: ['viewRec'],

		components: { ModalLayouts }
	};
</script>