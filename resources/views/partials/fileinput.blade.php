<script type="text/javascript">
	$("#image").fileinput({
		uploadUrl: "{{url("/")}}/tmp/", // server upload action
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
