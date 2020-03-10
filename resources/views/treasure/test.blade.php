
 <form id='addform' class="form-horizontal" action="{{Request::url()}}" method="post" enctype="multipart/form-data">
             
      <div class="box-body">
              
                <div class="form-group">
                  <label for="_note" class="col-sm-2 control-label">照片<label style="color:red">*</label></label>

                  <div class="col-sm-10">
                    <input type="file"  class="form-control" id="_file" name="_file[]" accept="image/x-png,image/gif,image/jpeg"/>
                  </div>
                </div>

                <button id="dopost" type="submit" class="btn btn-primary">存檔</button>

      </div>
    </form>

