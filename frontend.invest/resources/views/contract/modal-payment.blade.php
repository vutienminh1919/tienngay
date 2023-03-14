<div class="row mb-2 block-payment-contract" style="display: none;align-items: end;">
    <div class="col-md-12">
        <div class="row" style="align-items: end;padding: 0">
            <div class="col">
                <div class="row col-child" style="align-items: end">
                    <div class="col-md-4">
                        <button type="button" class="btn btn-success btn-confirm">
                            <span><i class="fa fa-credit-card"></i>&nbsp;Thanh toán</span>
                        </button>
                        <button type="button" class="btn btn-secondary btn-cancel">
                            <span><i class="fa fa-times-circle"></i>&nbsp;Hủy</span>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="{{asset('project_js/contract/select.js')}}"></script>

<style>

    @media (min-width: 768px) {
        .col-md-11 {
            flex: 0 0 auto;
            width: 88.666667%;
        }

        .col-md-1 {
            flex: 0 0 auto;
            width: 11.333333%;
        }

        .col-md-3 {
            width: 20%;
        }

        .col-md-9 {
            width: 80%;
        }

        .btn-success {

        }
    }

    @media (min-width: 865px) {
        .col-md-11 {
            flex: 0 0 auto;
            width: 73.666667%;
        }

        .col-md-1 {
            flex: 0 0 auto;
            width: 25.333333%;
        }

        .btn-success {

        }
    }

    @media (max-width: 768px) {
        .col-md-11 {
            flex: 0 0 auto;
            width: 76.666667%;
        }

        .col-md-1 {
            flex: 0 0 auto;
            width: 23.333333%;
        }

        .btn-success {

        }
    }

    @media (max-width: 767px) {
        .col-md-11 {
            flex: 0 0 auto;
            width: 100%;
        }

        .col-md-1 {
            flex: 0 0 auto;
            width: 100%;
        }

        .btn-success {

        }
    }
</style>
