<?php

function addRow($hshow , $allowactions, $odd)
{
	$id = $hshow['id'];
	$link = '/index.php/browse?hshow_id='.$id;
	
	$s = '<tr '.($odd ? '' : 'class="even"').'>'.
	 	'<td class="imgHolder"><a href="'.$link.'"><img src="'.$hshow['image'].'" alt="Thumbnail" /></a></td>'.
	 	'<td class="info"><a href="'.$link.'">'.$hshow['name'].'</a><br/>'.$hshow['description'].'</td>'.
	 	'<td>'.$hshow['createdAt'].'</td>'.
	 	'<td>'.$hshow['updatedAt'].'</td>'.
		'<td>'.$hshow['roughcuts'].'</td>'.	 	
	 	'<td>'.$hshow['entries'].'</td>'.
	 	'<td>'.$hshow['contributors'].'</td>'.
	 	'<td>'.$hshow['comments'].'</td>'.
	 	'<td>'.$hshow['views'].'</td>'.
	 	'<td><div class="entry_rating" title="'.$hshow['rank'].'"><div style="width:'.($hshow['rank'] * 20).'%"></div></div></td>'.
	 	( $allowactions ? '<td class="action"><span class="btn" title="Customize" onclick="onClickCustomize('.$id.')"></span><span class="btn" title="Delete" onclick="onClickDelete('.$id.')" >Delete</span></td>' : '' ).
	 '</tr>';
	 
	return $s;
}

function firstPage($text, $pagerHtml, $producer_id, $actionTD, $kaltura_part_of_flag, $screenname, $partner_id)
{
	$HSHOW_SORT_MOST_VIEWED = hshow::HSHOW_SORT_MOST_VIEWED;  
	$HSHOW_SORT_MOST_RECENT = hshow::HSHOW_SORT_MOST_RECENT;  
	$HSHOW_SORT_MOST_ENTRIES = hshow::HSHOW_SORT_MOST_ENTRIES;
	$HSHOW_SORT_NAME = hshow::HSHOW_SORT_NAME;
	$HSHOW_SORT_RANK = hshow::HSHOW_SORT_RANK;
	$HSHOW_SORT_MOST_COMMENTS = hshow::HSHOW_SORT_MOST_COMMENTS;
	$HSHOW_SORT_MOST_UPDATED = hshow::HSHOW_SORT_MOST_UPDATED;
	$HSHOW_SORT_MOST_CONTRIBUTORS = hshow::HSHOW_SORT_MOST_CONTRIBUTORS;
	
	$options = dashboardUtils::partnerOptions ( $partner_id );
	
echo <<<EOT
<script type="text/javascript">


var producer_id = 0;
var kaltura_part_of_flag = 0;

jQuery(document).ready(function(){
mediaSortOrder = $HSHOW_SORT_MOST_VIEWED;
var defaultMediaPageSize = 10;
mediaPager = new ObjectPager('media', defaultMediaPageSize, requestMedia);
updatePagerAndRebind ( "media_pager" , null , requestMediaPage );

}); // end document ready


</script>
	<div class="mykaltura_viewAll">
		<div class="content">
			<div class="top">
				<div class="clearfix" style="margin:10px 0;">
					<ul class="pager" id="media_pager" style="float:right; margin:0;">
						$pagerHtml
					</ul>
					<select onchange="partnerSelect(this)" id="partner_id" style="float:left;">
						$options
					</select>
				</div>
			</div><!-- end top-->
			<div class="middle clearfix">	
					<table cellspacing="0" cellpadding="0">
						<thead>
							<tr>
								<td class="resource"></td>
								<td class="info" onclick='changeMediaSortOrder(this, $HSHOW_SORT_NAME)'><span>Kaltura Name</span></td>
								<td class="date" onclick='changeMediaSortOrder(this, $HSHOW_SORT_MOST_RECENT)'><span>Created</span></td>
								<td class="date" onclick='changeMediaSortOrder(this, $HSHOW_SORT_MOST_UPDATED)'><span>Updated</span></td>
								<td class="date" style="width: 25px">RC</td>
								<td class="entries" style="width: 40px" onclick='changeMediaSortOrder(this, $HSHOW_SORT_MOST_ENTRIES)'><span>Entries</span></td>
								<td class="date" style="width: 50px" onclick='changeMediaSortOrder(this, $HSHOW_SORT_MOST_CONTRIBUTORS)'><span>C'tors</span></td>
								<td class="date" style="width: 60px" onclick='changeMediaSortOrder(this, $HSHOW_SORT_MOST_COMMENTS)'><span>Comments</span></td>
								<td class="views color2" onclick='changeMediaSortOrder(this, $HSHOW_SORT_MOST_VIEWED)'><span>Views</span></td>
								<td class="rating" style="width: 60px" onclick='changeMediaSortOrder(this, $HSHOW_SORT_RANK)'><span>Rating</span></td>
								$actionTD
							</tr>
						</thead>
						<tbody id="media_content">
							$text
						</tbody>
					</table>
				
			</div><!-- end middle-->
		</div><!-- end content-->
		<div class="bgB"></div>
	</div><!-- end media-->
EOT;
}


if( $allowactions ) $actionTD = '<td class="action" >Action</td>'; else $actionTD = '';

$text = '';
$i = 0;
foreach($hshowsData as $hshow)
{
	$text .= addRow($hshow , $allowactions, $i);
	$i = 1 - $i;
}
	
$htmlPager = mySmartPagerRenderer::createHtmlPager( $lastPage , $page  );
			
if ($firstTime)
	firstPage($text, $htmlPager, $producer_id, $actionTD, $kaltura_part_of_flag, $screenname , $partner_id );
else {
	$output = array(
		".currentPage" => $page,
		".maxPage" => $lastPage,
		".objectsInPage" => count($hshowsData),
		".totalObjects" => $numResults,
		"media_content" => $text,
		"media_pager" => $htmlPager
		);
	
	echo json_encode($output);
}		

?>
