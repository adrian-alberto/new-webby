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

$thumbs = array(); //We changed this to use the id instead of thumbs, fix later
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
		array_push($thumbs, "$folder");
		array_push($ratios, $w/$h);
	}
}

function makeButton($link, $id, $wPercent, $ratio) {
	$pTop = $wPercent/$ratio;
	echo "<a href=\"/\"><div class=\"portfolioitem\"  id=\"$id\" style=\"width:calc($wPercent% - 6px);padding-top:$pTop%;\"></div></a>";
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
			makeButton("/",$tp, 100.0*$rj/$totalRatio, $rj) ;	
		}
		echo "<div class=\"tray\"></div></div>";
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
	<hr>
<script src="js/pagedown.js"></script>
<script>
document.addEventListener("DOMContentLoaded", main);

var converter = new Markdown.Converter();
function fill() {
	var mdloader = document.getElementById("mdloader");
	var ctray = document.getElementById("currentTray");
	var rawContents = mdloader.contentWindow.document.body.childNodes[0].innerHTML;
	ctray.innerHTML = converter.makeHtml(rawContents);
}
function main() {
	var buttons = document.getElementsByClassName("portfolioitem");
	for (var i = 0; i < buttons.length; i++) {
		let btn = buttons[i];
		let j = i;
		let dir = "/cms/" + btn.id + "/";
		let imgurl = dir + "thumb_" + btn.id + ".png";
		btn.style.backgroundImage = "url('" + imgurl + "')";
		btn.style.opacity = 0;
		

		//Hook up button
		btn.onclick = expand;
		function expand() {
			var othertrays = document.getElementsByClassName("tray");
			for (var k = 0; k < othertrays.length; k++) {
				othertrays[k].innerHTML = "";
				othertrays[k].style.display = "none";
				othertrays[k].setAttribute("id", "");
			}
				
			
			var tray = btn.parentNode.parentNode.getElementsByClassName("tray")[0];
			tray.innerHTML = "loading...";
			tray.style.display = "block";
			tray.setAttribute("id", "currentTray");
	
			var mdloader = document.createElement("IFRAME");
			mdloader.setAttribute("id", "mdloader");
			mdloader.setAttribute("src", "test.md");
			mdloader.setAttribute("onload", "fill();");
			mdloader.style.display = "none";
			tray.appendChild(mdloader);

			return false;
		}



		//Fade in the image upon load.
		var imgloader = document.createElement("IMG");
		imgloader.setAttribute("src", imgurl);
			
		if (imgloader.complete) {
			fadein(btn, j);
		} else {
			imgloader.addEventListener('load', 
				function() {fadein(btn, j);});
		}
		
	}
	
}

function fadein(el, i) {
	var tick = function() {
		el.style.opacity = +el.style.opacity + 0.1;
		if (+el.style.opacity < 1) {
			(window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick, 16)
		} else {
			el.style.opacity = 1;
		}
	}
	setTimeout(tick, 200 * i);

}
</script>


</body>

</html>
