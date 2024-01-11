<?php
// get and sort the file names with image extensions
$pngnames = glob('*.png');
$jpgnames = glob('*.jpg');
$imgnames = array_merge($pngnames, $jpgnames);
sort($imgnames);
// select a random image
$imgname = $imgnames[array_rand($imgnames)];
// do the same for the background images
$bkgnames = glob('style/*.jpg');
sort($bkgnames);
$bkgname = $bkgnames[array_rand($bkgnames)];
?>
<html>
<head>
<!-- force refresh with given time interval -->
<meta http-equiv="refresh" content="30">
<!-- CSS style definitions -->
<style type='text/css'>
html {
    min-height:100%;
}
body {
    width:100%;
    min-height:100%;
    background:url(<?php print $bkgname; ?>);
    background-size:cover;
    margin:0px;
}
#meme {
    margin:1%;
    width:97%;
    height:97%;
    background:url(<?php print str_replace(" ", "%20", $imgname); ?>);
    background-size:contain;
    background-repeat:no-repeat;
    background-position:center;
}
</style>
</head>
<body>
<!-- display element holding the figure -->
<a href="<?php print $imgname; ?>"><div id="meme"></div></a>
</body>
</html>
