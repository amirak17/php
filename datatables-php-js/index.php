<!doctype html>
<html lang="en">
  <head>
    <?php $step = 1; include('config.php'); // step 1 - title, headings and main table - index.php & response.php ?>

    <title><?php echo $page_title;?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <style type="text/css">
        body { margin: 20px; }
        .numeric-column { text-align: right; }        
        .center-column { text-align: center; }        
    </style>
  </head>
  <body>

    <div class="container">
        <div class="row">
            <div class="col-6">
                <h3><?php echo $page_head;?></h3>
            </div>  
            <div class="col-6">
                <button type="button" class="btn btn-primary float-right" onclick="form_add()">Add Data</button>
            </div>  
        </div>
        <div class="">
            <div class="">
                <table id="the_grid" width="100%" cellspacing="0" cellpadding="5" border="1">
                <thead>
                    <tr>
                        <?php 
                            for($i = 0; $i < count($head_arr); $i++) {
                                echo '<th>'.$head_arr[$i].'</th>';        
                            }
                        ?>
                    </tr>
                </thead>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <?php $step = 3; include('config.php'); // step 3 - js config for datatables - index.php  ?>
    <script>
        jQuery(function() {
            table = jQuery('#the_grid').DataTable( {
                'processing': true,
                'aLengthMenu': [aLengthMenu_opts, aLengthMenu_titles],
                'pageLength': pageLength,
                'ajax': 'response.php?action=table_data',
                'aoColumnDefs': [
                                    { 'sClass': 'numeric-column', 'aTargets': aTargets_right }, 
                                    { 'sClass': 'center-column', 'aTargets': aTargets_center }
                ]
            });
        });

        var save_method, table, msg;

        function form_add() {
           save_method = 'add';
           jQuery('#the-modal').modal('show');
           jQuery('#the-modal form')[0].reset();
           jQuery('.modal-title').text('Add Data');
        }

        function form_edit(id) {
             save_method = 'edit';
             jQuery.ajax({
                url: 'response.php?action=form_data&id='+id,
                type: 'GET',
                dataType: 'JSON',
                success: function(data) {
                   jQuery('#the-modal').modal('show');
                   jQuery('.modal-title').text('Update Data');
              
                   jQuery('#id').val(data.id);
                    <?php $step = 4; include('config.php'); // step 4 - js edit form - index.php ?>
                },
                error: function() {
                   alert('Error!');
                }
             });
        }

        function save_data() {
           if(save_method == 'add') {
              url = 'response.php?action=insert';
              msg = 'Data Saved!';
           }
           else { 
              url = 'response.php?action=update';
              msg = 'Data Updated!';
           }

           jQuery.ajax({
              url: url,
              type: 'POST',
              data: jQuery('#the-modal form').serialize(),
              success: function() {
                 jQuery('#the-modal').modal('hide');
                 jQuery('#the-modal form')[0].reset();
                 alert(msg);
                 table.ajax.reload();         
              },
              error: function() {
                 alert('Error!');
              }     
           });
           return false;
        }

        function delete_data(id) {
           if(confirm('Are you sure to DELETE the data?')){
              jQuery.ajax({
                 url: 'response.php?action=delete&id='+id,
                 type: 'GET',
                 success: function(data){
                    alert('Data Deleted!')
                    table.ajax.reload();
                 },
                 error: function(){
                    alert('Error!');
                 }
              });
           }
        }
   
    </script>

      <div class="modal fade" id="the-modal" tabindex="-1" role="dialog" aria-labelledby="the-modal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
           <form onsubmit="return save_data()">
              <div class="modal-content">
                 <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Add</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                 </div>
                 <div class="modal-body">
                    <input type="hidden" name="id" id="id">

                    <?php $step = 6; include('config.php'); // step 5 - add & edit form fields ?>

                 </div>
                 <div class="modal-footer">
                    <div class="mr-auto">
                       <button type="submit" class="btn btn-primary">Save</button>
                       <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> 
                    </div>
                 </div>
              </div>
           </form>
        </div>
      </div>

  </body>
</html>