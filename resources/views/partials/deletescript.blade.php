<script type="text/javascript">
$(document).ready( function () {
	$('#deleteModal').on('show.bs.modal', function (event) {
  	var button = $(event.relatedTarget) // Button that triggered the modal
  	var recipient = button.data('whatever') // Extract info from data-* attributes
		var objectid = button.data('id')
  	// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  	// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  	var modal = $(this)
  	modal.find('.modal-footer #delete-button').attr("href", recipient)
		modal.find('form').attr('action', recipient);
		if (objectid) {
			modal.find('.label').text(objectid);
		}
})
} );
</script>
