<!-- jQuery -->
<script src="{{ asset('admin/js/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('admin/asset/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('admin/js/fastclick/lib/fastclick.js') }}"></script>
<!-- NProgress -->
<script src="{{ asset('admin/asset/nprogress/nprogress.js') }}"></script>
<!-- bootstrap-progressbar -->
<script src="{{ asset('admin/asset/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('admin/asset/iCheck/icheck.min.js') }}"></script>
<!-- Ckeditor -->
<script src="{{ asset('admin/js/ckeditor/ckeditor.js') }}"></script>
<!-- NotifyJS -->
<script src="{{ asset('admin/js/notifyjs/notify.min.js') }}"></script>
<!-- Sweet Alert 2 -->
<script src="{{ asset('admin/js/sweetalert2.js') }}"></script>
<!-- Tags Input -->
<script src="{{ asset('admin/asset/tagsinput/dist/jquery.tagsinput.min.js') }}"></script>
<!-- Laravel File Manager -->
{{-- <script src="{{ asset('vendor/laravel-filemanager/js/script.js') }}"></script> --}}
<script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
<script src="{{ asset('vendor/laravel-filemanager/js/filemanager.js') }}"></script>
{{-- <script src="{{ asset('vendor/laravel-filemanager/js/filemanager.min.js') }}"></script> --}}
<!-- Dropzone -->
<script src="{{ asset('vendor/laravel-filemanager/js/dropzone.min.js') }}"></script>
<!-- Date Range Picker -->
<script src="{{ asset('admin/asset/daterangepicker-master/daterangepicker.js') }}"></script>
<script src="{{ asset('admin/asset/daterangepicker-master/moment.min.js') }}"></script>
<!-- Custom Theme Scripts -->
<script src="{{ asset('admin/js/custom.min.js') }}"></script>
<script src="{{ asset('admin/js/my-js.js') }}"></script>
<script>
    if ($('#ckeditor').length) {
		var options = {
			filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
			filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
			filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
			filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
		};
		CKEDITOR.replace('ckeditor', options);
	}
</script>