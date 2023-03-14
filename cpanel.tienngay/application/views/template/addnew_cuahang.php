<!-- page content -->
<div class="right_col" role="main">
  <div class="row">
    <div class="col-xs-12">
        <div class="page-title">
            <div class="title_left">
                <h3>Thêm mới phòng giao dịch</h3>
            </div>
            <div class="title_right text-right">

                <a href="#" class="btn btn-info ">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> Quay lại

                </a>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
              <form class="form-horizontal form-label-left">
                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        Tên phòng giao dịch <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control " placeholder="Nhập tên phòng giao dịch của bạn">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        Số điện thoại <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control " placeholder="Nhập số điện thoại phòng giao dịch">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        Tỉnh / Thành Phố <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control ">
                            <option value="1">Hà Nội</option>
                            <option value="2">Hà Giang</option>
                            <option value="4">Cao Bằng</option>
                            <option value="6">Bắc Kạn</option>
                            <option value="8">Tuyên Quang</option>
                            <option value="10">Lào Cai</option>
                            <option value="11">Điện Biên</option>
                            <option value="12">Lai Châu</option>
                            <option value="14">Sơn La</option>
                            <option value="15">Yên Bái</option>
                            <option value="17">Hòa Bình</option>
                            <option value="19">Thái Nguyên</option>
                            <option value="20">Lạng Sơn</option>
                            <option value="22">Quảng Ninh</option>
                            <option value="24">Bắc Giang</option>
                            <option value="25">Phú Thọ</option>
                            <option value="26">Vĩnh Phúc</option>
                            <option value="27">Bắc Ninh</option>
                            <option value="30">Hải Dương</option>
                            <option value="31">Hải Phòng</option>
                            <option value="33">Hưng Yên</option>
                            <option value="34">Thái Bình</option>
                            <option value="35">Hà Nam</option>
                            <option value="36">Nam Định</option>
                            <option value="37">Ninh Bình</option>
                            <option value="38">Thanh Hóa</option>
                            <option value="40">Nghệ An</option>
                            <option value="42">Hà Tĩnh</option>
                            <option value="44">Quảng Bình</option>
                            <option value="45">Quảng Trị</option>
                            <option value="46">Thừa Thiên Huế</option>
                            <option value="48">Đà Nẵng</option>
                            <option value="49">Quảng Nam</option>
                            <option value="51">Quảng Ngãi</option>
                            <option value="52">Bình Định</option>
                            <option value="54">Phú Yên</option>
                            <option value="56">Khánh Hòa</option>
                            <option value="58">Ninh Thuận</option>
                            <option value="60">Bình Thuận</option>
                            <option value="62">Kon Tum</option>
                            <option value="64">Gia Lai</option>
                            <option value="66">Đắk Lắk</option>
                            <option value="67">Đắk Nông</option>
                            <option value="68">Lâm Đồng</option>
                            <option value="70">Bình Phước</option>
                            <option value="72">Tây Ninh</option>
                            <option value="74">Bình Dương</option>
                            <option value="75">Đồng Nai</option>
                            <option value="77">Bà Rịa - Vũng Tàu</option>
                            <option value="79">Hồ Chí Minh</option>
                            <option value="80">Long An</option>
                            <option value="82">Tiền Giang</option>
                            <option value="83">Bến Tre</option>
                            <option value="84">Trà Vinh</option>
                            <option value="86">Vĩnh Long</option>
                            <option value="87">Đồng Tháp</option>
                            <option value="89">An Giang</option>
                            <option value="91">Kiên Giang</option>
                            <option value="92">Cần Thơ</option>
                            <option value="93">Hậu Giang</option>
                            <option value="94">Sóc Trăng</option>
                            <option value="95">Bạc Liêu</option>
                            <option value="96">Cà Mau</option>
                        </select>

                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        Quận / Huyện <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text"  class="form-control "></select>
                      
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        Địa chỉ
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
                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        Người đại diện
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control " placeholder="Nhập tên người đại diện của phòng giao dịch">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        Số vốn đầu tư <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control " placeholder="Số vốn đầu tư">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        Trạng thái
                    </label>
                    <div class="col-lg-6 col-sm-12 col-xs-12 ">
                      <div class="radio-inline text-primary">
                        <label>
                          <input type="radio"> Đang hoạt động
                        </label>
                      </div>
                      <div class="radio-inline text-danger">
                        <label>
                          <input type="radio" > Tạm dừng
                        </label>
                      </div>
                    </div>
                </div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-success">
                      <i class="fa fa-save"></i>
                      Lưu lại
                    </button>
                    <a href="#" class="btn btn-info ">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> Quay lại
                </a>
                  </div>
                </div>
              </form>
            </div>
        </div>
    </div>
    </div>
  </div>
    <!-- /page content -->
