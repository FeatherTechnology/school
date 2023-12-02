<?php 
include '../ajaxconfig.php';

if (isset($_GET['upd'])) {
    $upd = $_GET['upd'];
} 

echo "<script>
    var confirmRestore = confirm('Are you sure you want to restore the student?');
    if (confirmRestore) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'ajaxRestoredDeleteStudent.php?upd=$upd', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = xhr.responseText;
                if (response === 'success') {
                    alert('Student restored successfully.');
                } else {
                    var errorDiv = document.createElement('div');
                    errorDiv.innerHTML = response;
                    alert('Error restoring student:');
                    alert(errorDiv.innerText || errorDiv.textContent);
                }
            } else {
                alert('Error restoring student. Please try again.');
            }
            window.location.href = '../delete_student';
        };
        xhr.send();
    } else {
        window.location.href = '../delete_student';
    }
</script>";
?>
