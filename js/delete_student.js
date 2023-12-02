// Document is ready
$(document).ready(function () {	

        let example = $('#example').DataTable({
           dom: 'lBfrtip', 
            buttons: [
              {
                extend:  'copy',
                exportOptions: {
                  columns: [ 0, 1 ]
                }
              },		
              {
                extend:  'pdf',
                exportOptions: {
                  columns: [ 0, 1 ]
                }
              },
              {
                extend:  'excel',
                exportOptions: {
                  columns: [ 0, 1 ]
                }
              },
              {
                extend:  'print',
                exportOptions: {
                  columns: [ 0, 1 ]
                }
              },
              {		 
                extend:'colvis',
                collectionLayout: 'fixed four-column',
              }

            ],	
            "lengthMenu": [
              [10, 25, 50, -1],
              [10, 25, 50, "All"]
            ]
        });
     
});