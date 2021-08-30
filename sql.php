<!DOCTYPE html>
<html>
<head>
    <title>Run SQL</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="robots" content="all, index, follow"/>
    <meta name="googlebot" content="index, follow" />
    <meta name="revisit-after" content="1 day"/>
    <meta name="rating" content="general"/>

    <link rel="stylesheet" href="style.css" />
    <!--[if lt IE 8]>
    <![endif]-->

    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

    <?php 
// error_reporting(E_ALL); ini_set('display_errors', 1);
        $conn = mysql_connect('localhost', 'db_user', 'db_pwd'); 
        mysql_select_db('db'); 

        function run_sql($query) {
            $result = mysql_query($query);
            if(mysql_num_rows($result) > 0) {
                $str_result = '';
                $str_result .= '<table border="1" cellspacing="0" cellpadding="2">';
                // Columns
                $columns_array = get_column_names($result);
                $str_result .= '<tr style="background-color: #ddd;">';
                for($i = 0; $i < sizeof($columns_array); $i++) {
                    $str_result .= '<th>' . $columns_array[$i] . '</th>';
                }
                $str_result .= '</tr>';
                // Rows
                $i = 0;
                while($row = mysql_fetch_assoc($result)) {
                    $i++;
                    $i % 2 == 0 ? $bg = '#eee': $bg = '#fff';
                    $str_result .= '<tr style="background-color: '.$bg.';">';
                    foreach($row as $key => $value) {
                        if($row[$key] != '')
                            $str_result .= '<td valign="top">' . $row[$key] . '</td>';
                        else
                            $str_result .= '<td>&nbsp;</td>';
                    }
                    $str_result .= '</tr>';
                }
                $str_result .= '</table>' . 'Total Records: ' . $i . '<br /><br />';
                return $str_result;
            }
            else {
                return 'No record found.';
            }
        }

        function get_column_names($res) {
            $i = 0;
            $columns_array = array();
            while ($i < mysql_num_fields($res)) {
                $meta = mysql_fetch_field($res, $i);
                array_push($columns_array, $meta->name);
                $i++;
            }
            return $columns_array;
        }

    ?>
</head>

<body style="font-family: Arial;">

    <h3>Run SQL</h3>
    <div style="display: inline; width: auto; float: left;">
        <?php 
            if(isset($_POST['query'])) {
                $query = $_POST['query'];
                echo 'SQL Result:<br />' . run_sql($query);
            }
            else {
                $query = '';
            }
        ?>
        <form name="form1" method="post" action="">
            <textarea name="query" cols="150" rows="25"><?php echo $query;?></textarea>
            <br /><br />
            <input type="submit" value="  Run SQL  ">
        </form>
    </div>

    <div style="display: inline; width: auto; float: left; padding-left: 20px;">
        <?php echo 'Database Tables<br />' . run_sql('SHOW TABLES');?>
    </div>

</body>
</html>
