$(document).ajaxStart(function() {
  $("#loading").show();
  var loadingHeight = window.screen.height;
  $("#loading, .right-col iframe").css('height', loadingHeight);
}).ajaxStop(function() {
  $("#loading").hide();
});

$( document ).ready(function() {
    function DataList() {
        this.initData = {};
        this.objJson = {};
        this.report1 = {};
        this.report2 = {};
        this.report3 = {};
        this.current_page = 1;
        this.records_per_page = 25;
        this.selectedIds = [];
        const PAGINATION_RANGE = 5;

        this.init = function (_initData, _report1, _report2, _report3) {
            this.initData = _initData;
            this.report1 = _report1;
            this.report2 = _report2;
            this.report3 = _report3;
            let initData = Object.keys(_initData).map((key) => [Number(key), _initData[key]]);
            this.objJson = _initData;
            this.createPanigation();
            this.changePage(1);
            $("#select-all").off().on("click", this.selectAll.bind(this));
            $('#export-excel').off().on('click', this.exportExcel.bind(this));
            $('#print-data').off().on('click', this.printData.bind(this));
            let total = document.getElementById("total");
            total.innerHTML = fomatNumber(this.objJson.length);
            this.generateTab1();
            this.generateTab2();
        }

        this.selectAll = function (event) {
            var selectedIds = [];
            $('.selected_item').prop('checked', event.target.checked);
            this.objJson.forEach(function(value, index) {
                value[1].selected = event.target.checked;

                //push selected item into array
                if (event.target.checked) {
                    selectedIds.push(value[1].id);
                }
            });
            this.selectedIds = selectedIds;
        }

        this.selectItem = function (event) {
            let _number = $(event.target).attr("data-no");
            this.objJson[_number][1].selected = event.target.checked

            //push selected item into array
            if (event.target.checked && this.selectedIds.indexOf(this.objJson[_number][1].id) === -1) {
                this.selectedIds.push(this.objJson[_number][1].id);
            } else {
                //remove unselected item
                let index = this.selectedIds.indexOf(this.objJson[_number][1].id);
                if (index > -1) {
                    this.selectedIds.splice(index, 1);
                }
            }
        }

        this.numPages = function () {
            return Math.ceil(this.objJson.length / this.records_per_page);
        }

        this.prevPage = function () {
            if (this.current_page > 1) {
                this.current_page--;
                this.changePage(this.current_page);
            }
        }

        this.nextPage = function () {
            if (this.current_page < this.numPages()) {
                this.current_page++;
                this.changePage(this.current_page);
            }
        }

        this.changePageAction = function (event) {
            var page = $(event.target).attr("data-page");
            this.changePage(page);
        }
        this.changePage = function (page) {
            let prevBtn = document.getElementById("btn_prev");
            let nextBtn = document.getElementById("btn_next");
            let listingTable = document.getElementById("listingTable");
            let pageSpan = document.getElementById("page");
            // Validate page
            if (page < 1) page = 1;
            if (page > this.numPages()) page = this.numPages();
            this.current_page = page;
            listingTable.innerHTML = "";
            for (let i = (page-1) * this.records_per_page; i < (page * this.records_per_page); i++) {
                if (this.objJson[i]) {
                    listingTable.innerHTML += this.createEL(this.objJson[i], (i + 1), true);
                }
            }
            pageSpan.innerHTML = page + '/' + this.numPages();

            if (page == 1) {
                prevBtn.classList.add("disabled");
            } else {
                prevBtn.classList.remove("disabled");
            }

            if (page == this.numPages()) {
                nextBtn.classList.add("disabled");
            } else {
                nextBtn.classList.remove("disabled");
            }
            $(".page-number.active").removeClass('active');
            $("[data-page=" + page + "]").parent().addClass('active');
            $(".selected_item").on("click", this.selectItem.bind(this));

            //show pagination range
            if (this.numPages() > PAGINATION_RANGE*2) {
                let minPage = 0;
                let maxPage = 0;
                if ((this.numPages() - Number(page)) < Number(PAGINATION_RANGE)) {
                    minPage = Number(page) - Number(PAGINATION_RANGE)*2 + (this.numPages() - Number(page));
                } else {
                    minPage = Number(page) - Number(PAGINATION_RANGE);
                    if (minPage < 1) minPage = 1;
                }

                if ((Number(page) - Number(minPage)) < Number(PAGINATION_RANGE)) {
                    maxPage = Number(page) + Number(PAGINATION_RANGE)*2 - (Number(page) - Number(minPage));
                } else {
                    maxPage = Number(page) + Number(PAGINATION_RANGE);
                    if (maxPage > this.numPages()) maxPage = this.numPages();
                }
                $(".page-number").addClass('hide-item');
                for (let i = minPage; i <= maxPage; i++) {
                    $("[data-page=" + i + "]").parent().removeClass('hide-item');
                    $("[data-page=" + i + "]").text($("[data-page=" + i + "]").attr("data-page"));
                }
                $("[data-page=" + Number(minPage - 1) + "]").parent().removeClass('hide-item');
                $("[data-page=" + Number(minPage - 1) + "]").text("...");
                $("[data-page=" + Number(maxPage + 1) + "]").parent().removeClass('hide-item');
                $("[data-page=" + Number(maxPage + 1) + "]").text("...");
            }


        }

        this.numPages = function () {
            return Math.ceil(this.objJson.length / this.records_per_page);
        }

        this.createPanigation = function () {
            $("li.page-number").remove();
            for (let i = 1; i <= this.numPages(); i++) {
                if (i == 1) {
                    $("<li class='page-item page-number active'><a class='page-link' data-page='" + i + "' href='javascript:void(0);'>" + i + "</a></li>")
                .insertBefore("#btn_next");
                } else {
                    $("<li class='page-item page-number'><a class='page-link' data-page='" + i + "' href='javascript:void(0);'>" + i + "</a></li>")
                    .insertBefore("#btn_next");
                }
            }
            $("#btn_prev").off().on("click", this.prevPage.bind(this));
            $("#btn_next").off().on("click", this.nextPage.bind(this));
            $('.pagination').off().on("click", ".page-number", this.changePageAction.bind(this));
        }

        this.createEL = function ($data, $no, $type = false, $tableId = "clone-object") {
            let _el = $("#" + $tableId).find("#clone-item").clone();
            let _columns = _el.find("td");
            let sumRow = 0;
            let isSumRow = _el.find("td[data-attr='sum']").length;
            $.each(_columns, function( index, value ) {
                let _property = $(_columns[index]).attr("data-attr");
                if (!_property || _property == "sum") {
                    return;
                }
                let splitArr = _property.split(".");
                let _value = null;
                if (splitArr.length > 1) {
                    _value = $data;
                    for (let i = 0; i < splitArr.length; i++) {
                        if (!(splitArr[i] in _value)) {
                            return;
                        }
                        _value = _value[splitArr[i]];
                    }
                } else {
                    if (!(_property in $data)) {
                        return;
                    }
                    _value = $data[_property];
                }
                let isNumber = !isNaN(_value);
                if (isNumber && isSumRow) {
                    sumRow += parseFloat(_value);
                }
                if ($(_columns[index]).attr("format-number")) {
                    _numberFormated = fomatNumber(_value);
                    $(_columns[index]).text(_numberFormated);
                } else if ($(_columns[index]).attr("zero-before") && _value) {
                    $(_columns[index]).text("'" + _value);
                } else if ($(_columns[index]).attr("timestamp")) {
                    let toDate = timestampToDate(_value);
                    $(_columns[index]).text(toDate);
                } else if ($(_columns[index]).attr("func")) {
                    let val = window[$(_columns[index]).attr("func")](_value);
                    $(_columns[index]).text(val);
                } else {
                    $(_columns[index]).text(_value);
                }
            });
            if (isSumRow) {
                _el.find("td[data-attr='sum']").text(sumRow);
            }
            if($type) {
                //export and print case
                _el.find("#transaction_no").text($no);
            } else {
                // nomal case
                _el.find("#selected_item").attr("data-no", $no);
            }

            _el.find("#details-show-info__id__").attr("data-id", $data.id);
            _el.find("#details-show-info__id__").attr("href", "tran-detail/" + $data.id);

            if ($data.selected) {
                _el.find("#selected_item").attr('checked', true);
            } else {
                _el.find("#selected_item").attr('checked', false);
            }
            return _el.html();
        }

        this.exportExcel = function (event) {
            event.preventDefault();
            let _filename = $(event.target).attr("file-name");
            let _tableClone = $(event.target).attr("clone-table");
            let _rows = "";
            let count = 1;
            for (let i = 0; i < this.objJson.length; i++) {
                _rows += '<tr>' + this.createEL(this.objJson[i], count, true, _tableClone) + '</tr>';
                count++;
            }

            // let _tableExport = $("#" + _tableClone).clone();
            // _tableExport.find('th:last-child').remove();
            // _tableExport.find("#table-rows").html($.parseHTML(_rows));
            // _tableExport.table2excel({
            //     exclude: ".no-export",
            //     name: "Worksheet Name",
            //     filename: _filename + ".xls", // do include extension
            //     preserveColors: false // set to true if you want background colors and font colors preserved
            // });

            let _tableExport = document.getElementById(_tableClone).cloneNode(true);
            // _tableExport.querySelector('th:last-child').remove();
            _tableExport.querySelector("#table-rows").innerHTML = _rows;

            // REPORT 1
            let _report1Clone = $(event.target).attr("report-table1");
            // _rows = "";
            // count = 1;
            // for (let i = 0; i < this.report1.length; i++) {
            //     console.log(this.report1[i]);
            //     _rows += '<tr>' + this.createEL(this.report1[i], count, true, _report1Clone) + '</tr>';
            //     count++;
            // }
            let _report1Export = document.getElementById(_report1Clone).cloneNode(true);
            let _report1ExportCaption = _report1Export.caption.innerHTML;
            // _reportExport.querySelector('th:last-child').remove();
            // _report1Export.querySelector("#table-rows").innerHTML = _rows;


            // REPORT 2
            let _report2Clone = $(event.target).attr("report-table2");
            // _rows = "";
            // count = 1;
            // for (let i = 0; i < this.report2.length; i++) {
            //     console.log(this.report2[i]);
            //     _rows += '<tr>' + this.createEL(this.report2[i], count, true, _report2Clone) + '</tr>';
            //     count++;
            // }
            let _report2Export = document.getElementById(_report2Clone).cloneNode(true);
            let _report2ExportCaption = _report2Export.caption.innerHTML;
            // _reportExport.querySelector('th:last-child').remove();
            // _report2Export.querySelector("#table-rows").innerHTML = _rows;

            // REPORT 3
            let _report3Clone = $(event.target).attr("report-table3");
            // _rows = "";
            // count = 1;
            // for (let i = 0; i < this.report3.length; i++) {
            //     console.log(this.report3[i]);
            //     _rows += '<tr>' + this.createEL(this.report3[i], count, true, _report3Clone) + '</tr>';
            //     count++;
            // }
            let _report3Export = document.getElementById(_report3Clone).cloneNode(true);
            let _report3ExportCaption = _report3Export.caption.innerHTML;
            // _reportExport.querySelector('th:last-child').remove();
            // _report3Export.querySelector("#table-rows").innerHTML = _rows;

            var main = XLSX.utils.table_to_sheet(_tableExport);
            var tb1 = XLSX.utils.table_to_sheet(_report1Export);
            var tb2 = XLSX.utils.table_to_sheet(_report2Export);
            var tb3 = XLSX.utils.table_to_sheet(_report3Export);
            var wb = XLSX.utils.book_new();
            let tb1_tmp = XLSX.utils.sheet_to_json(tb1, { header: 1 })
            let tb2_tmp = XLSX.utils.sheet_to_json(tb2, { header: 1 });
            let tb3_tmp  = XLSX.utils.sheet_to_json(tb3, { header: 1 });
            tb2_tmp = [[_report2ExportCaption]].concat(tb2_tmp).concat([""]).concat([[_report3ExportCaption]]).concat(tb3_tmp);
            tb1_tmp = [[_report1ExportCaption]].concat(tb1_tmp);
            let wb1 = XLSX.utils.json_to_sheet(tb2_tmp, { skipHeader: true });
            let wb2 = XLSX.utils.json_to_sheet(tb1_tmp, { skipHeader: true })

            XLSX.utils.book_append_sheet(wb, main, "Form thông tin");
            XLSX.utils.book_append_sheet(wb, wb1, "Tổng hợp 1");
            XLSX.utils.book_append_sheet(wb, wb2, "Tổng hợp 2");

            return XLSX.writeFile(wb, _filename + '.xlsx');
        }

        this.generateTab1 = function () {
            console.log("generateTab1");
            console.log(this.report2);
            let _report2Export = document.getElementById("report-object2");
            let sum = {};
            let _el = $("#" + _report2Export.id).find("#clone-item").clone();
            let _columns = _el.find("td");
            $.each(_columns, function( index, value ) {
                let _property = $(_columns[index]).attr("data-attr");
                let total_column = $(_columns[index]).attr("total-column");
                if (!_property || !total_column) {
                    return;
                }
                sum[_property] = 0;
            });
            _rows = "";
            count = 1;
            for (let i = 0; i < this.report2.length; i++) {
                let _el = this.createEL(this.report2[i], count, true, _report2Export.id);
                _rows += '<tr>' + _el + '</tr>';
                count++;
                $.each( $(_el), function( key, value ) {
                    let arrKey = $(value).attr("data-attr");
                    let arrVal =  $(value).text();
                    let isNumber = !isNaN(arrVal);
                    if (arrKey && isNumber) {
                        sum[arrKey] += parseFloat(arrVal);
                    }
                });
            }

            _rows += '<tr>';
            let first = true;
            $.each(_columns, function( index, value ) {
                if (first) {
                    _rows += '<td>Tổng</td>';
                    first = false;
                    return true;
                }
                _rows += '<td>';
                let _property = $(_columns[index]).attr("data-attr");
                let total_column = $(_columns[index]).attr("total-column");
                if (
                    !_property || 
                    !total_column || 
                    _property == "avg_request_delay_time" || 
                    _property == "avg_resend_request_time" || 
                    _property == "avg_request_delay_time_tat_toan" || 
                    _property == "avg_request_delay_time_mien_giam" || 
                    _property == "avg_request_delay_time_gia_han_co_cau"
                ) {
                    _rows += "";
                } else {
                    _value = Math.round(sum[_property] * 100) / 100;
                    _rows += _value;
                }
                _rows += '</td>';
            });
            _rows += '</tr>';
            _report2Export.querySelector("#table-rows").innerHTML = _rows;


            // REPORT 3
            let _report3Export = document.getElementById("report-object3")
            sum = {};
            _el = $("#" + _report3Export.id).find("#clone-item").clone();
            _columns = _el.find("td");
            $.each(_columns, function( index, value ) {
                let _property = $(_columns[index]).attr("data-attr");
                let total_column = $(_columns[index]).attr("total-column");
                if (!_property || !total_column) {
                    return;
                }
                sum[_property] = 0;
            });
            _rows = "";
            count = 1;
            for (let i = 0; i < this.report3.length; i++) {
                let _el = this.createEL(this.report3[i], count, true, _report3Export.id);
                _rows += '<tr>' + _el + '</tr>';
                count++;
                $.each( $(_el), function( key, value ) {
                    let arrKey = $(value).attr("data-attr");
                    let arrVal =  $(value).text();
                    let isNumber = !isNaN(arrVal);
                    if (arrKey && isNumber) {
                        sum[arrKey] += parseFloat(arrVal);
                    }
                });
            }
            
            _rows += '<tr>';
            first = true;
            $.each(_columns, function( index, value ) {
                if (first) {
                    _rows += '<td>Tổng</td>';
                    first = false;
                    return true;
                }
                _rows += '<td>';
                let _property = $(_columns[index]).attr("data-attr");
                let total_column = $(_columns[index]).attr("total-column");
                if (!_property || !total_column) {
                    _rows += "";
                } else {
                    _value = Math.round(sum[_property] * 100) / 100;
                    _rows += _value;
                }
                _rows += '</td>';
            });
            _rows += '</tr>';
            _report3Export.querySelector("#table-rows").innerHTML = _rows;
        }

        this.generateTab2 = function () {
            let _report1Export = document.getElementById("report-object1");
            _rows = "";
            count = 1;
            let sum = {};
            let _el = $("#" + _report1Export.id).find("#clone-item").clone();
            let _columns = _el.find("td");
            $.each(_columns, function( index, value ) {
                let _property = $(_columns[index]).attr("data-attr");
                let total_column = $(_columns[index]).attr("total-column");
                if (!_property || !total_column) {
                    return;
                }
                sum[_property] = 0;
            });

            for (let i = 0; i < this.report1.length; i++) {
                let _el = this.createEL(this.report1[i], count, true, _report1Export.id);
                _rows += '<tr>' + _el + '</tr>';
                count++;
                $.each( $(_el), function( key, value ) {
                    let arrKey = $(value).attr("data-attr");
                    let arrVal =  $(value).text();
                    let isNumber = !isNaN(arrVal);
                    if (arrKey && isNumber) {
                        sum[arrKey] += parseFloat(arrVal);
                    }
                });
            }
             _rows += '<tr>';
            let first = true;
            $.each(_columns, function( index, value ) {
                if (first) {
                    _rows += '<td>Tổng</td>';
                    first = false;
                    return true;
                }
                _rows += '<td>';
                let _property = $(_columns[index]).attr("data-attr");
                let total_column = $(_columns[index]).attr("total-column");
                if (!_property || !total_column) {
                    _rows += "";
                } else {
                    _value = Math.round(sum[_property] * 100) / 100;
                    _rows += _value;
                }
                _rows += '</td>';
            });
            _rows += '</tr>';
            _report1Export.querySelector("#table-rows").innerHTML = _rows;
            
        }

        this.printData = function (event) {
            event.preventDefault();
            let _tableClone = $(event.target).attr("clone-table");
            let _rows = "";
            let count = 1;
            for (let i = 0; i < this.objJson.length; i++) {
                if (this.objJson[i][1].selected) {
                    _rows += '<tr>' + this.createEL(this.objJson[i][1], count, true) + '</tr>';
                    count++;
                }
            }

            let _tableExport = $("#" + _tableClone).clone();
            _tableExport.find("#table-rows").html($.parseHTML(_rows));
            _tableExport.removeAttr('hidden');
            _tableExport.find('th:last-child, td:last-child').hide();
            var win = window.open();
            win.document.write(_tableExport.prop("outerHTML"));
            win.print();
            win.close()

        }

        fomatNumber = function ($value) {
            $value = parseInt($value);
            if ($value > 0 || $value < 0) {
                return $value.toLocaleString('en-US');
            }
            return 0;
        }

        timestampToDate = function ($value) {
            $value = parseInt($value);
            if ($value > 0) {
                var date = new Date($value * 1000).toLocaleDateString("vi-VN");
                return date;
            }
            return "";
        }
    };


    //create object
    var transactionObj = new DataList();
    var _token = $('[name="_token"]').val();
    function initPage (_itemList, _report1, _report2, _report3) {
        if (transactionObj) {
            transactionObj = null;
        }
        transactionObj = new DataList();
        transactionObj.init(_itemList, _report1, _report2, _report3);

    }
    initPage(transactions, report1, report2, report3);

    var selectMonth = $("#select-time").datepicker( {
        format: "yyyy-mm",
        startView: "months",
        minViewMode: "months",
        autoclose: true
    });

    selectMonth.on('change', function (e) {
       let _month = $("#select-time").val();
        let data = {
            time : _month,
            _token: _token
        };
        $.ajax({
            type: "POST",
            url: getListByMonthUrl,
            data: data,
            success: function(data) {
                console.log(data);
                if (data['status'] == 200) {
                    console.log(data['data']);
                    transactions = data['data']['data'];
                    initPage(transactions);
                    $("#total_transaction").text(data['data']['totalTransaction']);
                    $("#total_paid_amount").text(data['data']['totalAmount']);
                } else {
                    $("#errorModal").find(".msg_error").text(data['message']);
                    $("#errorModal").show();
                }
            },
            error: function (jqXHR, exception) {
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }
                $("#errorModal").show();
            },
         });
    });

    //search form
    $('#submit-data').on('click', function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        $("#submit-data").prop('disabled', true);

        var form = $("#search-form");
        form.find('input:text').each(function(){
            $(this).val($.trim($(this).val()));
        });
        var url = form.attr('action');
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            success: function(data) {
                var errorModal = new bootstrap.Modal(document.getElementById('errorModal'))
                if($.isEmptyObject(data)) {
                    $("#errorModal").find(".msg_error").text("Có lỗi xảy ra trong quá trình tìm kiếm");
                    errorModal.show();
                } else if (data['status'] == 200) {
                    console.log(data['data']);
                    transactions = data['data']['result'];
                    let report1 = data['data']['report1'];
                    let report2 = data['data']['report2'];
                    let report3 = data['data']['report3'];
                    initPage(transactions, report1, report2, report3);
                } else {
                    $("#errorModal").find(".msg_error").text(data['message']);
                    errorModal.show();
                }
                $("#submit-data").prop('disabled', false);
                $("#fillter-content").hide();

            },
            error: function (jqXHR, exception) {
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }
                $("#submit-data").prop('disabled', false);
                $("#errorModal").find(".msg_error").text(msg);
                $("#errorModal").show();
            },
         });
    });

    $("#search-input").on("change", function (event) {
        event.preventDefault();
        var _searchValue = $("#search-input").val();
        console.log(_searchValue);
        var _regex = new RegExp(_searchValue,"g");
        var _result = [];
        if (!_searchValue) {
            _result = transactions;
        } else {
            transactions.forEach(function(value, index) {
                let valueJSON = JSON.stringify(value);
                let search = valueJSON.match(_regex);
                if (search !== null) {
                    _result.push(value)
                }
            });
        }
        initPage(_result);
    });
});
