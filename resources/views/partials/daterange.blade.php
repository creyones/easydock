<script type="text/javascript">
	// When the document is ready
	$(document).ready(function () {

    $('#from').datepicker({
      language: "{{App::getLocale()}}",
			weekStart: 1,
      format: "dd/mm/yyyy",
      startDate: "+1d",
      endDate: "+365d",

    })
		.on('changeDate', function(selected){
		        startDate = new Date(selected.date.valueOf());
		        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())) + 1);
		        $('#until').datepicker('setStartDate', startDate);
		    });

    $('#until').datepicker({
      language: "{{App::getLocale()}}",
			weekStart: 1,
      format: "dd/mm/yyyy",
      startDate: "+1d",
      endDate: "+365d"
    });

	});
</script>
