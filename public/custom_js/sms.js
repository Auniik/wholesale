

//        sms counter
function countChar(val) {
    var len = val.value.length;
    var rem = 640 - len;
    var smsC = len / 160;
    $("#show").html(len);
    $("#rem").html(rem);
    $("#smsC").html(Math.ceil(smsC));

}
//        sms counter
function countmsg(val) {
    var len = val.value.length;
    var rem = 640 - len;
    var smsC = len / 160;
    $('#show2').html(len);
    $('#rem2').html(rem);
    $('#smsC2').html(Math.ceil(smsC));
}
//        sms counter for client
function countClientMsg(val) {
    var len = val.value.length;
    var rem = 640 - len;
    var smsC = len / 160;
    $('#clientshow').html(len);
    $('#clientrem').html(rem);
    $('#clientsmsC').html(Math.ceil(smsC));
}
//        sms counter for supplier
function countSupplierMsg(val) {
    var len = val.value.length;
    var rem = 640 - len;
    var smsC = len / 160;
    $('#suppliershow').html(len);
    $('#suplierrem').html(rem);
    $('#suppliersmsC').html(Math.ceil(smsC));
}

