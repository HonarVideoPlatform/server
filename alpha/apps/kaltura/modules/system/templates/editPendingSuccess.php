<?php

?>
<div style="font-family: arial; font-size: 13px;">
<a href="/index.php/system/login?exit=true">logout</a> Time on Machine: <?php echo date ( "Y-m-d H:i:s." , time() ) ?>
<br>
<form>
	Entry Id: <input type="text" name="entry_id" value="<?php echo $entry_id ?>">
	
	Hshow Id: <input type="text" name="hshow_id" value="<?php echo $hshow_id ?>">
	<a href="./investigate?hshow_id=<?php echo $hshow_id ?>&entry_id=<?php echo $entry_id ?>">investigate</a>
<br>	
<?php if ( !empty ( $metadata ) ) { ?>

Pending string: <input type="input" id="pending" name="pending" value="<?php echo $pending ?>"/>
Remove Pending all together: <input type="checkbox" id="remove_pending" name="remove_pending" />
<?php } ?>
	
<input type="submit" id="Go" name="Go" value="Go"/>


</form>

</div>

<pre style="background-color: lightyellow; width: 80%;">
<?php echo hString::xmlEncode( $metadata ) ?>
</pre>
