<!-- page content -->
<div class="right_col" role="main">
  <div class="row">
    <div class="col-xs-12">
      <div class="page-title">
        <h3>Menu Control 2</h3>
      </div>
    </div>

    <div class="col-xs-12">
      <div class="row">
        <div class="col-xs-12 col-md-6 col-lg-4">
          <div class="x_panel">
            <div class="x_title">
              <h2>Add new something</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">

              <form>
                <div class="form-group">
                  <label >Name</label>
                  <input  class="form-control" >
                  <small class="form-text text-muted">Some desc text</small>
                </div>

                <div class="form-group">
                  <label >Select parent</label>
                  <select name="parent" class="form-control">
                    <option >None</option>
                    <option>demo somthing</option>
                    <option>&nbsp;&nbsp;&nbsp;lv2b</option>
                    <option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;lv2b</option>
                    <option>Tin tức</option>
                  </select>
                  <small iclass="form-text text-muted">Some desc text</small>
                </div>
                <div class="form-group">
                  <label >Descriptions</label>
                  <textarea name="name" rows="8" class="form-control"></textarea>
                  <small iclass="form-text text-muted">Some desc text</small>z
                </div>
                <button type="submit" class="btn btn-primary">Add new something</button>
              </form>
            </div>
          </div>
        </div>

        <div class="col-xs-12 col-md-6 col-lg-8">
          <div class="x_panel">
            <div class="x_content">

              <table class="table table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>Descriptions</th>
        <th class="text-right">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php for ($i=0; $i < 5; $i++) { ?>

      <tr>
        <td>John</td>
        <td>---</td>
        <td class="text-right">
          <button class="btn btn-primary"  data-toggle="modal" data-target="#editModal">
            <i class="fa fa-edit"></i>
            Edit
          </button>
          <button class="btn btn-danger mr-0">
            <i class="fa fa-close"></i>
            Delete
          </button>
        </td>
      </tr>
        <?php } ?>
    </tbody>
  </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</div>
<!-- /page content -->
<div id="editModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit </h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label >Name</label>
            <input  class="form-control" >
            <small class="form-text text-muted">Some desc text</small>
          </div>

          <div class="form-group">
            <label >Select parent</label>
            <select name="parent" class="form-control">
              <option >None</option>
              <option>demo somthing</option>
              <option>&nbsp;&nbsp;&nbsp;lv2b</option>
              <option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;lv2b</option>
              <option>Tin tức</option>
            </select>
            <small iclass="form-text text-muted">Some desc text</small>
          </div>
          <div class="form-group">
            <label >Descriptions</label>
            <textarea name="name" rows="8" class="form-control"></textarea>
            <small iclass="form-text text-muted">Some desc text</small>z
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fa fa-close"></i>  Cancel</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-save"></i> Save</button>
      </div>
    </div>

  </div>
</div>


<script>
    $(window).on('load',function(){
        $('#editModal').modal('show');
    });
</script>
