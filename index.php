<!DOCTYPE=HTML>
<html>

<head>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700|Source+Code+Pro" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/css/main.css">
	<link rel="stylesheet" type="text/css" href="/css/index.css">
</head>





<body>
	<div class="center">
		<div id="navpanel">
			<a href="/" id="aboutlink">about</a><br>
			<a href="/">cv</a><br>
			<a href="https://github.com/woftles">github</a><br>
			<a href="mailto:adrian@whitecollargames.com">e-mail</a><br>
		</div>

		<div id="about">
			<p>
				i am adrian alberto<br>
				<span class="invisitext">i am</span> a <a href="/">research assistant</a><br>
				<span class="invisitext">i am</span> a <a href="/">game developer</a><br>
				<span class="invisitext">i am</span> an <a href="/">artist</a><br>
				<span class="invisitext">i am</span> a <a href="/">programmer</a><br>
				<span class="invisitext">don't tell anybody but i'm not a web developer</span>
			</p>
		</div>

		<hr class="clear">

		<div id="portfolio">
<!-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -->

<?php
$dir = $_SERVER['DOCUMENT_ROOT']."/cms/";
$folders = scandir($dir);

$thumbs = array();
$ratios = array();
foreach ($folders as $i => $folder) {
	#echo $folder . "<br>";
	$thumbname = "thumb_$folder.png";
	$thumbpath = "$dir$folder/$thumbname";
	if (is_file($thumbpath)) {
		#echo $thumbpath . "<br>";
		$size = getimagesize($dir.$folder."/".$thumbname);
		$w = $size[0];
		$h = $size[1];
		array_push($thumbs, "/cms/$folder/$thumbname");
		array_push($ratios, $w/$h);
	}
}

function makeButton($link, $img, $wPercent, $numRow) {
	$mg = ($numRow-1)*4; #margin
	echo "<a><img src=\"$img\" style=\"width:$wPercent%;\"></a>";
}


$totalRatio = 0.0;
$maxRatio = 5.0;
$currentRow = array();
$currentRowRatios = array();
foreach ($thumbs as $i => $thumbpath) {
	$ratio = $ratios[$i];
	if ($totalRatio + $ratio > $maxRatio) {
		echo "<div class=\"portfoliorow\">";
		foreach ($currentRow as $j => $tp) {
			$rj = $currentRowRatios[$j];
			makeButton("/",$tp, 100.0*$rj/$totalRatio, count($currentRow)) ;	
		}
		echo "</div>";
		$totalRatio = 0.0;
		$currentRow = array();
		$currentRowRatios = array();
		
	}

	#echo "$thumbpath ";
	$totalRatio = $totalRatio + $ratio;
	array_push($currentRow, $thumbpath);
	array_push($currentRowRatios, $ratio);
}


?>

<!-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -->
		</div>
	</div>
</body>

</html>
