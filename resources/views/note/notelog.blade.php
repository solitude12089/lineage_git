@extends('layouts.modal')
@section('modal-title')
    {{$note->no}} 案件紀錄
@stop
@section('modal-body')
    <form id='logform' class="form-horizontal" action="{{url('note/note-log').'/'.$note->id}}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="box-body">
                <div class="form-group" style="overflow: auto;max-height: 500px;">
                    @foreach($note->logs as $key => $value)
                      <blockquote>
                        <p>{{$value->msg}}</p>
                        <small>{{$value->username}} <cite title="Source Title">{{$value->created_at}}</cite></small>
                      </blockquote>
                    @endforeach
                   
                </div>

                <div class="form-group">
                    <textarea id='tare_notlog' name="notelog" style="width:100%; height:70px"></textarea>
                </div>

        </div>
    </form>

@stop
@section('modal-footer')
    <button type="button" class="btn btn-primary" onclick="dopost()">存檔</button>
    <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">取消</button>

@stop

<script>
  var notelog = <?php echo json_encode($note->notelog); ?>;
  function dopost(){
    $('#logform').submit();
  }
  $("#ajax-modal").on('hidden.bs.modal', function () {
    $(this).data('bs.modal', null);
  });


 

</script>