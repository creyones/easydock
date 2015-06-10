
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="deleteModalLabel"><i class="fa fa-trash"></i> {{trans('views.delete_'.$model)}} <span class="label label-default"></span></h4>
      </div>
      <div class="modal-body">
        <p class="">{{trans('messages.confirm_delete_'.$model)}}</p>
      </div>
      <div class="modal-footer">
        {!! Form::open(['method'=> 'DELETE', 'action' => [$controller.'@destroy', $id], 'class' => 'form-horizontal','role'=>'form']) !!}
          <button type="button" id="cancel-button" class="btn btn-default" data-dismiss="modal">{{trans('actions.cancel')}}</button>
          {!! Form::submit( trans('actions.delete'), ['class' => 'btn btn-danger', 'id' => 'delete-button']) !!}
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
