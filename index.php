<?php
    // get and sort the file names with image extensions
    $files = glob('../../../*/public_html/memes/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
    $images = [];
    foreach($files as $file) {
        $components = explode("/", $file);
        $images[] = "../../~".$components[3]."/memes/".$components[6];
    }
    sort($images);
    // select a random image
    $imgname = $images[array_rand($images)];
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
    #clock {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 40px;
        background-color: white;
        padding: 5px;
        font-weight: bold;
    }
</style>
</head>
<body>
<!-- display element holding the figure -->
<a href="<?php print $imgname; ?>"><div id="meme"></div></a>
<div id="clock"><?php date_default_timezone_set('Europe/Brussels'); echo date('h:i', time()); ?></div>
</body>
</html>
