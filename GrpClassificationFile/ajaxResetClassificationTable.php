<?php
include '../ajaxconfig.php';
?>

<table class="table custom-table" id="departmentTable"> 
    <thead>
        <tr>
            <th>S. No</th>
            <th>Classification</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $ctselect="SELECT * FROM grp_classification WHERE 1 AND status=0 ORDER BY grp_classification_id  DESC";
        $ctresult=$con->query($ctselect);
        if($ctresult->num_rows>0){
        $i=1;
        while($ct=$ctresult->fetch_assoc()){
        ?>
        <tr>
        <td><?php echo $i; ?></td>
        <td><?php if(isset($ct["grp_classification_name"])){ echo $ct["grp_classification_name"]; }?></td>
        <td>
            <a id="edit_department" value="<?php if(isset($ct["grp_classification_id "])){ echo $ct["grp_classification_id "];}?>"><span class="icon-border_color"></span></a> &nbsp;
                <a id="delete_department" value="<?php if(isset($ct["grp_classification_id "])){ echo $ct["grp_classification_id "]; }?>"><span class='icon-trash-2'></span>
            </a>
            </td>
        </tr>
        <?php $i = $i+1; }} ?>
    </tbody>
</table>

<script type="text/javascript">
$(function(){
  $('#departmentTable').DataTable({
    'iDisplayLength': 5,
    "language": {
      "lengthMenu": "Display _MENU_ Records Per Page",
      "info": "Showing Page _PAGE_ of _PAGES_",
    }
  });
});
</script>