<!-- webpage layout -->
<html>

<!-- start of head definition -->
<head>

<!-- force refresh with given time interval -->
<meta http-equiv="refresh" content="30">

<!-- CSS style definitions -->
<!-- to check if all of them are needed, maybe can be simplified -->
<style type='text/css'>
body {
    font-family: "Helvetica", sans-serif;
    font-size: 9pt;
    line-height: 10.5pt;
}
h1 {
    font-size: 14pt;
    margin: 0.5em 1em 0.2em 1em;
    text-align: left;
    display: inline-block;
}
div.fixed {
    position: fixed;
    white-space: nowrap;
    width:100%;
}
div.bar {
    display: inline-block;
    margin: 0.5em 0.6em 0.2em 0.6em;
    padding: 10px;
    color: #29407C;
    background: white;
    text-align: center;
    border: 1px solid #29407C;
    border-radius: 5px;
}
div.barEmpty {
    color: #ccc;
    border: 1px solid #ccc;
}
a.bar {
    display: inline-block;
    margin: 0.5em 0.6em 0.2em 0.6em;
    padding: 10px;
    color: white;
    background: #29407C;
    text-align: center;
    border: 1px solid #29407C;
    border-radius: 5px;
}
a.bar:hover {
    background-color: #4CAF50;
    color: white;
}
div.pic h3 { 
    font-size: 11pt;
    margin: 0.5em 1em 0.2em 1em;
}
div.pic p {
    font-size: 11pt;
    margin: 0.0em 1em 0.2em 1em;
}
div.pic {
    display: block;
    float: center;
    background-color: white;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 2px;
    text-align: center;
    margin: 40px 10px 10px 2px;
}
div.list {
    font-size: 13pt;
    margin: 0.5em 1em 1.2em 1em;
    display: block; 
    clear: both;
}
div.list li {
    margin-top: 0.3em;
}
a { text-decoration: none; color: #29407C; }
a:hover { text-decoration: underline; color: #D08504; }
</style>
</head>

<!-- start of body definition -->
<body>

<!-- top row of elements on the webpage, with link to parent page -->
<div class="fixed">
<?php
  function showIfExists($path, $name){
    if(file_exists($path)){
      if(realpath('./')!=realpath($path)){
        $user = get_current_user();
        $webPath = str_replace('eos/user/'.$user[0].'/'.$user.'/www', $user, $path).'/?'.$_SERVER['QUERY_STRING'];
        $webPath = str_replace('storage_mnt/storage/user/'.$user.'/public_html', '~'.$user, $path).'/?'.$_SERVER['QUERY_STRING'];
        print "<span><a class=\"bar\" href=\"$webPath\">$name</a></span>";
      } else {
        print "<span><div class=\"bar\">$name</div></span>";
      }
    } else {
      print "<span><div class=\"bar barEmpty\">$name</div></span>";
    }
  }
  showIfExists('..', 'parent directory');
?>
</div>
<!-- clear some vertical space -->
<br style="clear" />

<!-- display element holding the figure -->
<div>
<?php
function displayFigure($imgname){
    print "<div class='pic'>\n";
    print "<a href=\"$imgname\"><img src=\"$imgname\" style=\"pic\"></a>";
    print "</div>";
}

// get and sort the file names with image extensions
$pngnames = glob('*.png');
$jpgnames = glob('*.jpg');
$imgnames = array_merge($pngnames, $jpgnames);
sort($imgnames);

// select a random image
$imgname = $imgnames[array_rand($imgnames)];

// display image
displayFigure($imgname);
?>
</div>

</body>
</html>
