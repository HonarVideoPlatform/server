<?php
//$hshow_id = $hshow ? $hshow->getId() : "";
$band_id = $hshow ? $hshow->getIndexedCustomData1() : "";
$delete_text = $should_delete ? "Deleted " : "Will delete ";

$hshow_count = count ( $other_hshows_by_producer );

echo $error . "<br>";

$url = url_for ( "/system") . "/deleteHshow?hshow_id="; 
if ( $hshow_count > 1 )
{
	$str = "";
	foreach ( $other_hshows_by_producer as $other_hshow )
	{
		$str .= "<a href='$url" . $other_hshow->getId() ."'>" .$other_hshow->getId() . "</a> "; 
	}
	
	echo $str;
}

if ( $kuser_count > 1 )
{
	echo "There are [$kuser_count] results for [$kuser_name]. Bellow is displayed the first one.<br>You may want to better specify the screen name." ; 
}
?>
 
<form id="form1" method=get>
	hshow id: <input name="hshow_id" value="<?php echo $hshow_id ?>"> band id: <input name="band_id" value="<?php echo $band_id ?>">
	User name: <input name="kuser_name" value="<?php echo $kuser_name ?>">
	<input type="hidden" id="deleteme" name="deleteme" value="false">
	<input type="submit"  name="find" value="find">
</form>

<?php if ( !$hshow )
{
	if ( $hshow_id )
	{
		echo "Hshow id [" . $hshow_id . "] does not exist in the DB";
	}	
	return ;
}

?>

<?php if ( $kuser && $hshow_count < 2 )
{
	echo $delete_text . "kuser '" . $kuser->getScreenName() . "' [" . $kuser->getId()
	. "] which was created at " . $kuser->getCreatedAt() . " (" .  $kuser->getFormattedCreatedAt() . ")" ; 
} ?>
<br> 

<?php echo $delete_text . "'" . $hshow->getName() ."' [" . $hshow->getId() ."] with band id . " . $hshow->getIndexedCustomData1() . ":" ?>
<br>
<table>
<?php 
echo investigate::printHshowHeader();
echo investigate::printHshow( $hshow );
?>
</table>
<br>
and entries:<br>
<table>
<?php
echo investigate::printEntryHeader();
foreach ( $entries as $entry )
{
	echo investigate::printEntry( $entry );	
}
?>
</table>

<br>
<input type="button" name="Delete" value="Delete" onclick="deleteme()">

<script>
function deleteme()
{
<?php if ( $hshow_count ) { ?>
	text = "kuser '<?php echo $kuser->getScreenName()?>' will not be deleted becuase he/she has (<?php echo $hshow_count ?>) hshows.'\n" + 
		"One of the hshows: hshow '<?php echo $hshow->getName() ?>' with all (<?php echo count ( $entries ) ?>) entries\n" +
			"????\n\n" +
			"Remember - this action is NOT reversible!!" ;
	
<?php } else { ?>
	text = "Do you really want to delete poor kuser '<?php echo $kuser->getScreenName()?>'\n" + 
		"and it's hshow '<?php echo $hshow->getName() ?>' with all (<?php echo count ( $entries ) ?>) entries\n" +
			"????\n\n" +
			"Remember - this action is NOT reversible!!" ;
<?php } ?>
	if ( confirm ( text ) )
	{
		text2 = "I'll ask again...\n\n" + text + "\n\n\n";
		if (  confirm ( text2) ) 
		{
			deleteImpl();
		}
	}
}

function deleteImpl()
{
	e = jQuery ( "#deleteme" );
	e.attr ("value", "true" ); 
	
	jQuery ( "#form1")[0].submit()
}
</script>
	