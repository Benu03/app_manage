$(document).ready(function() {
    // Clear the selected table on page load to avoid duplicates
    // $('#tblSelected tbody').empty();

    // Add department from Available to Selected
    $(document).on('click', '.add-dept', function() {
        var row = $(this).closest('tr');
        var departmentName = row.find('td:nth-child(2)').text();
        var departmentID = row.find('input[type="hidden"]').val();
        var alreadySelected = false;

        $('#tblSelected tbody tr').each(function() {
            if ($(this).find('td:nth-child(2)').text() === departmentName) {
                alreadySelected = true;
                return false; // Exit the loop
            }
        });

        if (alreadySelected) {
            Swal.fire('Error', 'Department already selected', 'error');
        } else {
            var newRow = $('<tr>').append(
                $('<td class="text-center">').text($('#tblSelected tbody tr').length + 1),
                $('<td>').text(departmentName),
                $('<input>').attr({
                    type: 'hidden',
                    name: 'selected_departments[]',
                    value: departmentID
                }),
                $('<td class="text-center">').html('<i class="fa fa-times delete-dept" style="background-color: white; color: red; cursor: pointer;"></i>')
            );
            $('#tblSelected tbody').append(newRow);
            updateRowNumbers('#tblSelected');
        }
    });

    // Delete department from Selected and move back to Available
    $(document).on('click', '.delete-dept', function() {
        var row = $(this).closest('tr');
        row.remove();
        updateRowNumbers('#tblSelected');
    });

    // Function to update row numbers
    function updateRowNumbers(tableId) {
        $(tableId + ' tbody tr').each(function(index) {
            $(this).find('td:first').text(index + 1);
        });
    }
});
