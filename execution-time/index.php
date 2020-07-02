<?php
 
// start time
$time_start = microtime(true);
 
// execution script
for($i = 0; $i < 1000000; $i++) {
  // execute something
}
 
// end time
$time_end = microtime(true);
 
// total time
$execution_time = ($time_end - $time_start);
 
//execution time of the script
echo '<b>Total Execution Time:</b> '. number_format((float) $execution_time, 10) . ' in seconds <br />';
echo '<b>Total Execution Time:</b> '. number_format((float) $execution_time, 10)/60 . ' in minutes';
?>