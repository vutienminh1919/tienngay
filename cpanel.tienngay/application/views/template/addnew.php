

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
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Upload Grid <span class="red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">

                <div id="SomeThing" class="simpleUploader">

                <div class="uploads ">
                  <div class="block">
                    <div class="progressBar" style="width:100%"></div>
                  </div>

                  <div class="block">
                    <div class="error">
                      Upload failed
                    </div>
                  </div>
                  <?php for ($i=0; $i < 5 ; $i++) { ?>
                    <div class="block">
                        <img src="https://www.belightsoft.com/products/imagetricks/img/intro-video-poster@2x.jpg" alt="">
                        <button type="button" class="cancelButton "><i class="fa fa-times-circle"></i></button>
                    </div>
                    <div class="block">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/0/0f/Eiffel_Tower_Vertical.JPG" alt="">
                        <button type="button" class="cancelButton "><i class="fa fa-times-circle"></i></button>
                    </div>
                  <?php } ?>
                  <label for="uploadinput">
                    <div class="block uploader">
                      <span>+</span>
                    </div>
                  </label>
              </div>

              <input id="uploadinput" type="file" name="file" multiple="" class="focus">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Upload Line <span class="red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">

                <div id="SomeThing" class="simpleUploader line">
 
                <div class="uploads ">
                  <div class="block">
                    <div class="progressBar" style="width:100%"></div>
                  </div>

                  <div class="block">
                    <div class="error">
                      Upload failed
                    </div>
                    <div class="description">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                  </div>
                  <?php for ($i=0; $i < 5 ; $i++) { ?>
                    <div class="block">
                        <img src="https://www.belightsoft.com/products/imagetricks/img/intro-video-poster@2x.jpg" alt="">
                        <button type="button" class="cancelButton "><i class="fa fa-times-circle"></i></button>
                    </div>
                    <div class="block">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/0/0f/Eiffel_Tower_Vertical.JPG" alt="">
                        <button type="button" class="cancelButton "><i class="fa fa-times-circle"></i></button>
                    </div>
                  <?php } ?>
                  <label for="uploadinput">
                    <div class="block uploader">
                      <span>+</span>
                    </div>
                  </label>
              </div>

              <input id="uploadinput" type="file" name="file" multiple="" class="focus">
              </div>
            </div>
          </div>
          <!--
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Sổ CMTND <span class="red">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="file" required class="form-control col-md-7 col-xs-12 mb-3">
            </div>
          </div>-->
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

        <table class="table table-bordered table-interest" style="vertical-align:middle;">
          <thead>
            <tr>
              <th scope="col" rowspan="2">Ngày thứ</th>
              <th scope="col" rowspan="2">Kỳ trả</th>
              <th scope="col" colspan="7">Số tiền trả hàng kỳ</th>
              <th scope="col" rowspan="2">Gốc còn ại</th>
              <th scope="col" rowspan="2">Tiền phạt tất toán sớm</th>
              <th scope="col" rowspan="2">Tiền tất toán sớm</th>
            </tr>
            <tr>
              <th scope="col">Kỳ trả</th>
              <th scope="col">Làm tròn</th>
              <th scope="col">Gốc</th>
              <th scope="col">Tổng phí lãi</th>
              <th scope="col">Phí tư vấn</th>
              <th scope="col">Phí dịch vụ</th>
              <th scope="col">Lãi</th>
            </tr>
          </thead>
          <tbody>
            <tr>

              <td>30</td>
              <td>1</td>
              <td class="text-danger">
                2.234.234
              </td>
              <td>
                2.234.234
              </td>
              <td>
                2.234.234
              </td>
              <td>
                2.234.234
              </td>
              <td>
                2.234.234
              </td>
              <td>
                2.234.234
              </td>
              <td>
                2.234.234
              </td>
              <td>
                2.234.234
              </td>
              <td class="text-danger text-right">
                2.234.234
              </td>
              <td class="text-danger text-right">
                2.234.234
              </td>
            </tr>


            <!-- Total -->
            <tfoot class="bg-warning">
              <tr>
                <td class="text-danger" colspan="2">Tổng tiền</td>
                <td class="text-danger">
                  2.234.234
                </td>
                <td class="text-danger">
                  2.234.234
                </td>
                <td>
                </td>
                <td>
                </td>
                <td class="text-danger">
                  2.234.234
                </td>
                <td class="text-danger">
                  2.234.234
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
                <td >
                </td>
              </tr>
            </tfoot>
          </tbody>
           <!-- Total -->
           <tfoot class="bg-warning">
              <tr>
                <td class="text-danger" colspan="2">Tổng tiền</td>
                <td class="text-danger">
                  2.234.234
                </td>
                <td class="text-danger">
                  2.234.234
                </td>
                <td>
                </td>
                <td>
                </td>
                <td class="text-danger">
                  2.234.234
                </td>
                <td class="text-danger">
                  2.234.234
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
                <td >
                </td>
              </tr>
            </tfoot>
        </table>
      </div>


    </div>
  </div>
  <!-- /page content -->
