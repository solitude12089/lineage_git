<div class="modal-dialog" style="width: 70%;">
    <div class="modal-content">
      <div class="modal-header" style="font-size: 26px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        @yield('modal-title')
      </div>
      <div class="modal-body">
        @yield('modal-body')
      </div>
      <div class="modal-footer">
         @yield('modal-footer')
      </div>
    </div>
    <!-- /.modal-content -->
</div>
<input type="hidden" name="_token" value="{{ csrf_token() }}">
@yield('modal-script')

  <!-- /.modal-dialog -->
