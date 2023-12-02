// Document is ready
$(document).ready(function () {	
    
    $("#stockinfotable").hide();
      $('#table_view').click(function () {
          var class_id = $("#class_id").val();
          resetstockinfotable(class_id);   
          $("#stockinfotable").show();           
      });     
  
      $("#papernameCheck").hide();
      $("#max_markCheck").hide();

      $(document).on("click", "#ajaxAllocationBtn", function () { 
          var paper_name=$("#paper_name").val(); 
          var max_mark=$("#max_mark").val();
          var class_id=$("#class_id").val();
          var subject_id=$("#subject_id").val();
          var insert_login_id=$("#insert_login_id").val();
          if(paper_name!="" && max_mark!=""){
              $.ajax({
                  url: 'syllabusFile/ajaxInsertSyllabus.php',
                  type: 'POST',
                  data: {"paper_name":paper_name,"max_mark":max_mark,"class_id":class_id,"insert_login_id":insert_login_id,"subject_id":subject_id},
                  cache: false,
                  success:function(response){
                      var insresult = response.includes("Exists");
                      var updresult = response.includes("Updated");
                      if(insresult){
                          $('#subject_detailsInsertNotOk').show(); 
                          setTimeout(function() {
                              $('#subject_detailsInsertNotOk').fadeOut('fast');
                          }, 2000);
                      }else if(updresult){
                          $('#subject_detailsUpdateOk').show();  
                          setTimeout(function() {
                              $('#subject_detailsUpdateOk').fadeOut('fast');
                          }, 2000);
                          $("#updatedSyllabusTable").remove();
                          resetstockinfotable();
                          $("#paper_name").val('');
                          $("#max_mark").val('');
                          
                      }
                      else{
                          $('#subject_detailsInsertOk').show();  
                          setTimeout(function() {
                              $('#subject_detailsInsertOk').fadeOut('fast');
                          }, 2000);
                          $("#updatedSyllabusTable").remove();
                          resetstockinfotable();
                          $("#paper_name").val('');
                          $("#max_mark").val('');
                      }
                  }
              });
          }
          else{
            $("#papernameCheck").show();
            $("#max_markCheck").show();
          }
      });
   
  
      function resetstockinfotable(){
        var class_id=$("#class_id").val();
          $.ajax({
          url: 'syllabusFile/ajaxResetSyllabusTable.php',
          type: 'POST',
          data: {"class_id":class_id},
          cache: false,
          success:function(html){
              $("#updatedstockinfotable").empty();
              $("#updatedstockinfotable").html(html);
          }
      });
      }
     
       $("#paper_name").keyup(function(){
           var CTval = $("#paper_name").val();
           if(CTval.length == ''){
           $("#papernameCheck").show();
           return false;
           }else{
           $("#papernameCheck").hide();
           }
       });

       $("#max_mark").keyup(function(){
        var CTval = $("#max_mark").val();
        if(CTval.length == ''){
        $("#max_markCheck").show();
        return false;
        }else{
        $("#max_markCheck").hide();
        }
    });
       $("body").on("click","#edit_subject",function(){
           var subject_id=$(this).attr('value');
           $("#subject_id").val(subject_id);
           $.ajax({
                   url: 'syllabusFile/ajaxEditSyllabus.php',
                   type: 'POST',
                   data: {"subject_id":subject_id},
                   cache: false,
                   success:function(response){
                    $("#paper_name").val(response.paper_name);
                    $("#max_mark").val(response.max_mark);
               }
           });
       });
   
     $("body").on("click","#delete_subject", function(){
       var isok=confirm("Do you want delete Subject Name?");
       if(isok==false){
         return false;
       }else{
           var subject_id=$(this).attr('value');
           var c_obj = $(this).parents("tr");
           $.ajax({
               url: 'syllabusFile/ajaxDeleteSyllabus.php',
               type: 'POST',
               data: {"subject_id":subject_id},
               cache: false,
               success:function(response){
                   var delresult = response.includes("Rights");
                   if(delresult){
                   $('#subject_detailsDeleteNotOk').show(); 
                   setTimeout(function() {
                   $('#subject_detailsDeleteNotOk').fadeOut('fast');
                   }, 2000);
                   }
                   else{
                   c_obj.remove();
                   $('#subject_detailsDeleteOk').show();  
                   setTimeout(function() {
                   $('#subject_detailsDeleteOk').fadeOut('fast');
                   }, 2000);
                   }
               }
           });
       }
     });
     
  });
  $(function(){
    $('#updatedSyllabusTable').DataTable({
      'iDisplayLength': 5,
      "language": {
        "lengthMenu": "Display _MENU_ Records Per Page",
        "info": "Showing Page _PAGE_ of _PAGES_",
      }
      
    });
    
  });
  
//   function SyllReport(class_id){
//     $('#syllabus_allocation').empty();
//     $('#syllabus_allocation').append(`<thead><tr><th width="50">S.No.</th><th>Paper Name</th><th>Max Mark</th><th>Action</th></tr></thead><tbody></tbody>`);
//     $('#syllabus_allocation').DataTable({
//         "order": [[ 0, "desc" ]],
//         'processing': true,
//         'serverSide': true,
//         'serverMethod': 'post',
//         'ajax': {
//             'url':'ajaxgetsubject_details.php',
//             'data': function(data){
//                 var search = $('#search').val();
//                 data.search      = search;
//                 data.class_id      = class_id;
//             }
//         },
//         dom: 'lBfrtip',
//         buttons: [
//           {
//             extend:  'print',
//             exportOptions: {
//               columns: [ 0, 1]
//             }
//           },
//             {
//                 extend: 'excel',
//                 title: "Syllabus Report"
//             },
            
//         ],
//         "lengthMenu": [
//             [10, 25, 50, -1],
//             [10, 25, 50, "All"]
//         ]
//     });
//   }