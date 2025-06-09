<?php
$con=mysqli_connect("94.130.179.170","soundsphere_ro","hZJEZFSBxeU4","Stuff");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$stmt = mysqli_query($con,"SELECT Artist, Album, Type, Label, AlbumRelease, Country FROM Stuff.CDs ORDER BY Artist, AlbumRelease ASC");
$column_count = mysqli_num_fields($stmt);
while ($row = mysqli_fetch_row($stmt)) {
     for ($j = 0; $j < $column_count; $j++) {
          echo $row[$j]; // gives the current item of the current attribute in TEST
     }
}
?>
