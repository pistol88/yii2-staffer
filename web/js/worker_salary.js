if (typeof halumein == "undefined" || !halumein) {
    var halumein = {};
}
halumein.worker_salary = {
    init: function() {
        $('.worker_salary_checkall').on('click', this.checkSalary);
        $('.worker_salary_check').on('click', this.checkOneSalary);
        $('.worker_salary_mass').on('submit', this.salaryMass);
        this.checkOneSalary();
    },
    checkOneSalary: function() {
        var sum = 0;
        $('.worker_salary_check').each(function(i, el) {
            if($(el).prop('checked')) {
                sum = sum+parseFloat($(el).val());
            }
        });
        $('#hechedSalary').html(sum);
    },
    checkSalary: function() {
        if($(this).prop('checked')) {
            $('.worker_salary_check,.worker_salary_checkall').prop('checked', true);
        }
        else {
            $('.worker_salary_check,.worker_salary_checkall').prop('checked', false);
        }
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
                    document.location.reload();
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
