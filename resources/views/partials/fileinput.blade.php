<script type="text/javascript">
	$('#{{$item}}').fileinput({
		uploadUrl: "{{url("/")}}/tmp/",
		uploadAsync: true,
		dropZoneEnabled: false,
		minFileCount: 1,
		maxFileCount: 1,
		overwriteInitial: true,
		maxFileSize: 800,
		showUpload: false,
		showRemove: false,
		showCancel: false,
		allowedFileExtensions: ["jpg", "gif", "png"],
		allowedFileExtensions: ["jpg", "gif", "png"],
		indicatorLoading: '<i class="fa fa-spinner"></i>'
	});
</script>
