<?php use_helper('Validation') ?>
<?php use_helper('Javascript') ?>

<?php 

function retrieveSubject( $type, $id )
{
	switch( $type )
	{
		case flag::SUBJECT_TYPE_ENTRY: { $entry = entryPeer::retrieveByPK( $id ); return 'entry id:'.$id.'<br/>hshow:'.returnHshowLink($entry->getHshowId()).'<br/>Name:'.$entry->getName(); }
		case flag::SUBJECT_TYPE_USER: { $user = kuserPeer::retrieveByPK( $id ); return returnUserLink( $user->getScreenName()); }
		case flag::SUBJECT_TYPE_COMMENT: { $comment = commentPeer::retrieveByPK( $id ); return 'comment id:'.$id.'<br/>Commnet:'.$comment->getComment(); }
		default: return 'Unknown';
	}
}

function returnUserLink( $username )
{
	return "<a href='/index.php/mykaltura/viewprofile?screenname=".$username."'>".$username."</a>";
}

function returnEntryLink( $hshow_id, $entry_id )
{
	return "<a href='/index.php/browse?hshow_id=".$hshow_id."&entry_id=".$entry_id."'>".$entry_id."</a>";
}

function returnHshowLink( $hshow_id )
{
	return "<a href='/index.php/browse?hshow_id=".$hshow_id."'>".$hshow_id."</a>";
}

function returnShowThumbnailLink( $path, $hshow_id )
{
	return "<a href='/index.php/browse?hshow_id=".$hshow_id."'><img src='".$path."' alt='' /></a>";
}

function returnEntryThumbnailLink( $hshow_id, $path, $entry_id, $media_type )
{
	if ($media_type == entry::ENTRY_MEDIA_TYPE_AUDIO)
		$path = "/images/main/ico_sound.gif";
		
	return "<a href='/index.php/browse?".$hshow_id."&entry_id=".$entry_id."'><img src='".$path."' alt='' /></a>";
}

function returnUserThumbnailLink( $path, $screenname )
{
	return "<a href='/index.php/mykaltura/viewprofile?screenname=".$screenname."'><img src='".$path."' alt='' /></a>";
}

function getEntryTypeText( $type )
{
	switch ( $type )
	{
		case entry::ENTRY_MEDIA_TYPE_ANY: return 'Any'; 
		case entry::ENTRY_MEDIA_TYPE_VIDEO: return 'Video'; 
		case entry::ENTRY_MEDIA_TYPE_IMAGE: return 'Image'; 
		case entry::ENTRY_MEDIA_TYPE_TEXT: return 'Text'; 
		case entry::ENTRY_MEDIA_TYPE_HTML: return 'Html'; 
		case entry::ENTRY_MEDIA_TYPE_AUDIO: return 'Audio'; 
		case entry::ENTRY_MEDIA_TYPE_SHOW: return 'Show'; 
		default: return 'unknown type';
	}
}

?>

<?php

$now = date("D M j G:i:s T Y");

$options = dashboardUtils::partnerOptions ( $partner_id );

$bands_only_str =  " (Partner: " .
'<select onchange="partnerSelect(this)" id="partner_id" style="">' .	$options .'</select>' .
")";

//( $bands_only ? " (Bands)" : "(No Bands)" );



	
echo <<<EOT
<div id="header" class="clearfix">
	<div class="top">
		<a href="/index.php/system/login?exit=true">logout</a>
	</div>
	<h1>Kaltura System Dashboard $bands_only_str</h1>
	<span>Updated: $now</span>
</div>

<h2>Summary</h2>
<table border="0" cellspacing="0" cellpadding="10">
	<thead>
		<tr>
			<td>Type</td>
			<td>Total accumulated nubmer</td>
			<td>Created during the last 7 days</td>
			<td>Created during the last 24 hours</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><a href="#shows">Shows</a></td>
			<td>$hshow_count</td><td>$hshow_count7</td>
			<td>$hshow_count1</td>
		</tr>
		<tr class="even">
			<td><a href="#entries">Entries</a></td>
			<td>$entry_count</td><td>$entry_count7</td><td>$entry_count1</td>
		</tr>
		<tr>
			<td><a href="#users">Users</a></td>
			<td>$kuser_count</td><td>$kuser_count7</td>
			<td>$kuser_count1</td>
		</tr>
	</tbody>
</table>
EOT;

echo '<a name="shows"></a>';
$flip = 1;
echo '<h2>Recently created shows</h2>'; 
echo '<table border="0" cellspacing="0" cellpadding="10">';
if( !$hshows ) echo '<h1>No shows found</h1>';
	else 
	{
	echo '<thead><tr><td>ID</td><td>Thumbnail</td><td>Created</td><td>Produer</td><td>Data</td><td >Name</td><td width="40%">Description</td></tr></thead>';
		foreach ( $hshows as $hshow )
		{
			if ( $modified_only ) 
			{
				$has_new_entries = key_exists( $hshow->getId() , $hshows_with_new_entries ) ;
				$new_entries =  $has_new_entries ? " (" . $hshows_with_new_entries[$hshow->getId() ] . ")" : "";
			}
			else
			{
				$has_new_entries = false ;
				$new_entries =  "";
			}
			
			$flip = $flip * -1;
			echo '<tbody>'.
			 ( $has_new_entries ? 
			 	( '<tr '. ( $flip > 0 ? 'class="even2"' : 'class="odd2"') .'>' ) : 
			 	( '<tr '. ( $flip > 0 ? 'class="even"' : '' ) .'>' )
			 ).				
	
			'<td>'.returnHshowLink( $hshow->getId()).'</td>'.
			'<td class="image">'.returnShowThumbnailLink( $hshow->getThumbnailPath(), $hshow->getId() ).'</td>'.
			'<td>'.$hshow->getFormattedCreatedAt().'</td>'.
			'<td>'.returnUserLink( $hshow->getkuser()->getScreenName()).'</td>'.
			'<td>'.$hshow->getTypeText().'<br/>Views:'.$hshow->getViews().'<br/>Roughcuts:' . $hshow->getRoughcutCount(). 
				'<br/>Entries:'.( $hshow->getEntries() - 1 ) . $new_entries .'<br/>Comments:' . $hshow->getComments() . '</td>'.
			'<td>'.$hshow->getName().'</td>'.
			'<td>'.$hshow->getdescription().'</td>'.
			'</tr>'.
			'</tbody>';
		}
	}
echo '</table>';

echo '<a name="entries"></a>';
echo '<h2>Recent Entries</h2>'; 
echo '<table border="0" cellspacing="0" cellpadding="10">';
if( !$entries ) echo '<h3>No entries found</h3>';
	else 
	{
	echo '<thead><tr><td>ID</td><td>Thumbnail</td><td>Created</td><td>Contributor</td><td>Media Type</td><td >Name</td><td width="40%">Part of kaltura</td></tr></thead>';
		foreach ( $entries as $entry )
		{
			$hshow = $entry->gethshow();
			$flip = $flip * -1;
			echo '<tbody>'.
			'<tr '.( $flip > 0 ? 'class="even"' : '').'>'.		
			'<td>'.returnEntryLink( $hshow->getId(), $entry->getId()).'</td>'.
			'<td class="image">'.returnEntryThumbnailLink( $hshow->getId(),$entry->getThumbnailPath(), $entry->getId(), $entry->getMediaType() ).'</td>'.
			'<td>'.$entry->getFormattedCreatedAt().'</td>'.
			'<td>'.returnUserLink( $entry->getkuser()->getScreenName()).'</td>'.
			'<td>'.getEntryTypeText($entry->getMediaType()).'</td>'.
			'<td>'.$entry->getName().'</td>'.
			'<td class="image">'.returnShowThumbnailLink( $hshow->getThumbnailPath(), $hshow->getId() ).' '.$hshow->getName().'</td>'.
			'</tr>'.
			'</tbody>';
		}
	}
echo '</table>';

echo '<a name="users"></a>';
echo '<h2>Recent Users</h2>'; 
echo '<table border="0" cellspacing="0" cellpadding="10">';
if( !$kusers ) echo '<h3>No users found</h3>';
	else 
	{
	echo '<thead><tr><td>ID</td><td>Thumbnail</td><td>Created</td><td>Screenname</td><td>Data</td><td>Demographics</td></tr></thead>';
		foreach ( $kusers as $kuser )
		{
			$flip = $flip * -1;
			echo '<tbody>'.
			'<tr '.( $flip > 0 ? 'class="even"' : '').'>'.	
			'<td>'.$kuser->getId().'</td>'.
			'<td class="image">'.returnUserThumbnailLink( $kuser->getPicturePath(), $kuser->getScreenName() ).'</td>'.
			'<td>'.$kuser->getFormattedCreatedAt().'</td>'.
			'<td>'.returnUserLink( $kuser->getScreenName()).'</td>'.
			'<td>Kalturas:' .$kuser->getProducedHshows() . "<br/>Roughcuts:" . $kuser->getRoughcutCount() .'</td>'.
			'<td class="country">'.($kuser->getCountry() ? image_tag('flags/'.strtolower($kuser->getCountry()).'.gif') : '').' '.$kuser->getCity().' '.$kuser->getState().'<br/>'.($kuser->getGender() == 1 ? 'Male' : ($kuser->getGender() == 2 ? 'Female' : '')).'<br/>'.$kuser->getAboutMe().'</td>'.
			'</tr>'.
			'</tbody>';
		}
	}
echo '</table>';

