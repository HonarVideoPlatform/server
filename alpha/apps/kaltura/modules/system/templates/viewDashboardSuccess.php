<?php $sf_context->getResponse()->setTitle("Kaltura - Dashboard")?>

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
	return "<a href='/index.php/browse?hshow_id=".$hshow_id."'><img width='50' src='".$path."' /></a>";
}

function returnEntryThumbnailLink( $hshow_id, $path, $entry_id, $media_type )
{
	if ($media_type == entry::ENTRY_MEDIA_TYPE_AUDIO)
		$path = "/images/main/ico_sound.gif";
		
	return "<a href='/index.php/browse?".$hshow_id."&entry_id=".$entry_id."'><img width='50' src='".$path."' /></a>";
}

function returnUserThumbnailLink( $path, $screenname )
{
	return "<a href='/index.php/mykaltura/viewprofile?screenname=".$screenname."'><img width='50' src='".$path."' /></a>";
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
<a href="/index.php/system/login?exit=true">logout</a><br>
<?php
echo '<h1>Kaltura System Dashboard</h1><p>Updated: '.date("D M j G:i:s T Y").'</p>'; 

echo '<h2>Summary</h2>';
echo '<TABLE border="1" cellspacing="2" cellpadding="10" bgcolor="#efefef" >';
echo '<TR bgcolor="#eee"><TD>Type</TD><TD>Total accumulated nubmer</TD><TD>Created during the last 7 days</TD><TD>Created during the last 24 hours</TD></TR>';
echo '<TR><TD><a href="#shows">Shows</a></TD><TD>'.$hshow_count.'</TD><TD>'.$hshow_count7.'</TD><TD>'.$hshow_count1.'</TD></TR>';
echo '<TR><TD><a href="#entries">Entries</a></TD><TD>'.$entry_count.'</TD><TD>'.$entry_count7.'</TD><TD>'.$entry_count1.'</TD></TR>';
echo '<TR><TD><a href="#users">Users</a></TD><TD>'.$kuser_count.'</TD><TD>'.$kuser_count7.'</TD><TD>'.$kuser_count1.'</TD></TR>';
echo '</TABLE>';

echo '<a name="shows"></a>';
$flip = 1;
echo '<h2>Recently created shows</h2>'; 
echo '<TABLE border="1" cellspacing="2" cellpadding="10">';
if( !$hshows ) echo '<h1>No shows found</h1>';
	else 
	{
	echo '<TR><TD>ID</TD><TD>Thumbnail</TD><TD>Created</TD><TD>Produer</TD><TD>Data</TD><TD >Name</TD><TD width="40%">Description</TD></TR>';
		foreach ( $hshows as $hshow )
		{
			$flip = $flip * -1;
			echo '<TR '.( $flip > 0 ? 'bgcolor="#eee"' : 'bgcolor="#ddd"').'>'.	
			'<TD>'.returnHshowLink( $hshow->getId()).'</TD>'.
			'<TD>'.returnShowThumbnailLink( $hshow->getThumbnailPath(), $hshow->getId() ).'</TD>'.
			'<TD>'.$hshow->getFormattedCreatedAt().'</TD>'.
			'<TD>'.returnUserLink( $hshow->getkuser()->getScreenName()).'</TD>'.
			'<TD>'.$hshow->getTypeText().'<br/>Views:'.$hshow->getViews().'<br/>Entries:'.( $hshow->getEntries() - 1 ) .'</TD>'.
			'<TD>'.$hshow->getName().'</TD>'.
			'<TD>'.$hshow->getDescription().'</TD>'.
			
			'</TR>';
		}
	}
echo '</TABLE>';

echo '<a name="entries"></a>';
echo '<h2>Recent Entries</h2>'; 
echo '<TABLE border="1" cellspacing="2" cellpadding="10">';
if( !$entries ) echo '<h3>No entries found</h3>';
	else 
	{
	echo '<TR><TD>ID</TD><TD>Thumbnail</TD><TD>Created</TD><TD>Contributor</TD><TD>Media Type</TD><TD >Name</TD><TD width="40%">Part of kaltura</TD></TR>';
		foreach ( $entries as $entry )
		{
			$hshow = $entry->gethshow();
			$flip = $flip * -1;
			echo '<TR '.( $flip > 0 ? 'bgcolor="#eee"' : 'bgcolor="#ddd"').'>'.	
			'<TD>'.returnEntryLink( $hshow->getId(), $entry->getId()).'</TD>'.
			'<TD>'.returnEntryThumbnailLink( $hshow->getId(),$entry->getThumbnailPath(), $entry->getId(), $entry->getMediaType() ).'</TD>'.
			'<TD>'.$entry->getFormattedCreatedAt().'</TD>'.
			'<TD>'.returnUserLink( $entry->getkuser()->getScreenName()).'</TD>'.
			'<TD>'.getEntryTypeText($entry->getMediaType()).'</TD>'.
			'<TD>'.$entry->getName().'</TD>'.
			'<TD>'.returnShowThumbnailLink( $hshow->getThumbnailPath(), $hshow->getId() ).' '.$hshow->getName().'</TD>'.
			'</TR>';
		}
	}
echo '</TABLE>';

echo '<a name="users"></a>';
echo '<h2>Recent Users</h2>'; 
echo '<TABLE border="1" cellspacing="2" cellpadding="10">';
if( !$kusers ) echo '<h3>No users found</h3>';
	else 
	{
	echo '<TR><TD>ID</TD><TD>Thumbnail</TD><TD>Created</TD><TD>Screenname</TD><TD>Demographics</TD></TR>';
		foreach ( $kusers as $kuser )
		{
			$flip = $flip * -1;
			echo '<TR '.( $flip > 0 ? 'bgcolor="#eee"' : 'bgcolor="#ddd"').'>'.	
			'<TD>'.$kuser->getId().'</TD>'.
			'<TD>'.returnUserThumbnailLink( $kuser->getPicturePath(), $kuser->getScreenName() ).'</TD>'.
			'<TD>'.$kuser->getFormattedCreatedAt().'</TD>'.
			'<TD>'.returnUserLink( $kuser->getScreenName()).'</TD>'.
			'<TD>'.($kuser->getCountry() ? image_tag('flags/'.strtolower($kuser->getCountry()).'.gif') : '').' '.$kuser->getCity().' '.$kuser->getState().'<br/>'.($kuser->getGender() == 1 ? 'Male' : ($kuser->getGender() == 2 ? 'Female' : '')).'<br/>'.$kuser->getAboutMe().'</TD>'.
			
			'</TR>';
		}
	}
echo '</TABLE>';

