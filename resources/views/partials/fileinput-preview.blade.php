<script type="text/javascript">
	$('#{{$item}}').fileinput({
		initialPreview: [
			"<img src='{{$preview}}' class='file-preview-image' alt='$item' title='{{$caption}}'>",
		],
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
		initialCaption: "{{$caption}}"
	});
</script>
