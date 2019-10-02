$(document).on("change",".changes",function(){
    let month       = $("#month").val();
    let year        = $("#year").val();
    let department  = $("#department").val();
    let bonus       = $("#bonus").val();
    let data_url    = "{{ url('employee-for-salary-generate') }}";
    $.ajax({
        url:data_url,
        dataType:"HTML",
        type:"get",
        data: {
            month:month,
            year:year,
            department:department,
            bonus:bonus,
        },
    }).done(function (data) {
        $("#infoHere").html(data);
    });

});
