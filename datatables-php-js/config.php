<?php 

// Datatables Web Application With Pagination, Sort, Search, Insert, Update, Delete

// The way the this web application works is all you have to do is 
// configure it in 6 simple steps only in this file congfig.php:

// step 1 - title, headings and main table - index.php & response.php
// step 2 - table rows - response.php
// step 3 - js config for datatables - index.php
// step 4 - js edit form - index.php
// step 5 - insert update columns string - response.php
// step 6 - add & edit form fields

// Note: You may make changes as needed in other files.


// db connection
$conn = mysqli_connect('localhost', 'test', 'pwd', 'test');
$db_table = 'tbl';

error_reporting(2); // error_reporting(E_ALL); ini_set('display_errors', 1);


// step 1 - title, headings and main table - index.php & response.php
   if($step == 1) {
      $page_title = 'Student Scores';
      $page_head  = 'Student Scores';
      $head_arr   = array('Name', 'Image', 'Major', 'Score', 'Actions');
   }



// step 2 - show table row - response.php
   if($step == 2) {
      $row[] = $r['fname'];
      $row[] = '<img src="'.$r['img'].'" height="100" />';
      $row[] = $r['major'];
      $row[] = number_format($r['score']);
      $row[] = '<div class="text-center">
                 <a style="color:#fff;" class="btn btn-primary" onclick="form_edit('.$id.')">Edit</a>
                 <a style="color:#fff;" class="btn btn-danger" onclick="delete_data('.$id.')">Delete</a>
               </div>';
   }



// step 3 - js config for datatables - index.php
   if($step == 3) { ?>
      <script type="text/javascript">

         // entries per page
         var aLengthMenu_opts = [5, 10, 25, -1]; 
         var aLengthMenu_titles = [5, 10, 25, 'All'];

         // default entries per page
         var pageLength = 5; // -1 for All

         // right align column for numbers
         var aTargets_right = [ 3 ];
         var aTargets_center = [ 1 ];

      </script>
   <?php } 



// step 4 - js edit form - index.php
   if($step == 4) { ?>
      jQuery('#fname').val(data.fname);
      jQuery('#img').val(data.img);
      jQuery('#major').val(data.major);
      jQuery('#score').val(data.score);
   <?php }


// step 5 - insert update columns string - response.php
   if($step == 5) { 
      $col_str = "
         fname = '$_POST[fname]', 
         img   = '$_POST[img]',
         major = '$_POST[major]',
         score = '$_POST[score]'
      ";
   }

// step 6 - add & edit form fields
   if($step == 6) { ?>

      <div class="form-row">
         <div class="form-group col-md-12">
           <label for="name">Name</label>
           <input type="text" class="form-control" name="fname" id="fname" required>
         </div>
      </div>
      <div class="form-row">
         <div class="form-group col-md-12">
           <label for="name">Image URL</label>
           <input type="text" class="form-control" name="img" id="img" required>
         </div>
      </div>
      <div class="form-row">
         <div class="form-group col-md-12">
           <label for="major">Major</label>
           <select name="major" id="major" class="form-control" required>
              <option value=""></option>
              <option value="Finance">Finance</option>
              <option value="Infotech">Infotech</option>
              <option value="Management">Management</option>
              <option value="Operations">Operations</option>
           </select>
         </div>
      </div>
      <div class="form-row">
         <div class="form-group col-md-12">
           <label for="name">Score</label>
           <input type="number" class="form-control" name="score" id="score" required>
         </div>  
      </div>  

   <?php } 
?>
