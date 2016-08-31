if (typeof pistol88 == "undefined" || !pistol88) {
    var pistol88 = {};
}

pistol88.addFine = {
    init: function() {
        $(document).on('submit', '.add-fine-widget form', this.addNew)
    },
    addNew: function() {
        var form = $(this);
        var data = $(form).serialize();
        data = data+'&ajax=1';

        jQuery.post($(form).attr('action'), data,
            function(json) {
                if(json.result == 'success') {
                    $('.add-fine-update').click();
                    $('.add-fine-widget .modal').modal('hide');
                }
                else {
                    console.log(json.errors);
                    alert(json.errors);
                }

                return true;

            }, "json");
            
        return false;
    },
};

pistol88.addFine.init();
