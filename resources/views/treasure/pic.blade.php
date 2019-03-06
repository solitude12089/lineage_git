@extends('layouts.modal')
@section('modal-title')
    {{$treasure->no}} - {{$treasure->item}}            持有人 : {{$treasure->owner_name->name}}
@stop
@section('modal-body')
   
              <div class="box-body">
                 @foreach($treasure->attachments as $key => $value)
                    <div class="col-md-12">
                        <a href="{{url('fileserver/download').'/'.$value->unique_name}}">
                            <i class="fa fa-paperclip"></i>{{$value->filename}} ( {{$value->filesize}} - {{$value->username}} - {{$value->created_at}})
                        </a>
                    @if(strpos($value->mimetype, 'image') !== false)
                        <div style="width:100%">
                            <img style="max-width: 100%;" src="{{url('files').'/'.$value->disk_directory.'/'.$value->disk_filename}}"></img>
                        </div>
                    @endif
                    </div>
                  @endforeach
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