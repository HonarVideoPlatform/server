
<?php echo use_helper('Javascript') ?>

<script type="text/javascript">
var entry_list_as_xml = null;
var hshowId = 10;
var MODULE_BROWSE = '<?php echo url_for( "browse") ?>';
function getAllEntriesAsXml ( )
{
	hshowId = $("hshowId").value;
	entry_list_as_xml = null;
	new Ajax.Request(MODULE_BROWSE + '/getAllEntriesAsXml?' +
	'&hshow_id=' + hshowId 
	, {asynchronous:false, evalScripts:false, onComplete:function(request, json){updateEditorWithAllEntries(request, json)}});
	
	return entry_list_as_xml ;
}

function updateEditorWithAllEntries ( request, json )
{
	entry_list_as_xml = request.responseText;
	//alert ( entry_list_as_xml);
	return entry_list_as_xml;
}
</script>

<div>
<input id="hshowId" name="hshowId" value="10">
get all entries <input type="button"
	onclick="alert ( getAllEntriesAsXml() )" value="Click">
</div>
