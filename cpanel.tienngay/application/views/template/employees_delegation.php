

<link href="<?php echo base_url();?>assets/teacupplugin/jstree/dist/themes/default/style.min.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/teacupplugin/jstree/dist/jstree.min.js"></script>
<!-- page content -->
<div class="right_col" role="main">

  <div class="row top_tiles">
    <div class="col-xs-12">
      <div class="page-title">

        <h3>Employees Delegation</h3>

      </div>
    </div>


    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">

        <div class="x_content">
          <div class="row">

            <div class="col-xs-12 form-horizontal form-label-left">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nhân viên <span class="text-danger">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control">
                    <option>Choose option</option>
                    <option>Option one</option>
                    <option>Option two</option>
                    <option>Option three</option>
                    <option>Option four</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">
                  Chức năng
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div id="EmployeesDelegation" class="tree-demo">
                    <ul class="to_do">
                            <li>

                                Schedule meeting with new client
                                <ul>
                                  <li>
                                      Copy backups to offsite location
                                  </li>
                                  <li>
                                      Food truck fixie locavors mcsweeney
                                  </li>
                                  <li>
                                      Food truck fixie locavors mcsweeney
                                  </li>
                                  <li>
                                      Create email address for new intern
                                  </li>
                                  <li>
                                      Have IT fix the network printer
                                  </li>
                                </ul>
                            </li>
                            <li>
                                Create email address for new intern
                            </li>
                            <li>
                                Have IT fix the network printer
                            </li>
                            <li>
                                Copy backups to offsite location
                            </li>
                            <li>
                                Food truck fixie locavors mcsweeney
                            </li>
                            <li>
                                Food truck fixie locavors mcsweeney
                            </li>
                            <li>
                                Create email address for new intern
                            </li>
                            <li>
                                Have IT fix the network printer
                            </li>
                            <li>
                                Copy backups to offsite location
                            </li>
                          </ul>
                  </div>

                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->

<script>
  $('#EmployeesDelegation').jstree({
            'plugins': ["wholerow", "checkbox", "types"],
            'core': {
                "check_callback": false,
                "themes": {
                    "responsive": false
                },
            },
            "types": {
                "default": {
                    "icon": "fa fa-folder text-warning"
                },
                "file": {
                    "icon": "fa fa-file text-warning"
                }
            },
        });
</script>
