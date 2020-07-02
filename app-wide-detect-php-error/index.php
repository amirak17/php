<title>Errr! - Application-Wide PHP Error Detection</title>
<h3>Errr! - Application-Wide PHP Error Detection</h3>
<p>Processing ...</p>
<?php
$arr = array_reverse(get_recursive_files('./'));
$count = 0;
$proc = '';
for($i = 0; $i < count($arr); $i++) {
    $proc = '';
    if(strstr($arr[$i], '.php')) {
        $file = end(explode(basename(__DIR__) . '/', $arr[$i]));
        $file = addslashes($file);
        $file = str_replace(" ", "\ ", $file);
        $proc = exec('php -l ' . $file);
        if(!(strstr($proc, 'No syntax error'))) {
            echo '<font color="red">' . $file . '</font><br />';
            echo $proc . '<br />';
            echo '---------------------------------------------------<br />';
            $count++;
        }
    }
}
?>
<p>Processing Complete.<br /><br />Error(s) in <?php echo $count;?> file(s).</p>
 
<?php
function get_recursive_files($dir, &$results = array()){
    $files = scandir($dir);
    foreach($files as $key => $value){
        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
        if(!is_dir($path)) {
            $results[] = $path;
        } else if($value != "." && $value != "..") {
            get_recursive_files($path, $results);
            $results[] = $path;
        }
    }
    return $results;
}
?>