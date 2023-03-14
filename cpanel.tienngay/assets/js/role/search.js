/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(".btn-delete").on("click", function() {
    var r = confirm("Are you sure want to delete ?");
    if (r == true) {
        var id = $(this).data("id");
        $.ajax({
            method: "POST",
            url: _url.process_delete_role,
            data:{id:id},
            success: function(data) {
                if(data.code != 200) {
                    alert(data.message);
                } else {
                    window.location.reload();
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
});