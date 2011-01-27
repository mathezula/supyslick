<?php
class LogParser 
{
	protected $filePath;
	protected $logRenderer;
	
	public function __construct($filePath, ILogRenderer $logRenderer)
	{
		$this->filePath = $filePath;
		$this->logRenderer = $logRenderer;
	}
	
	public function parse()
	{
		$renderer = $this->logRenderer;
		$file = fopen($this->filePath, 'r');
		
		$renderer->begin();
		$c = 0;
		while (!feof($file)) {
			$c++;
			$line = trim(fgets($file));
			
			// try to parse as a "say" line
			if (preg_match('@(\d+-\d+-\d+T\d+:\d+:\d+)\s+<([^>]+)>\s*(.*)@si', $line, $matches)) {
				$renderer->addSayLine(strtotime($matches[1]), $matches[2], $matches[3]);
			}
			
			// try to parse as a "me" line
			else if (preg_match('@(\d+-\d+-\d+T\d+:\d+:\d+)\s+\*\s+([^\s]+)\s*(.*)@si', $line, $matches)) {
				$renderer->addMeLine(strtotime($matches[1]), $matches[2], $matches[3]);
			}
			
			// try to parse as an "action" line
			else if (preg_match('@(\d+-\d+-\d+T\d+:\d+:\d+)\s+\*{3}\s+([^\s]+)\s*(.*)@si', $line, $matches)) {
				$renderer->addActionLine(strtotime($matches[1]), $matches[2], $matches[3]);
			}
			
			// unknown
			else {
				#throw new Exception('Unrecognized line in the log on line ' . $c . '.');
			}
		}
		$renderer->end();
		
		fclose($file);
	}
}

interface ILogRenderer
{
	function begin();
	function addSayLine($time, $nick, $text);
	function addMeLine($time, $nick, $text);
	function addActionLine($time, $nick, $text);
	function end();
}

class HtmlLogRenderer implements ILogRenderer
{
	public function begin()
	{
		?>
		<!DOCTYPE html>
		<html>
			<head>
				<title>SupySlick Log Viewer</title>
			</head>
			<link rel="stylesheet" type="text/css" href="css/view.css"> 			

			<body>
			<p>Viewing log...</p>
		<?php
	}
	
	public function addSayLine($time, $nick, $text)
	{
		?>
		<p>
			<span class="time"><?php echo $this->formatTime($time)?></span>
			<span class="nick">&lt;<?php echo $nick?>&gt;</span>
			<span class="sayText"><?php echo $text?></span>
		</p>
		<?php
	}
	
	public function addMeLine($time, $nick, $text)
	{
		?>
		<p>
			<span class="time"><?php echo $this->formatTime($time)?></span>
			<span class="meText">* <?php echo $nick?> <?php echo $text?></span>
		</p>
		<?php
	}
	
	public function addActionLine($time, $nick, $text)
	{
		?>
		<p>
			<span class="time"><?php echo $this->formatTime($time)?></span>
			<span class="actionText">*** <?php echo $nick?> <?php echo $text?></span>
		</p>
		<?php
	}
	
	public function end()
	{
		?>
			<p><a href="javascript:history.go(-1)">[return]</a></p>
			</body>
		</html>
		<?php
	}
	
	protected function formatTime($time)
	{
		return date('Y-m-d H:i:s', $time);
	}
}

?>
