@extends('layouts.modal')
@section('modal-title')
    {{$note->no}} 流程紀錄
@stop
@section('modal-body')
      
        <div class="box-body">
          <div class="form-group" style="overflow: auto;max-height: 500px;">
              @foreach($note->statuslogs as $key => $value)
                <blockquote>
                  <p>{{$value->msg}}</p>
                  <small>{{$value->username}} <cite title="Source Title">{{$value->created_at}}</cite></small>
                </blockquote>
              @endforeach
             
          </div>

               

        </div>
  
@stop
@section('modal-footer')
    <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">取消</button>
@stop

<script>
 
  $("#ajax-modal").on('hidden.bs.modal', function () {
    $(this).data('bs.modal', null);
  });


 

</script>