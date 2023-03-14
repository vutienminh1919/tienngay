//Biểu đồ tài chính
var dashboard_bieudotaichinh_settings = {
  series: {
    lines: {
      show: false,
      fill: true
    },
    splines: {
      show: true,
      tension: 0.4,
      lineWidth: 1,
      fill: 0.4
    },
    points: {
      radius: 0,
      show: true
    },
    shadowSize: 2
  },
  grid: {
    verticalLines: true,
    hoverable: true,
    clickable: true,
    tickColor: "#d5d5d5",
    borderWidth: 1,
    color: '#fff'
  },
  colors: ["#1DA6BB", "#DD6616"],
  xaxis: {
    tickColor: "rgba(51, 51, 51, 0.06)",
    mode: "time",
    tickSize: [1, "day"],
    //tickLength: 10,
    axisLabel: "Date",
    axisLabelUseCanvas: true,
    axisLabelFontSizePixels: 12,
    axisLabelFontFamily: 'Verdana, Arial',
    axisLabelPadding: 10,
    scaleLabel: {
            display: true,
            labelString: 'Date'
          },
  },
  yaxis: {
    ticks: 8,
    tickColor: "rgba(51, 51, 51, 0.06)",
    axisLabel: "probability",
    scaleLabel: {
        display: true,
        labelString: 'probability'
      }
  },
  tooltip: true
}

var arr_data1 = [
  [gd(2012, 1, 1), 17],
  [gd(2012, 1, 2), 74],
  [gd(2012, 1, 3), 6],
  [gd(2012, 1, 4), 39],
  [gd(2012, 1, 5), 20],
  [gd(2012, 1, 6), 85],
  [gd(2012, 1, 7), 7]
];
var arr_data2 =[
  [gd(2012, 1, 1), 82],
  [gd(2012, 1, 2), 23],
  [gd(2012, 1, 3), 66],
  [gd(2012, 1, 4), 9],
  [gd(2012, 1, 5), 119],
  [gd(2012, 1, 6), 6],
  [gd(2012, 1, 7), 9]
];

if ($("#dashboard_bieudotaichinh").length){
  $.plot( $("#dashboard_bieudotaichinh"), [ arr_data1, arr_data2 ],  dashboard_bieudotaichinh_settings );
  console.log('dashboard_bieudotaichinh Ignited');
}

// Tổng số hợp đồng
if ($('#dashboard_totalcontracts').length){

var dashboard_totalcontracts_settings = {
    type: 'doughnut',
    tooltipFillColor: "rgba(51, 51, 51, 0.55)",
    data: {
      labels: [
        "Đã giải ngân",
        "Chưa giải ngân",
        "Chờ duyệt",
        "Đã hủy",
      ],
      datasets: [{
        data: [15, 20, 30, 10],
        backgroundColor: [
          "#3498DB",
          "gold",
          "#1ABB9C",
          "#E74C3C",
        ],
      }]
    },
    options: {
      legend: false,
      responsive: false
    }
  }

  $('#dashboard_totalcontracts').each(function(){
    var chart_element = $(this);
    var chart_doughnut = new Chart( chart_element, dashboard_totalcontracts_settings);
  });

}


// Phòng giao dịch
if ($('#dashboard_shops').length){

var dashboard_shops_settings = {
    type: 'doughnut',
    tooltipFillColor: "rgba(51, 51, 51, 0.55)",
    data: {
      labels: [
        "Hà Nội",
        "Tp. HCM",
        "Các tỉnh khác",
      ],
      datasets: [{
        data: [15, 20, 30],
        backgroundColor: [
          "#3498DB",
          "#1ABB9C",
          "gold",
        ],
      }]
    },
    options: {
      legend: false,
      responsive: false
    }
  }

  $('#dashboard_shops').each(function(){
    var chart_element = $(this);
    var chart_doughnut = new Chart( chart_element, dashboard_shops_settings);
  });

}


// Phiếu thu
if ($('#dashboard_receipt').length){

var dashboard_receipt_settings = {
    type: 'doughnut',
    tooltipFillColor: "rgba(51, 51, 51, 0.55)",
    data: {
      labels: [
        "Hóa đơn",
        "Thẻ Điện thoại",
      ],
      datasets: [{
        data: [15, 20],
        backgroundColor: [
          "#3498DB",
          "gold",
        ],
      }]
    },
    options: {
      legend: false,
      responsive: false
    }
  }

  $('#dashboard_receipt').each(function(){
    var chart_element = $(this);
    var chart_doughnut = new Chart( chart_element, dashboard_receipt_settings);
  });

}


// Thu hồi
if ($('#dashboard_debt').length){

var dashboard_debt_settings = {
    type: 'doughnut',
    tooltipFillColor: "rgba(51, 51, 51, 0.55)",
    data: {
      labels: [
        "Đúng hạn",
        "Quá hạn",
        "Gia hạn",
        "HĐ quá hạn",
      ],
      datasets: [{
        data: [15, 20, 30, 10],
        backgroundColor: [
          "#3498DB",
          "gold",
          "#1ABB9C",
          "#E74C3C",
        ],
      }]
    },
    options: {
      legend: false,
      responsive: false
    }
  }

  $('#dashboard_debt').each(function(){
    var chart_element = $(this);
    var chart_doughnut = new Chart( chart_element, dashboard_debt_settings);
  });

}
