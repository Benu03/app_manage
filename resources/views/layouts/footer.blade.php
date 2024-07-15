
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
</form>

<footer class="main-footer text-sm" style="border-radius: 0px !important;">
    <strong>Copyright &copy; {{ date('Y') }} <a href="#">Puninar Logistics</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0
    </div>
</footer>

@push('js')
<!-- dataTable -->
<script src="{{ asset('plugins/jqclock/jqClock.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/moment/moment-with-locales.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- datetimepicker -->
<script src="{{ asset('plugins/datetimepicker/js/tempus-dominus.min.js') }}"></script>

<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- Sweetalert2 -->
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- dataTable -->
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-fixedcolumns/js/dataTables.fixedColumns.min.js') }}"></script>
{{-- <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script> --}}
{{-- <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script> --}}
<!-- dataTable button / export-->
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/jszip.min.js') }}"></script>
<!-- dataTable Group-->
<script src="{{ asset('plugins/datatables-rowgroup/js/dataTables.rowGroup.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-rowgroup/js/rowGroup.bootstrap4.min.js') }}"></script>

<!-- Select 2 -->
<script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
<!-- Select Picker -->
<script src="{{ asset('plugins/selectpicker/js/bootstrap-select.min.js') }}"></script>
<!-- Filsave -->
<script src="{{ asset('plugins/filedownload/js/filedownload.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<script src="{{ asset('dist/js/custom/custom.js') }}"></script>
<!-- PDF Make -->
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<!-- Color Picker -->
<script src="{{ asset('plugins/colorpicker/js/evol-colorpicker.min.js') }}"></script>
<!-- Cropper -->
<script src="{{ asset('plugins/cropper/cropper.js') }}"></script>
<script>
    $(function () {
        $('.datepicker').datepicker({
            format: 'DD-MMM-YYYY',
        });
        $('.select2').select2();

        $(".selectmodal").select2({
            dropdownParent: $(".myModal")
        });

        $('.selectpicker').selectpicker();

        $('#example1').DataTable({
            "responsive": {
                "details": {
                    "type": 'column',
                    "target": 'tr'
                }
            },
            "lengthChange": false,
            "autoWidth": false,
            "columnDefs": [
                { "orderable": false, "targets": [4, 5, 6] }, // Non-sortable columns
                { "className": "text-center", "targets": [4, 5, 6] }
            ]
        });
    })

    function changesDateFormat(dateString, type) {
        var date = new Date(dateString);

        var indonesianMonths = [
            "Jan", "Feb", "Mar", "Apr", "Mei", "Jun",
            "Jul", "Agu", "Sep", "Okt", "Nov", "Des"
        ];

        var day = ('0' + date.getDate()).slice(-2);
        var month = indonesianMonths[date.getMonth()];
        var year = date.getFullYear();

        var hours = ('0' + date.getHours()).slice(-2);
        var minutes = ('0' + date.getMinutes()).slice(-2);
        var seconds = ('0' + date.getSeconds()).slice(-2);

        if(type == 'pica'){
            var formattedDate = `${day}-${month}-${year}`;
        }else{
            var formattedDate = `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;
        }

        return formattedDate;
    }

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if(charCode == 44 || charCode == 46) return true;
        if(charCode < 48 || charCode > 57) return false;
    }

</script>
@endpush

@push('js')
    @include('layouts.blockUI')
@endpush


