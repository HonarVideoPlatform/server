<?php
?>

<div style='padding:0;margin:0;font-family:arial;font-size: 11px'>
<form id='form1' method='post'>
<table >
	<tr><td>Source hshow id <input name="source_hshow_id" value="<?php echo $source_hshow_id ?>"></td>
		<td>Target hshow id <input name="target_hshow_id" value="<?php echo $target_hshow_id ?>"></td></tr>
	<tr><td colspan='2'>Kuser names  <input size='100' name="kuser_names" value="<?php echo $kuser_names ?>"></td></tr>
	<tr><td colspan='2'>
	<?php if ( $mode != 2 ) { ?> <input type='submit' id='submit' name='submit' value='submit'> <?php } ?>
	<?php if ( $mode == 2 ) { ?> <input type='submit' id='reset' name='reset' value='reset'> <?php } ?>
	<?php if ( $mode == 1 ) { 
		echo "<span style='font-size:12px;background-color:lightyellow'>Please go over the details and make sure all's OK. go to bottom of page to perform the clone</span>" ; 
	} ?>
		</td></tr> 
</table>
	<input type='hidden' id='clone' name='clone' value='false'>
</form>
<br>
Will clone hshow
<?php flush(); ?>

<table border='1px'  style='padding:0;margin:0;font-family:arial;font-size: 11px'>
<?php echo investigate::printHshowHeader () ;flush();?>
<tr><td colspan=20 style='color:blue;'>Source (From partner_id [<?php echo $source_hshow->getPartnerId() ?>])</td></tr>
<?php echo investigate::printHshow ( $source_hshow ) ;flush();?>
<tr><td colspan=20 style='color:green;'>Target  (To partner_id [<?php echo $target_hshow->getPartnerId() ?>])</td></tr>
<?php echo investigate::printHshow ( $target_hshow) ;flush();?>
</table>

<br>
Kusers:
<table border='1px'  style='padding:0;margin:0;font-family:arial;font-size: 11px'>
<tr>
	<td>id</td>
	<td>Screen Name</td>
	<td>Partner Id</td>
</tr>
<?php foreach ( $list_of_kusers as $kuser ) { ?>
<?php $partner_ok =  $kuser->getPartnerId() == $partner_id; ?>
<tr <?php if ( !$partner_ok ) { echo "style='color:red; font-weight:bold;'" ;} ?>>
	<td><?php echo $kuser->getId() ?> </td>
	<td><?php echo $kuser->getScreenName() ?> </td>
	<td><?php echo $kuser->getPartnerId() ?> <?php if ( !$partner_ok ) { echo " Should be of partner_id [$partner_id]. This kuser will not be used" ;} ?> </td>
</tr>
<?php } ?>	
</table>

<br>
<span ><?php echo "<b>[" . count ( $entries ) . "]</b> " ?>
<?php if ( $mode != 2 ) { ?>Source entries [ONLY type=1 meaning mediaclips , <b>NOT</b> roughcuts or background, With status=2 meaning READY, (<b>NOT</b> being imported or converted)]</span><?php } ?>
<?php if ( $mode == 2 ) { ?>New entries </span><?php } ?>
<table border='1px' style='padding:0;margin:0;font-family:arial;font-size: 11px'>
<?php if ( count ( $entries ) > 0 )  { ?>  
<?php echo investigate::printEntryHeader() ?>
<?php foreach ( $entries as $entry ) {
	$text = null; 
	if ( $mode != 2 ) $text = "Assigned to " . @$entry_kusers[$entry->getId()];
	echo investigate::printEntry( $entry , false , $source_hshow  , $text );
} ?>	 
<?php } ?>
</table>

</div>

<?php if ( $mode == 2 ) die; ?>


<?php if ( $mode == 1 ) { ?>

<script type="text/javascript">
function doClone()
{
	if ( !confirm ( "Are you sure all details above are OK?" ) ) return false; 
	var elem=document.getElementById('clone');
	elem.value='true';
	var frm = document.getElementById('submit');
	frm.click	();
}
</script>

<button onclick='doClone()'>Clone</button>
<?php } ?> 
