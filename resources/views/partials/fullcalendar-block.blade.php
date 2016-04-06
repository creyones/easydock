<script type="text/javascript">
$(document).ready(function() {

  $('form :submit').on('click', function(event){

    var form = $('form');
    var id = $(this).attr('id');
    var action = $('form').attr( 'action' );
    var base = action.substr(0, action.lastIndexOf("/"));
    $('form').attr('action', base + '/' + id);
    //$('form').submit();
  });
});
</script>
