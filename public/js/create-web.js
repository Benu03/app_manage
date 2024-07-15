
let cropper;
document.getElementById('logo').addEventListener('change', function (event) {
    $('#logo_error').html('');
    const file = event.target.files[0];
    if (file && file.size <= 2 * 1024 * 1024) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const img = document.getElementById('preview-image');
            img.src = e.target.result;
            img.style.display = 'block';
            document.getElementById('no-logo-text').style.display = 'none';
        };
        reader.readAsDataURL(file);
    } else {
        $('#logo_error').html('File size exceeds 2MB.');
        $('#logo').val('');
    }
});

$('#preview-box').on('click', function () {
    var previewImage = $('#preview-image');
    var imageToCrop = $('#image-to-crop');
    var cropContainer = $('#crop-container');

    if (previewImage.attr('src') && previewImage.css('display') !== 'none') {
        imageToCrop.attr('src', previewImage.attr('src'));
        if (typeof cropper !== 'undefined') {
            cropper.destroy();
        }


        setTimeout(function () {
            const image = document.getElementById('image-to-crop');
            cropper = new Cropper(image, {
                aspectRatio: 1,
                crop(event) {

                    var x = event.detail.x;
                    var y = event.detail.y;
                    var width = event.detail.width;
                    var height = event.detail.height;
                },
            });
        }, 500);
    } else {
        imageToCrop.attr('alt', 'No Logo');
        imageToCrop.attr('src', '');

        if (typeof cropper !== 'undefined') {
            cropper.destroy();
        }
    }
});

function validateForm() {
    const appName = document.getElementById('app').value.trim();
    const statusActive = document.getElementById('status_active').checked;
    const statusNotActive = document.getElementById('status_not_active').checked;
    const description = document.getElementById('description').value.trim();

    const isFormValid = appName && (statusActive || statusNotActive) && description;

    document.getElementById('createBtn').disabled = !isFormValid;
}

document.getElementById('app').addEventListener('input', validateForm);
document.getElementById('status_active').addEventListener('change', validateForm);
document.getElementById('status_not_active').addEventListener('change', validateForm);
document.getElementById('description').addEventListener('input', validateForm);

$('#crop-button').on('click', function () {
    if(!cropper){
        $('#cropModal').modal('hide');
        toastr.error('Please upload the Logo first');
        return false;
    }
    let croppedImg = cropper.getCroppedCanvas().toDataURL("image/png");
    let originalFileInput = $('#logo')[0];
    let originalFile = originalFileInput.files[0];
    let originalFilename = originalFile.name;

    // $('#preview-image').attr('src', croppedImg);

    fetch(croppedImg)
        .then(res => res.blob())
        .then(blob => {
            let croppedFile = new File([blob], originalFilename);

            let dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);
            $('#croppedLogo')[0].files = dataTransfer.files;

            let reader = new FileReader();
            reader.onload = function(e) {
                $('#preview-image').attr('src', e.target.result);
            };
            reader.readAsDataURL(croppedFile);
        });


    $('#cropModal').modal('hide');

});

    let moduleCount = 0;
    let selectedModules = new Set();

    // Initialize DataTable
    var table = $('#tableModule').DataTable({
        "responsive": true,
        "lengthChange": false,
        "bInfo": false,
        "ordering": false
    });

    $('.add_data').on('click', function () {
        const moduleSelect = $('#module');
        const selectedOption = moduleSelect.find('option:selected');
        const moduleId = selectedOption.val();
        const moduleName = selectedOption.data('module');

        if (!moduleId) {
            Swal.fire({
                title: "Error",
                text: "Please select a module.",
                icon: "error"
            });
            return;
        }

        if (selectedModules.has(moduleId)) {
            Swal.fire({
                title: "Error",
                text: "Module already added.",
                icon: "error"
            });
            return;
        }

        selectedModules.add(moduleId);
        moduleCount++;

        // Add row to DataTable
        table.row.add([
            moduleCount,
            `<input type="hidden" name="module_ids[]" value="${moduleId}">${moduleName}`,
            `<a href="javascript:;" class="remove_data">
                <i class="fas fa-times"></i>
            </a>`
        ]).draw(false);

        let selectedModulesArray = Array.from(selectedModules);
        $('#selectedModulesInput').val(selectedModulesArray);
    });

    // Remove data from table
    $('#tableModule tbody').on('click', '.remove_data', function () {
        var row = $(this).closest('tr');
        var moduleId = row.find('input[type="hidden"]').val();

        // Remove from selectedModules set
        selectedModules.delete(moduleId);

        // Remove row from DataTable
        table.row(row).remove().draw(false);

        // Update module count and table indexes
        moduleCount--;
        updateTableIndexes();
        let selectedModulesArray = Array.from(selectedModules);
        $('#selectedModulesInput').val(selectedModulesArray);
    });

    function updateTableIndexes() {
        table.rows().every(function (rowIdx, tableLoop, rowLoop) {
            this.cell(rowIdx, 0).data(rowIdx + 1).draw(false);
        });
    }
// });


$(function () {
    validateForm();
})

$('#createBtn').on('click', function () {
    $('#submitConfirmation').modal({
        backdrop: 'static',
        keyboard: false
    });
});
