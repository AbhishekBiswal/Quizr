<?php
include('db.php');
$array  = $_POST['arrayorder'];
if ($_POST['update'] == 'update'){
$count = 1;
    foreach ($array as $idval) {
        /*$query = 'UPDATE dragdrop SET listorder = ' . $count . ' WHERE id = ' . $idval;*/
        $query = $DBH->prepare("UPDATE questions SET seq=? WHERE id=?");
        /*mysql_query($query) or die('Error, insert query failed');*/
        $query->execute(array($count,$idval));
        $count ++;
    }
    echo 'Saved';
}
?>
