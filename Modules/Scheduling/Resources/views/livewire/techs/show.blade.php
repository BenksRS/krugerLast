<div>
	<div class="card">
		<div class="card-body">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th scope="col" width="50"></th>
						<th scope="col" width="150">Name</th>
						<th scope="col">Base</th>
						<th scope="col" width="100" class="text-center">Active</th>
					</tr>
				</thead>
				<tbody wire:sortable="updateOrder" id="sortableList" class="sortable-list position-relative">
					@foreach($techs as $tech)
						@livewire('scheduling::techs.item', ['tech' => $tech], key($tech->id))
					@endforeach
				</tbody>
			</table>
		</div>
	</div>


</div>

@push('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
	<script>
      document.addEventListener('DOMContentLoaded', function () {
          var sortable = Sortable.create(document.getElementById('sortableList'), {

              onEnd: function (evt) {
                  let list = []
                  $('#sortableList tr').each(function (index) {
                      list.push({
                          value: $(this).data('id'),
                          order: index + 1
                      })
                  })
                  Livewire.emit('updateOrder', list)
              }
          })
      })
	</script>
@endpush

<style>
    .draggable--over {
        background-color: #eff2f7;

    }

    .draggable-mirror {
        visibility: hidden;
    }


    .handle {
        cursor:     move;
        text-align: center;
    }

    .handle i {

        font-size: 20px;
    }

    .sortable-list tr {
        cursor: move;
    }

    .sortable-list tr .check-active {
        cursor: pointer;
    }

</style>