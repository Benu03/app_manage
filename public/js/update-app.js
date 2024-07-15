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
    var previewImage    = $('#preview-image');
    var imageToCrop     = $('#image-to-crop');
    var cropContainer   = $('#crop-container');

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
        // cropContainer.html('<p style="text-align: center; vertical-align: middle; margin-top: 5%;">No Logo</p>');

        if (typeof cropper !== 'undefined') {
            cropper.destroy();
        }
    }
});

$('#crop-button').on('click', function () {
    if(!cropper){
        $('#cropModal').modal('hide');
        toastr.error('Please upload the Logo first');
        return false;
    }
    let croppedImg          = cropper.getCroppedCanvas().toDataURL("image/png");
    let originalFileInput   = $('#logo')[0];
    let existingImage       = $('#preview-image').attr('src');
    let originalFilename    = '';



    $('#preview-image').attr('src', croppedImg);

    if (originalFileInput.files && originalFileInput.files.length > 0) {
        let originalFile        = originalFileInput.files[0];
        originalFilename    = originalFile.name;

    }else if(existingImage && existingImage !== '#') {
        let filename        = $('#image_url').val();
        originalFilename    = filename.split('/').pop();
    }
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



$(document).ready(function () {
    let moduleCount = $('#tableModule tbody tr').length;
    let selectedModules = new Set();

    var table = $('#tableModule').DataTable({
        "lengthChange": false,
        "bInfo": false,
        "ordering": false
    });

    // Load existing modules into the selectedModules set
    $('#tableModule tbody tr').each(function () {
        var moduleId = $(this).find('input[type="hidden"]').val();
        selectedModules.add(moduleId);
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
        $('#selectedModulesInput').val(selectedModulesArray.join(','));
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
        $('#selectedModulesInput').val(selectedModulesArray.join(','));
    });

    function updateTableIndexes() {
        table.rows().every(function (rowIdx, tableLoop, rowLoop) {
            this.cell(rowIdx, 0).data(rowIdx + 1).draw(false);
        });
    }
});

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if(charCode == 44 || charCode == 46) return true;
    if(charCode < 48 || charCode > 57) return false;
}

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

$(function () {
    validateForm();
});


const addDev = () => {
    $('#devModalTitle').text('Add New Development APK');
    $('#saveDevBtn').text('ADD');
    $('#dev_url').val('');
    $('#version').val('');
    $('#remark').val('');
    $('#dev_url_error').html('');
    $('#version_error').html('');
    $('#remark_error').html('');
    $('#devModal').modal({
        backdrop: 'static',
        keyboard: false
    });
}

// Initialize DataTable
var tableDev = $('#tblApp').DataTable({
    "lengthChange": false,
    "bInfo": false,
    "bPaginate": false,
    "bFilter": false,
    "autoWidth": false,
    "ordering": false,
    "order": []
});

let devCount = tableDev.rows().count();
let isEdit = false;
let editRow = null;

$('#saveDevBtn').on('click', function () {
    let dev_url = $('#dev_url').val();
    let version = $('#version').val();
    let remark = $('#remark').val();
    let status = $('input[name="status_dev"]:checked').val();

    let isValid = true

    if(!dev_url){
        $('#dev_url_error').html('Dev URL (Google Drive) is required');
        isValid = false
    }else{
        $('#dev_url_error').html('');
    }

    if(!version){
        $('#version_error').html('Version is required');
        isValid = false
    }else{
        $('#version_error').html('');
    }

    if(!remark){
        $('#remark_error').html('Remark is required');
        isValid = false
    }else{
        $('#remark_error').html('');
    }

    if(isValid){
        if (isEdit) {
            var rowIndex = editRow.index() + 1;
            var urlInputId = `url_dev_${rowIndex}`;
            var idInputId = `dev_ids_${rowIndex}`;
            var id = $(`#${idInputId}`).val();
            var rowData = [
                `<input type="hidden" id="${idInputId}" value="${id}"> ${rowIndex}`,
                `<a href="${dev_url}" style="text-decoration: underline;font-weight: 400;color: #4053EE !important;font-size:14px;" target="_blank">${dev_url}</a> <input type="hidden" id="${urlInputId}" value="${dev_url}">`,
                version,
                remark,
                status,
                `<a href="javascript:;" class="edit_data_dev" style="color: #2E308A;"><img src="/img/logo/pencil.png" width="18px" height="18px"></a><a href="javascript:;" class="remove_data_dev" style="color:red;"><img src="/img/logo/delete.png" width="18px" height="18px"></a>`
            ];
            tableDev.row(editRow).data(rowData).draw(false);

            isEdit = false;
            editRow = null;
        } else {
            // Add new row
            devCount++;
            var rowIndex = devCount;
            var urlInputId = `url_dev_${rowIndex}`;
            var idInputId = `dev_ids_${rowIndex}`;
            tableDev.row.add([
                `<input type="hidden" id="${idInputId}" value=""> ${rowIndex}`,
                `<a href="${dev_url}" style="text-decoration: underline;font-weight: 400;color: #4053EE !important;font-size:14px;" target="_blank">${dev_url}</a> <input type="hidden" id="${urlInputId}" value="${dev_url}">`,
                version,
                remark,
                status,
                `<a href="javascript:;" class="edit_data_dev" style="color: #2E308A;"><img src="/img/logo/pencil.png" width="18px" height="18px"></a><a href="javascript:;" class="remove_data_dev" style="color:red;"><img src="/img/logo/delete.png" width="18px" height="18px"></a>`
            ]).draw(false);
        }

        $('#devModal').modal('hide');

        // Clear form fields
        $('#dev_url').val('');
        $('#version').val('');
        $('#remark').val('');
    }
});

$('#tblApp tbody').on('click', '.remove_data_dev', function () {
    var row = $(this).closest('tr');
    tableDev.row(row).remove().draw(false);

    // Update devCount and table indexes
    devCount--;
    updateTableIndexes1();
});

// Edit data in the table
$('#tblApp tbody').on('click', '.edit_data_dev', function () {
    var row = $(this).closest('tr');
    var data = tableDev.row(row).data();
    var rowIndex = tableDev.row(row).index() + 1;
    var urlInputId = `url_dev_${rowIndex}`;
    var idInputId = `dev_ids_${rowIndex}`;

    $('#dev_url').val($(`#${urlInputId}`).val());
    $('#version').val(data[2]);
    $('#remark').val(data[3]);
    if (data[4] === 'Active') {
        $('#status_dev_act').prop('checked', true);
    } else {
        $('#status_dev_nact').prop('checked', true);
    }

    isEdit = true;
    editRow = tableDev.row(row);

    $('#devModalTitle').text('Edit Development APK');
    $('#saveDevBtn').text('SAVE CHANGES');

    $('#devModal').modal('show');
});


function updateTableIndexes1() {
    tableDev.rows().every(function (rowIdx, tableLoop, rowLoop) {
        this.cell(rowIdx, 0).data(rowIdx + 1).draw(false);
    });
}


const addAndro = () => {
    $('#androidModalTitle').text('Add New Version on Production - Play Store');
    $('#saveAndroidBtn').text('ADD');
    $('#version_android').val('');
    $('#remark_android').val('');
    $('#version_android_error').html('');
    $('#remark_android_error').html('');
    $('#androidModal').modal({
        backdrop: 'static',
        keyboard: false
    });
}

var tableAndro = $('#tblAndroid').DataTable({
    "lengthChange": false,
    "bInfo": false,
    "bPaginate": false,
    "bFilter": false,
    "autoWidth": false,
    "ordering": false,
    "order": []
});

let androCount      = tableAndro.rows().count();
let isEditAndro     = false;
let editRowAndro    = null;

$('#saveAndroidBtn').on('click', function () {
    let version = $('#version_android').val();
    let remark = $('#remark_android').val();
    let status = $('input[name="status_android"]:checked').val();
    let isValid = true;

    if(!version){
        $('#version_android_error').html('Version is required');
        isValid = false;
    }else{
        $('#version_android_error').html('');
    }

    if(!remark){
        $('#remark_android_error').html('Remark is required');
        isValid = false;
    }else{
        $('#remark_android_error').html('');
    }

    if(isValid){
        if (isEditAndro) {
            var rowIndex    = editRowAndro.index() + 1;
            var idInputId   = `prod_andro_ids_${rowIndex}`;
            var id          = $(`#${idInputId}`).val();

            var rowDataAndro = [
                `<input type="hidden" id="${idInputId}" value="${id}"> ${rowIndex}`,
                version,
                remark,
                status,
                `
                <a href="javascript:;" class="edit_data_andro" style="color: #2E308A;">
                    <img src="/img/logo/pencil.png" width="18px" height="18px">
                </a>
                <a href="javascript:;" class="remove_data_andro" style="color:red;">
                    <img src="/img/logo/delete.png" width="18px" height="18px">
                </a>`
            ];

            tableAndro.row(editRowAndro).data(rowDataAndro).draw(false);

            isEditAndro = false;
            editRowAndro = null;
        } else {
            androCount++;
            var rowIndex = androCount;
            var idInputId = `prod_andro_ids_${rowIndex}`;
            tableAndro.row.add([
                `<input type="hidden" id="${idInputId}" value=""> ${rowIndex}`,
                version,
                remark,
                status,
                `
                <a href="javascript:;" class="edit_data_andro" style="color: #2E308A;">
                    <img src="/img/logo/pencil.png" width="18px" height="18px">
                </a>
                <a href="javascript:;" class="remove_data_andro" style="color:red;">
                    <img src="/img/logo/delete.png" width="18px" height="18px">
                </a>`
            ]).draw(false);
        }

        $('#androidModal').modal('hide');
        $('#version_android').val('');
        $('#remark_android').val('');
    }
});

$('#tblAndroid tbody').on('click', '.remove_data_andro', function () {
    var row = $(this).closest('tr');
    tableAndro.row(row).remove().draw(false);
    androCount--;
    updateTableIndexes2();
});

$('#tblAndroid tbody').on('click', '.edit_data_andro', function () {
    var row     = $(this).closest('tr');
    var data    = tableAndro.row(row).data();

    $('#version_android').val(data[1]);
    $('#remark_android').val(data[2]);
    if (data[3] === 'Active') {
        $('#status_android_act').prop('checked', true);
    } else {
        $('#status_android_nact').prop('checked', true);
    }

    isEditAndro     = true;
    editRowAndro    = tableAndro.row(row);

    // Show modal
    $('#androidModalTitle').text('Edit Version on Production - Play Store');
    $('#saveAndroidBtn').text('SAVE CHANGES');
    $('#androidModal').modal('show');
});

function updateTableIndexes2() {
    tableAndro.rows().every(function (rowIdx, tableLoop, rowLoop) {
        this.cell(rowIdx, 0).data(rowIdx + 1).draw(false);
    });
}

const addIOS = () => {
    $('#iosModalTitle').text('Add New Version on Production - App Store');
    $('#saveIosBtn').text('ADD');
    $('#version_ios_error').html('');
    $('#remark_ios_error').html('');
    $('#version_ios').val('');
    $('#remark_ios').val('');
    $('#iosModal').modal({
        backdrop: 'static',
        keyboard: false
    });
}

var tableIos = $('#tblIOS').DataTable({
    "lengthChange": false,
    "bInfo": false,
    "bPaginate": false,
    "bFilter": false,
    "autoWidth": false,
    "ordering": false,
    "order": []
});

let iosCount      = tableIos.rows().count();
let isEditIos     = false;
let editRowIos    = null;

$('#saveIosBtn').on('click', function () {
    let version = $('#version_ios').val();
    let remark = $('#remark_ios').val();
    let status = $('input[name="status_ios"]:checked').val();
    let isValid = true;

    if(!version){
        $('#version_ios_error').html('Version is required');
        isValid = false;
    }else{
        $('#version_ios_error').html('');
    }

    if(!remark){
        $('#remark_ios_error').html('Remark is required');
        isValid = false;
    }else{
        $('#remark_ios_error').html('');
    }

    if(isValid){
        if (isEditIos) {
            var rowIndex    = editRowIos.index() + 1;
            var idInputId   = `prod_ios_ids_${rowIndex}`;
            var id          = $(`#${idInputId}`).val();

            var rowDataIos = [
                `<input type="hidden" id="${idInputId}" value="${id}"> ${rowIndex}`,
                version,
                remark,
                status,
                `
                <a href="javascript:;" class="edit_data_ios" style="color: #2E308A;">
                    <img src="/img/logo/pencil.png" width="18px" height="18px">
                </a>
                <a href="javascript:;" class="remove_data_ios" style="color:red;">
                    <img src="/img/logo/delete.png" width="18px" height="18px">
                </a>`
            ];

            tableIos.row(editRowIos).data(rowDataIos).draw(false);

            isEditIos   = false;
            editRowIos  = null;
        } else {
            iosCount++;
            var rowIndex = iosCount;
            var idInputId = `prod_ios_ids_${rowIndex}`;
            tableIos.row.add([
                `<input type="hidden" id="${idInputId}" value=""> ${rowIndex}`,
                version,
                remark,
                status,
                `
                <a href="javascript:;" class="edit_data_ios" style="color: #2E308A;">
                    <img src="/img/logo/pencil.png" width="18px" height="18px">
                </a>
                <a href="javascript:;" class="remove_data_ios" style="color:red;">
                    <img src="/img/logo/delete.png" width="18px" height="18px">
                </a>`
            ]).draw(false);
        }

        $('#iosModal').modal('hide');
        $('#version_ios').val('');
        $('#remark_ios').val('');
    }
});

$('#tblIOS tbody').on('click', '.remove_data_ios', function () {
    var row = $(this).closest('tr');
    tableIos.row(row).remove().draw(false);
    iosCount--;
    updateTableIndexes3();
});

$('#tblIOS tbody').on('click', '.edit_data_ios', function () {
    var row     = $(this).closest('tr');
    var data    = tableIos.row(row).data();

    $('#version_ios').val(data[1]);
    $('#remark_ios').val(data[2]);
    if (data[3] === 'Active') {
        $('#status_ios_act').prop('checked', true);
    } else {
        $('#status_ios_nact').prop('checked', true);
    }

    isEditIos     = true;
    editRowIos    = tableIos.row(row);

    // Show modal
    $('#iosModal').modal('show');
    $('#iosModalTitle').text('Edit Version on Production - App Store');
    $('#saveIosBtn').text('SAVE CHANGES');
});

function updateTableIndexes3() {
    tableIos.rows().every(function (rowIdx, tableLoop, rowLoop) {
        this.cell(rowIdx, 0).data(rowIdx + 1).draw(false);
    });
}

function submit(e) {
    e.preventDefault();

    var tableDataDev        = [];
    var tableDataProdAndro  = [];
    var tableDataProdIos    = [];

    $('#tblApp tbody tr').each(function () {
        var hiddenInput = $(this).find('input[type="hidden"]');

        if (hiddenInput.length > 0) {
            var rowIndex    = hiddenInput.attr('id').split('_')[2];
            var id          = $(`#dev_ids_${rowIndex}`).val();
            var url         = $(`#url_dev_${rowIndex}`).val();
            var version     = $(this).find('td:eq(2)').text();
            var remark      = $(this).find('td:eq(3)').text();
            var status      = $(this).find('td:eq(4)').text();

            tableDataDev.push({
                id: id,
                url: url,
                version: version,
                remark: remark,
                status: status
            });
        }
    });

    $('#tblAndroid tbody tr').each(function () {
        var hiddenInput = $(this).find('input[type="hidden"]');

        if (hiddenInput.length > 0) {
            var rowIndex    = hiddenInput.attr('id').split('_')[3];
            var id          = $(`#prod_andro_ids_${rowIndex}`).val();
            var version     = $(this).find('td:eq(1)').text().trim();
            var remark      = $(this).find('td:eq(2)').text();
            var status      = $(this).find('td:eq(3)').text();

            tableDataProdAndro.push({
                id: id,
                version: version,
                remark: remark,
                status: status
            });
        }
    });

    $('#tblIOS tbody tr').each(function () {
        var hiddenInput = $(this).find('input[type="hidden"]');
        if (hiddenInput.length > 0) {
            var rowIndex    = hiddenInput.attr('id').split('_')[3];
            var id          = $(`#prod_ios_ids_${rowIndex}`).val();
            var version     = $(this).find('td:eq(1)').text().trim();
            var remark      = $(this).find('td:eq(2)').text();
            var status      = $(this).find('td:eq(3)').text();

            tableDataProdIos.push({
                id: id,
                version: version,
                remark: remark,
                status: status
            });
        }
    });

    $('#tableDataDev').val(JSON.stringify(tableDataDev));
    $('#tableDataProdAndro').val(JSON.stringify(tableDataProdAndro));
    $('#tableDataProdIOS').val(JSON.stringify(tableDataProdIos));

    submitProses();
}

$('#createBtn').on('click', function () {
    $('#submitConfirmation').modal({
        backdrop: 'static',
        keyboard: false
    });
});
