<!-- page content -->
<div class="right_col" role="main">

  <div class="col-xs-12">
    <div class="page-title">
      <div class="title_left">
        <h3>Thêm mới một cái gì đó</h3>
      </div>
      <div class="title_right text-right">


        <a href="#" class="btn btn-info ">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
            Quay lại

        </a>
      </div>
    </div>
  </div>

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
                    <h2>Some Text</h2>

        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form class="form-horizontal form-label-left">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Phòng giao dịch <span class="red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" required class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ngày tháng
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">

              <div class='input-group date' id='myDatepicker'>
                <input type='text' class="form-control" />
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
              </div>
              <script>
              $('#myDatepicker').datetimepicker();
              </script>
            </div>
          </div>


          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Switch</label>
            <div class="col-md-9 col-sm-9 col-xs-12">

              <div class="radio-inline text-primary">
                <label>
                  <input type="radio" name="thefilter" value=""> Đang hoạt động
                </label>
              </div>
              <div class="radio-inline text-danger">
                <label>
                  <input type="radio" name="thefilter" value=""> Tạm dừng
                </label>
              </div>


            </div>
          </div>


          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Địa chỉ
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="autocompleteAddress" placeholder="Nhập địa chỉ" onFocus="geolocate()" class="form-control"  type="text"/>
              <script>
              // This sample uses the Autocomplete widget to help the user select a
              // place, then it retrieves the address components associated with that
              // place, and then it populates the form fields with those details.
              // This sample requires the Places library. Include the libraries=places
              // parameter when you first load the API. For example:
              // <script
              // src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

              var placeSearch, autocomplete;

              var componentForm = {
                street_number: 'short_name',
                route: 'long_name',
                locality: 'long_name',
                administrative_area_level_1: 'short_name',
                country: 'long_name',
                postal_code: 'short_name'
              };

              function initAutocomplete() {
                // Create the autocomplete object, restricting the search predictions to
                // geographical location types.
                autocomplete = new google.maps.places.Autocomplete(
                  document.getElementById('autocompleteAddress'), {types: ['geocode']});

                  // Avoid paying for data that you don't need by restricting the set of
                  // place fields that are returned to just the address components.
                  autocomplete.setFields(['address_component']);

                  // When the user selects an address from the drop-down, populate the
                  // address fields in the form.
                  autocomplete.addListener('place_changed', fillInAddress);
                }

                function fillInAddress() {
                  // Get the place details from the autocomplete object.
                  var place = autocomplete.getPlace();

                  for (var component in componentForm) {
                    document.getElementById(component).value = '';
                    document.getElementById(component).disabled = false;
                  }

                  // Get each component of the address from the place details,
                  // and then fill-in the corresponding field on the form.
                  for (var i = 0; i < place.address_components.length; i++) {
                    var addressType = place.address_components[i].types[0];
                    if (componentForm[addressType]) {
                      var val = place.address_components[i][componentForm[addressType]];
                      document.getElementById(addressType).value = val;
                    }
                  }
                }

                // Bias the autocomplete object to the user's geographical location,
                // as supplied by the browser's 'navigator.geolocation' object.
                function geolocate() {
                  if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                      var geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                      };
                      var circle = new google.maps.Circle(
                        {center: geolocation, radius: position.coords.accuracy});
                        autocomplete.setBounds(circle.getBounds());
                      });
                    }
                  }
                  </script>
                  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBEDobJT-2whNlvWfui-WTkLiZIatknCCE&libraries=places&callback=initAutocomplete" async defer></script>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button class="btn btn-primary" type="button">Cancel</button>
                  <button class="btn btn-primary" type="reset">Reset</button>
                  <button type="submit" class="btn btn-success">Submit</button>
                </div>
              </div>

            </form>
          </ul>

        </div>
      </div>

      <div class="x_panel">
        <div class="x_title">
                      <h2>Some Text</h2>

          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <form class="form-horizontal form-label-left">

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Phòng giao dịch <span class="red">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" required class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ngày tháng
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">

                <div class='input-group date' id='myDatepicker'>
                  <input type='text' class="form-control" />
                  <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
                <script>
                $('#myDatepicker').datetimepicker();
                </script>
              </div>
            </div>


            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Switch</label>
              <div class="col-md-9 col-sm-9 col-xs-12">

                <div class="radio-inline text-primary">
                  <label>
                    <input type="radio" name="thefilter" value=""> Đang hoạt động
                  </label>
                </div>
                <div class="radio-inline text-danger">
                  <label>
                    <input type="radio" name="thefilter" value=""> Tạm dừng
                  </label>
                </div>


              </div>
            </div>

                <div id="form1" class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Thêm Form
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">

                    <div class='input-group '>
                      <input type='text' class="form-control" />
                      <span class="input-group-btn">
                        <button class="btn btn-danger" onclick="$('#form1').remove()">
                          <i class="fa fa-times"></i> XÓA
                        </button>
                      </span>
                    </div>

                  </div>
                </div>
                <div id="form2" class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Thêm Form
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">

                    <div class='input-group '>
                      <input type='text' class="form-control" />
                      <span class="input-group-btn">
                        <button class="btn btn-danger" onclick="$('#form2').remove()">
                          <i class="fa fa-times"></i> XÓA
                        </button>
                      </span>
                    </div>

                  </div>
                </div>

                <div id="addForm" class="form-group">
                  <div class="col-md-3 col-sm-3 col-xs-12">

                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <button type="button" class="btn btn-info"><i class="fa fa-plus"></i>  THÊM MỘT CÁI GÌ ĐÓ</button>
                  </div>
                </div>
              </form>
            </ul>

          </div>
        </div>
    </div>
  </div>
  <!-- /page content -->
