if (typeof halumein == "undefined" || !halumein) {
    var halumein = {};
}
halumein.worker_salary = {
    init: function() {
        $('.worker_salary_checkall').on('click', function() {
			if($(this).prop('checked')) {
				$('.worker_salary_check,.worker_salary_checkall').prop('checked', true);
			}
			else {
				$('.worker_salary_check,.worker_salary_checkall').prop('checked', false);
			}
        });
        
        $('.worker_salary_mass').on('submit', this.salaryMass)
    },
    salaryMass: function() {
        var form = $(this);
		
        $(form).css('opacity', '0.3');
		
        $.post(
			$(form).attr('action'),
			$(form).serialize(),
            function(answer) {
				var json = $.parseJSON(answer);
                if(json.status == 'success') {
					document.location = document.location;
                }
                else {
                    alert('Error');
                }
            }
        );
        
        return false;
    }
};

$(function() {
    halumein.worker_salary.init();
});
