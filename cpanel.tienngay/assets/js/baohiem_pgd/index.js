
$("#add_one_month").click(function(event) {
    event.preventDefault();
    
});

// $("#add_one_month").click(function(event) {
//     event.preventDefault();
//         var fdate_export = $("input[name='fdate_export']").val();
        
//         var formData = new FormData();
//         formData.append('fdate_export', fdate_export);
        
        
//     console.log(formData);
       
//     $.ajax({
//         url :  _url.base_url + 'kpi/doAddKpi',
//         type: "POST",
//         data : formData,
//         dataType : 'json',
//         processData: false,
//         contentType: false,
//         beforeSend: function(){$(".theloading").show();},
//         success: function(data) {
//             $(".theloading").hide();
//               //console.log(data);
//             if (data.res) {
//                   console.log(data);
//                 $('#successModal').modal('show');
//                 $('.msg_success').text(data.message);
//                 setTimeout(function(){ 
//                     window.location.href = _url.base_url + 'kpi/listKPI';
//                 }, 3000);
//             } else {
//                   console.log(data);
//                 $("#errorModal").css("display", "block");
//                 $(".errorModal").text(data.message);
//                 window.scrollTo(0, 0);
//                 setTimeout(function(){ 
//                 $("#errorModal").css("display", "none");
//                 }, 3000);
//             }
//         },
//         error: function(data) {
//             //console.log(data);
//             $(".theloading").hide();
         
                
//         }
//     });
 
// });




