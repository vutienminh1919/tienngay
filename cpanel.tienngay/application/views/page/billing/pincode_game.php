<div class="right_col" role="main">

  <div class="row">
    <div class="col-xs-12">
      <div class="page-title">
        <h3>Mua thẻ / Nạp tiền game Online</h3>

      </div>
    </div>
    <div class="col-xs-12 col-lg-8">
      <div class="x_panel panel_phonecard" >
        <div class="x_content">
          <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab1" class="nav nav-tabs " role="tablist">
              <li role="presentation" ><a href="<?php echo base_url("VimoBilling/topupGame")?>" >Nạp thẻ tài khoản game</a>
              </li>
              <li role="presentation" class="active"><a href="#" >Mua mã thẻ game</a>
              </li>
            </ul>
            <div id="myTabContent2" class="tab-content">

            <div role="tabpanel" class="tab-pane active in" id="tab_buyingcode" aria-labelledby="tab_buyingcode">
              <div class="card-body">
                <ul class="selecttype">
                <?php 
                      if(!empty($service)){
                        $publisher = $service->publisher;
                        $publisher_code =  $publisher[0]->code;
                        $publisher_name = $publisher[0]->name;
                        $publisher_logo = $publisher[0]->logo;
                        foreach($publisher as $key =>  $value){
                          if($key == 0){
                            $checked ="checked";
                          }else{
                            $checked ="";
                          }
                    ?>
                    <li>
                      <input id="selecttype_<?= !empty($value->code) ? $value->code : "" ?>" data-logo="<?= !empty($value->logo) ? $value->logo : "" ?>" data-name="<?= !empty($value->name) ? $value->name : "" ?>" data-code="<?= !empty($value->code) ? $value->code : "" ?>"  onclick="selectPublisher(this)" type="radio" name="selecttype" <?= !empty($checked) ? $checked : "" ?>>
                      <label for="selecttype_<?= !empty($value->code) ? $value->code : "" ?>">
                        <img class="logo" src="<?php echo base_url();?><?= !empty($value->logo) ? $value->logo : "" ?>" alt="">
                        <img class="checked" src="<?php echo base_url();?>assets/imgs/icon/icon_checked.png" alt="">
                      </label>

                    </li>
                    <?php }}?>

                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Mệnh giá thẻ : </h5>
                <div class="row selectmoney">
                <div class="col-xs-4">
                    <input id="selectmoney_cardcode_10000" data-money="10000" onclick="selectMoneyCard(this)" type="radio" name="selectmoney" checked>
                    <label for="selectmoney_cardcode_10000" >10.000</label>
                  </div>
                  <div class="col-xs-4">
                    <input id="selectmoney_cardcode_20000" data-money="20000"  onclick="selectMoneyCard(this)" type="radio" name="selectmoney">
                    <label for="selectmoney_cardcode_20000">20.000</label>
                  </div>
                  <div class="col-xs-4">
                    <input id="selectmoney_cardcode_30000" data-money="30000"  onclick="selectMoneyCard(this)" type="radio" name="selectmoney">
                    <label for="selectmoney_cardcode_30000">30.000</label>
                  </div>
                  <div class="col-xs-4">
                    <input id="selectmoney_cardcode_50000" data-money="50000"  onclick="selectMoneyCard(this)" type="radio" name="selectmoney">
                    <label for="selectmoney_cardcode_50000">50.000</label>
                  </div>
                  <div class="col-xs-4">
                    <input id="selectmoney_cardcode_100000" data-money="100000"  onclick="selectMoneyCard(this)" type="radio" name="selectmoney">
                    <label for="selectmoney_cardcode_100000">100.000</label>
                  </div>
                  <div class="col-xs-4">
                    <input id="selectmoney_cardcode_200000" data-money="200000" onclick="selectMoneyCard(this)" type="radio" name="selectmoney">
                    <label for="selectmoney_cardcode_200000">200.000</label>
                  </div>
                  <div class="col-xs-4">
                    <input id="selectmoney_cardcode_300000" data-money="300000" onclick="selectMoneyCard(this)" type="radio" name="selectmoney">
                    <label for="selectmoney_cardcode_300000">300.000</label>
                  </div>
                  <div class="col-xs-4">
                    <input id="selectmoney_cardcode_500000" data-money="500000" onclick="selectMoneyCard(this)" type="radio" name="selectmoney">
                    <label for="selectmoney_cardcode_500000">500.000</label>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <ul class="information">
                  <li>
                    Số lượng thẻ
                    <span>
                      <input type="number" name='number_card' class="form-group text-right" min="1" value="1" style="max-width:75px">
 
                    </span>
                  </li>
                
                  <li>
                    Thanh toán
                    <span class='money_card'>10,000đ</span>
                  </li>
                </ul>
              </div>
              <div class="card-body text-center">
                <br>
                <input  type="hidden" class="form-control " name="sevice_code_vimo" value="PINCODE_GAME"/>
                <input  type="hidden" class="form-control " name="sevice_name_vimo" value="Mua mã thẻ Game"/>
                <input  type="hidden" class="form-control " name="publisher_code" value="<?= !empty($publisher_code) ?  $publisher_code : "" ?>"/>
                <input  type="hidden" class="form-control " name="publisher_name" value="<?= !empty($publisher_name) ?  $publisher_name : "" ?>"/>
                <input  type="hidden" class="form-control " name="publisher_logo" value="<?= !empty($publisher_logo) ?  $publisher_logo : "" ?>"/>
                <input  type="hidden" class="form-control " name="money_card" value="10000"/>
                <input  type="hidden" class="form-control " name="money_card_active" value="10000"/>
                <button class="btn btn-lg btn-primary" style="min-width: 225px"
                data-toggle="modal" data-target="#resultModal">
                Tiếp tục
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>


<!-- Modal -->
<div id="resultModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:400px">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="card card-phoneresult">
        <div class="card-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <img class='src_publisher' src="<?php echo base_url();?><?= !empty($publisher_logo) ?  $publisher_logo : "" ?>" alt="">
          <p class="thephone">Mua mã thẻ game online</p>
          <p class="thetype">1 thẻ</p>
          <p class="themoney money_card">10,000đ</p>
        </div>
        <div class="card-body">
          <ul>
            <!-- <li>
              Giá khuyến mại (0đ):
              <span>49.250đ</span>
            </li> -->
            <li>
              Phí giao dịch:
              <span>Miễn phí</span>
            </li>
            <li>
              Tổng tiền thanh toán:
              <strong class='money_card'>10,000đ</strong>
            </li>
          </ul>
        </div>
        <div class="card-footer">
          <button type="button" name="button" class="btn btn-primary pincode_order_cart" >
            Xác nhận giao dịch
          </button>
          <button type="button" name="button" class="btn btn-default"  data-dismiss="modal" aria-label="Close">
            Hủy 
          </button>
        </div>
      </div>

    </div>

  </div>
</div>
<script src="<?php echo base_url();?>assets/js/billing/querybill.js"></script>
<script src="<?php echo base_url();?>assets/js/numeral.min.js"></script>

<script>
$(':input[name="number_card"]').change(function(){
    var min = $(this).attr('min');
    var qty = $(this).val();
    if (min > qty ) {
      $(this).val(min);
      return;
    }
    $(".thetype").html(qty+' thẻ');
    var money_card = $("input[name='money_card_active']").val();
    money_card = money_card*qty;
    $("input[name='money_card']").val(money_card);
    $(".money_card").html(numeral(money_card).format('0,0')+'đ');
  });
</script>
