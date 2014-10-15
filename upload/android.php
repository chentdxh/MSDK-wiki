<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<title>MSDK Android WIKI 文档上传工具</title>
	<link rel="stylesheet" href="../wiki/css/main.css" />
</head>
<body>
<div id="page">
<h1 class="clear">MSDK Android WIKI 文档上传工具</h1>
<div id="content">
<div id="dropZone" style="line-height: 100px">
	<form action="" enctype="multipart/form-data" method="post" name="uploadfile">
	上传文件：<input class="btn btn-default btn-lg" type="file" name="upfile" /><input class="btn btn-default btn-lg" type="submit"value="上传" />
	</form>
	</div>
<?php
// print_r($_FILES["upfile"]);
if (is_uploaded_file ( $_FILES ['upfile'] ['tmp_name'] )) {
	$upfile = $_FILES ["upfile"];
	// 获取数组里面的值
	$name = $upfile ["name"]; // 上传文件的文件名
	$type = $upfile ["type"]; // 上传文件的类型
	$size = $upfile ["size"]; // 上传文件的大小
	$tmp_name = $upfile ["tmp_name"]; // 上传文件的临时存放路径
	                              // 判断是否为图片
	switch ($type) {
		case 'image/pjpeg' :
			$okType = 1;
			break;
		case 'image/jpeg' :
			$okType = 1;
			break;
		case 'image/gif' :
			$okType = 1;
			break;
		case 'image/png' :
			$okType = 1;
			break;
		case 'application/octet-stream' :
			$okType = 2;
			break;
	}
	
	echo "<div id=\"dropZone\">";
	if ($okType) {
		/**
		 * 0:文件上传成功<br/>
		 * 1：超过了文件大小，在php.ini文件中设置<br/>
		 * 2：超过了文件的大小MAX_FILE_SIZE选项指定的值<br/>
		 * 3：文件只有部分被上传<br/>
		 * 4：没有文件被上传<br/>
		 * 5：上传文件大小为0
		 */
		$error = $upfile ["error"]; // 上传后系统返回的值
		echo "<p style=\"text-align:left;text-indent:2em\">上传文件名称：" . $name . "</p>";
		echo "<p style=\"text-align:left;text-indent:2em\">上传文件大小：" . $size . "</p>";
		// 把上传的临时文件移动到up目录下面
		move_uploaded_file ( $tmp_name, dirname(__FILE__).'/../wiki/android/'.$name );
		$destination = $name;
		if ($error == 0) {
			if(1 == $okType){
				echo "<p style=\"text-align:left;text-indent:2em\">上传图片预览:</p><img src=../wiki/android/" . $destination . ">";
			}else{
				echo "<p style=\"text-align:left;text-indent:2em\">上传文件结果：文件上传成功";
			}
		} elseif ($error == 1) {
			echo "<p style=\"text-align:left;text-indent:2em\">文件过大，请联系hardyshi</p>";
		} elseif ($error == 2) {
			echo "<p style=\"text-align:left;text-indent:2em\">文件过大，请联系hardyshi</p>";
		} elseif ($error == 3) {
			echo "<p style=\"text-align:left;text-indent:2em\">文件只有部分被上传，请重试</p>";
		} elseif ($error == 4) {
			echo "<p style=\"text-align:left;text-indent:2em\">没有文件被上传，请重试</p>";
		} else {
			echo "<p style=\"text-align:left;text-indent:2em\">上传文件大小为0，请重试</p>";
		}
		
	} else {
		echo "<p style=\"text-align:left;text-indent:2em\">请上传jpg，gif，png，MD等格式文件！</p>";
	}
	echo "</div>";
} 
?> 
</div></div>
</body>
</html>