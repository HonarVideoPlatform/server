<?php

?>

<div style="font-family:verdana; font-size: 11px">
Options for hshow (id=<?php echo $hshow_id ?>)<br> 
add '&debug=true' to the url to see the result in a textarea<br> 
<a href="./keditorservices/getAllEntries?hshow_id=<?php echo $hshow_id ?>&debug=<?php echo $debug ?>">getAllEntries</a><br>
<a href="./keditorservices/getHshowInfo?hshow_id=<?php echo $hshow_id ?>&debug=<?php echo $debug ?>">getHshowInfo</a>
<br>
<a href="./keditorservices/getMetadata?hshow_id=<?php echo $hshow_id ?>&debug=<?php echo $debug ?>">getMetadata</a>
<br>
<a href="./keditorservices/setMetadata?hshow_id=<?php echo $hshow_id ?>&debug=<?php echo $debug ?>">setMetadata</a> 
<br>
<a href="./keditorservices/getGlobalAssets?hshow_id=<?php echo $hshow_id ?>&debug=<?php echo $debug ?>">getGlobalAssets (we don't yet have global assets in the DB)</a>
<br>
<a href="./keditorservices/getAllHshows?debug=<?php echo $debug ?>">getAllHshows</a>
</div>
