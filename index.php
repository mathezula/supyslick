<?php
// open this directory 
$directory_path = "chanlogs";
$myDirectory = opendir("chanlogs");

// get each entry
while($entryName = readdir($myDirectory)) {
# one array to rule them all...
	$dirArray[] = $entryName;
}

// close directory
closedir($myDirectory);

//	count elements in array
$indexCount	= count($dirArray);
#Print ("$indexCount files<br>\n");

// sort 'em
sort($dirArray);

// print 'em
?>

<link rel="stylesheet" type="text/css" href="css/browse.css"> 
<TABLE border="1" cellpadding="5" cellspacing="0" class="whitelinks">
<TR><TH>Log</TH><th>Date</th><th>Length</th></TR>

<?php // loop through the array of files and print them all
for($index=0; $index < $indexCount; $index++) {
        if (substr("$dirArray[$index]", 0, 1) != "."){ // don't list hidden files
?>
<tr>
	<td>
		<a href="view.php?parse=<?php echo urlencode($dirArray[$index]); ?>"><?php echo $dirArray[$index]; ?></a>
	</td>
	<td>
		<?php #echo filetype($dirArray[$index]); ?>#
	</td>
	<td>
		<?php #echo filesize($dirArray[$index]); ?>#
	</td>
</tr>
<?php
	}
}
?>
</TABLE>
