@livewireScripts

<script> const $wire = Livewire; </script>
<script src="{{ asset('template/assets/js/vendor.min.js') }}"></script>
<script src="{{ asset('template/assets/libs/peity/jquery.peity.min.js') }}"></script>
<script src="{{ asset('template/assets/libs/jquery-vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('template/assets/libs/jquery-vectormap/jquery-jvectormap-us-merc-en.js') }}"></script>
<script src="{{ asset('template/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('template/assets/libs/switchery/switchery.min.js') }}"></script>
<script src="{{ asset('template/assets/libs/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('template/assets/libs/moment/moment.min.js') }}"></script>
<script src="{{ asset('template/assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('template/assets/libs/clockpicker/bootstrap-clockpicker.min.js') }}"></script>
<script src="{{ asset('template/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('template/assets/libs/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('template/assets/libs/chart-js/Chart.bundle.min.js') }}"></script>
<!-- App js -->
<script src="{{ asset('template/assets/js/app.min.js') }}"></script>
<!-- Global js -->
<script src="{{ asset('js/global.js') }}"></script>
<!-- Custom js -->
@stack('scripts')