if (typeof pistol88 == "undefined" || !pistol88) {
    var pistol88 = {};
}

pistol88.staffer = {
    init: function() {

    },
    callPrint: function (strid) {
        var prtContent = document.getElementById(strid);
        var WinPrint = window.open('','','left=50,top=50,width=800,height=640,toolbar=0,scrollbars=1,status=0');
        WinPrint.document.write('<div id="printcontent" class="contentpane">');
        WinPrint.document.write(prtContent.innerHTML);
        WinPrint.document.write('</div>');
        WinPrint.document.write('<style>#printcontent .btn, #printcontent input, #printcontent button, #printcontent select, .rc-handle-container { display: none; } #printcontent .modal-dialog { display: none; }</style>');
        WinPrint.document.close();
        WinPrint.focus();
        WinPrint.print();
        WinPrint.close();
    },
};

pistol88.staffer.init();
