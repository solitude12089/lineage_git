@extends('layouts.modal')
@section('modal-title')
  照片
@stop
@section('modal-body')
   
              <div class="box-body">
                    
                <div style="width:100%">
                    <img style="max-width: 100%;" src="{{url('files').'/'.$attachment->disk_directory.'/'.$attachment->disk_filename}}"></img>
                </div>
                  
                   
              </div>
@stop
@section('modal-footer')
    
    <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">Close</button>

@stop

<script>
 $("#ajax-modal").on('hidden.bs.modal', function () {
    $(this).data('bs.modal', null);
  });

</script>