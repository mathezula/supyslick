<?php
require('txt2html.php');

# we're starting simple.  first we're working with a single directory
# of logfiles from supybot.
# what directory are your log files in?
$log_dir="chanlogs";

# we're starting simple.  first we're working with a single logfile.
# This will be replaced with a directory
# scanner loop that looks for all logfiles with no limitations on format.
# the user will be in a themed list of logfiles as links, much like a 
# directory listing. 
# what is the name of that file?  
$log_name="#slackhappy.20110126.log.txt";

#the log's path is the combination of these two vars.
$log_path=$log_dir.'/'.$log_name;



# import the contents of the logfile into $print_contents
# should this be an array? would that be easier?
$print_contents=file_get_contents($log_path, false);

# convert $print_contents, which is a txt file, into css-themable html.
# right now this is not wrapping anything in div tags because
# I suck at regexp and my php is rusty.
$print_contents=txt2html($print_contents);

# going to html
?>


<html><head></head><body>

<?php
# dump the file
echo($print_contents);

#back to html
?>

</body></html>
