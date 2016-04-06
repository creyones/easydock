<script type="text/javascript">
$(document).ready(function() {

    // page is now ready, initialize the calendar...
    var startDate;
    var endDate;

    $('#calendar').fullCalendar({
      height: 450,
      selectable: true,
      selectHelper: true,
      dayRender: function (date, cell) {
        var today = new Date();
        if (date.isSame(today, 'day')) {
            cell.css("color", "#7FFFE5");
        }
    	},
      select : function (start, end, allDay) {
        startDate = start;
        endDate = end;
        $("form :input[name='block-from']").val(startDate.format("DD/MM/YYYY"));
        $("form :input[name='block-until']").val(endDate.subtract(1, 'day').format("DD/MM/YYYY"));
        //console.log(startDate.format() + "/" + endDate.subtract(1, 'day'));
      },
      eventClick: function(calEvent, jsEvent, view) {

        if(calEvent.title != '{{trans("models.fields.blocked")}}')
        {
          window.location.href='{{route("bookings.index")}}/'+calEvent.title+'/edit';
        }
      },
    })
});
</script>
