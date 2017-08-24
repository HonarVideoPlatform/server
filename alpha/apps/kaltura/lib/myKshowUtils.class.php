<?php

require_once ( __DIR__ . "/myEntryUtils.class.php");

class myHshowUtils
{
	public static function getWidgetCmdUrl($kdata, $cmd = "") //add, hshow, edit
	{
		$domain = requestUtils::getRequestHost();

		$baseCmd = "$domain/index.php/keditorservices/redirectWidgetCmd?kdata=$kdata&cmd=$cmd";

		return $baseCmd;
	}


	public static function createGenericWidgetHtml ( $partner_id, $subp_id, $partner_name ,  $widget_host  , $hshow_id , $user_id , $size='l' , $align='l', $version=null , $version_hshow_name=null , $version_hshow_description=null)
	{
/*		global $partner_id, $subp_id, $partner_name;
		global $WIDGET_HOST;
	*/
	    $media_type = 2;
	    $widget_type = 3;
	    $entry_id = null;

	     // add the version as an additional parameter
		$domain = $widget_host; 
		$swf_url = "/index.php/widget/$hshow_id/" .
			( $entry_id ? $entry_id : "-1" ) . "/" .
			( $media_type ? $media_type : "-1" ) . "/" .
			( $widget_type ? $widget_type : "3" ) . "/" . // widget_type=3 -> WIKIA
			( $version ? "$version" : "-1" );

		$current_widget_hshow_id_list[] = $hshow_id;

		$hshowCallUrl = "$domain/index.php/browse?hshow_id=$hshow_id";
		$widgetCallUrl = "$hshowCallUrl&browseCmd=";
		$editCallUrl = "$domain/index.php/edit?hshow_id=$hshow_id";

	/*
	  widget3:
	  url:  /widget/:hshow_id/:entry_id/:kmedia_type/:widget_type/:version
	  param: { module: browse , action: widget }
	 */
	    if ( $size == "m")
	    {
	    	// medium size
	    	$height = 198 + 105;
	    	$width = 267;
	    }
	    else
	    {
	    	// large size
	    	$height = 300 + 105 + 20;
	    	$width = 400;
	    }

		$root_url = "" ; //getRootUrl();

	    $str = "";//$extra_links ; //"";

	    $external_url = "http://" . @$_SERVER["HTTP_HOST"] ."$root_url";

		$share = "TODO" ; //$titleObj->getFullUrl ();

		// this is a shorthand version of the kdata
	    $links_arr = array (
	    		"base" => "$external_url/" ,
	    		"add" =>  "Special:KalturaContributionWizard?hshow_id=$hshow_id" ,
	    		"edit" => "Special:KalturaVideoEditor?hshow_id=$hshow_id" ,
	    		"share" => $share ,
	    	);

	    $links_str = str_replace ( array ( "|" , "/") , array ( "|01" , "|02" ) , base64_encode ( serialize ( $links_arr ) ) ) ;

		$kaltura_link = "<a href='http://www.kaltura.com' style='color:#bcff63; text-decoration:none; '>Kaltura</a>";
		$kaltura_link_str = "A $partner_name collaborative video powered by  "  . $kaltura_link;

		$flash_vars = array (  "CW" => "gotoCW" ,
	    						"Edit" => "gotoEdit" ,
	    						"Editor" => "gotoEditor" ,
								"Kaltura" => "",//gotoKalturaArticle" ,
								"Generate" => "" , //gotoGenerate" ,
								"share" => "" , //$share ,
								"WidgetSize" => $size );

		// add only if not null
		if ( $version_hshow_name ) $flash_vars["Title"] = $version_hshow_name;
		if ( $version_hshow_description ) $flash_vars["Description"] = $version_hshow_description;

		$swf_url .= "/" . $links_str;
	   	$flash_vars_str = http_build_query( $flash_vars , "" , "&" )		;

	    $widget = /*$extra_links .*/
			 '<object id="kaltura_player_' . (int)microtime(true) . '" type="application/x-shockwave-flash" allowScriptAccess="always" allowNetworking="all" height="' . $height . '" width="' . $width . '" data="'.$domain. $swf_url . '">'.
				'<param name="allowScriptAccess" value="always" />'.
				'<param name="allowNetworking" value="all" />'.
				'<param name="bgcolor" value=#000000 />'.
				'<param name="movie" value="'.$domain. $swf_url . '"/>'.
				'<param name="flashVars" value="' . $flash_vars_str . '"/>'.
				'<param name="wmode" value="opaque"/>'.
				$kaltura_link .
				'</object>' ;

			"</td></tr><tr><td style='background-color:black; color:white; font-size: 11px; padding:5px 10px; '>$kaltura_link</td></tr></table>";

		if ( $align == 'r' )
		{
			$str .= '<div class="floatright"><span>' . $widget . '</span></div>';
		}
		elseif ( $align == 'l' )
		{
			$str .= '<div class="floatleft"><span>' . $widget . '</span></div>';
		}
		elseif ( $align == 'c' )
		{
			$str .= '<div class="center"><div class="floatnone"><span>' . $widget . '</span></div></div>';
		}
		else
		{
			$str .= $widget;
		}

		return $str ;
	}
	/**
	 * Will create the URL for the embedded player for this hshow_id assuming is placed on the current server with the same http protocol.
	 * @param string $hshow_id
	 * @return string URL
	 */
	public static function getEmbedPlayerUrl ( $hshow_id , $entry_id , $is_roughcut = false, $kdata = "")
	{
		// TODO - PERFORMANCE - cache the versions per hshow_id
		// - if an entry_id exists - don't fetch the version for the hshow

		$hshow = hshowPeer::retrieveByPK( $hshow_id );
		if ( !$hshow )
		return array("", "");

		$media_type = entry::ENTRY_MEDIA_TYPE_SHOW;

		if ($entry_id)
		{
			$entry = entryPeer::retrieveByPK($entry_id);
			if ($entry)
			$media_type = $entry->getMediaType();

			// if the entry is one of the hshow roughcuts we want to share the latest roughcut
			if ($entry->getType() == entryType::MIX)
			$entry_id = -1;
		}

		if ( $is_roughcut )
		{
			$show_entry_id = $hshow->getShowEntryId();
			$show_entry = entryPeer::retrieveByPK( $show_entry_id );
			if ( !$show_entry ) return null;
			$media_type = $show_entry->getMediaType();

			$show_version = $show_entry->getLastVersion();
			// set the entry_id to -1 == we want to show the roughcut, not a specific entry.
			$entry_id = $show_entry_id;
		}
		else
		{
			$show_version = -1;
		}

		$partnerId = $hshow->getPartnerId();

		$swf_url = "/index.php/widget/$hshow_id/" . ( $entry_id ? $entry_id : "-1" ) . "/" . ( $media_type ? $media_type : "-1" ) ;

		$domain = requestUtils::getRequestHost();

		$hshowName = $hshow->getName();

		if ($entry_id >= 0)
			$headerImage = $domain.'/index.php/browse/getWidgetImage/entry_id/'.$entry_id;
		else
			$headerImage = $domain.'/index.php/browse/getWidgetImage/hshow_id/'.$hshow_id;


		if (in_array($partnerId, array(1 , 8, 18, 200))) // we're sharing a wiki widget
		{
			$footerImage = $domain.'/index.php/browse/getWidgetImage/partner_id/'.$partnerId;

			$baseCmd = self::getWidgetCmdUrl($kdata);

			$widgetCallUrl = $baseCmd."add";
			$hshowCallUrl = $baseCmd."hshow";
			$editCallUrl = $baseCmd."edit";

			$genericWidget =
			'<object type="application/x-shockwave-flash" allowScriptAccess="always" allowNetworking="all" height="405" width="400" data="'.$domain. $swf_url . '/4/-1/'.$kdata.'"/>'.
			'<param name="allowScriptAccess" value="always" />'.
			'<param name="allowNetworking" value="all" />'.
			'<param name="bgcolor" value="#000000" />'.
			'<param name="movie" value="'.$domain. $swf_url . '/4/-1/'.$kdata.'"/>'.
			'</object>';

			$myspaceWidget = <<<EOT
<table cellpadding="0" cellspacing="0" style="width:400px; margin:0 auto;">
	<tr style="background-color:black;">
		<th colspan="2" style="background-color:black; background: url($headerImage) 0 0 no-repeat;">
			<a href="$hshowCallUrl" style="display:block; height:30px; overflow:hidden;"></a>
		</th>
	</tr>
	<tr style="background-color:black;">
		<td colspan="2">
			<object type="application/x-shockwave-flash" allowScriptAccess="never" allowNetworking="internal" height="320" width="400" data="{$domain}{$swf_url}/1/-1/{$kdata}">
				<param name="allowScriptAccess" value="never" />
				<param name="allowNetworking" value="internal" />
				<param name="bgcolor" value="#000000" />
				<param name="movie" value="{$domain}{$swf_url}/1/-1/{$kdata}" />
			</object>
		</td>
	</tr>
	<tr style="background-color:black;">
		<td style="height:33px;"><a href="$widgetCallUrl" style="display:block; width:199px; height:33px; background:black url(http://www.kaltura.com/images/widget/wgt_btns2.gif) center 0 no-repeat; border-right:1px solid #000; overflow:hidden;"></a></td>
		<td style="height:33px;"><a href="$editCallUrl" style="display:block; width:199px; height:33px; background:black url(http://www.kaltura.com/images/widget/wgt_btns2.gif) center -33px no-repeat; border-left:1px solid #555; overflow:hidden;"></a></td>
	</tr>
	<tr>
		<td colspan="2" style="background-color:black; border-top:1px solid #222; background: url($footerImage) 0 0 no-repeat;">
			<a href="$domain" style="display:block; height:20px; overflow:hidden;"></a>
		</td>
	</tr>
</table>
EOT;
return array($genericWidget, $myspaceWidget);
		}

		$hshowCallUrl = "$domain/index.php/browse?hshow_id=$hshow_id";
		if ($entry_id >= 0)
		$hshowCallUrl .= "&entry_id=$entry_id";

		$widgetCallUrl = "$hshowCallUrl&browseCmd=";

		$editCallUrl = "$domain/index.php/edit?hshow_id=$hshow_id";
		if ($entry_id >= 0)
		$editCallUrl .= "&entry_id=$entry_id";

		if (in_array($partnerId, array(315, 387)))
		{
			$genericWidget =
			'<object type="application/x-shockwave-flash" allowScriptAccess="always" allowNetworking="all" height="407" width="400" data="'.$domain. $swf_url . '/21">'.
			'<param name="allowScriptAccess" value="always" />'.
			'<param name="allowNetworking" value="all" />'.
			'<param name="bgcolor" value="#000000" />'.
			'<param name="flashvars" value="hasHeadline=1&hasBottom=1&sourceLink=remixurl" />';
			'<param name="movie" value="'.$domain. $swf_url . '/21"/>'.
			'</object>';
		}
		else if (in_array($partnerId, array(250)))
		{
			$genericWidget =
			'<object type="application/x-shockwave-flash" allowScriptAccess="always" allowNetworking="all" height="407" width="400" data="'.$domain. $swf_url . '/40">'.
			'<param name="allowScriptAccess" value="always" />'.
			'<param name="allowNetworking" value="all" />'.
			'<param name="bgcolor" value="#000000" />'.
			'<param name="flashvars" value="hasHeadline=1&hasBottom=1&sourceLink=remixurl" />';
			'<param name="movie" value="'.$domain. $swf_url . '/40"/>'.
			'</object>';
		}
		else if (in_array($partnerId, array(321,449)))
		{
			$genericWidget =
			'<object type="application/x-shockwave-flash" allowScriptAccess="always" allowNetworking="all" height="407" width="400" data="'.$domain. $swf_url . '/60">'.
			'<param name="allowScriptAccess" value="always" />'.
			'<param name="allowNetworking" value="all" />'.
			'<param name="bgcolor" value="#000000" />'.
			'<param name="flashvars" value="hasHeadline=1&hasBottom=1&sourceLink=remixurl" />';
			'<param name="movie" value="'.$domain. $swf_url . '/60"/>'.
			'</object>';
		}		
		else
		{
			$genericWidget =
			'<object type="application/x-shockwave-flash" allowScriptAccess="always" allowNetworking="all" height="340" width="400" data="'.$domain. $swf_url . '/2">'.
			'<param name="allowScriptAccess" value="always" />'.
			'<param name="allowNetworking" value="all" />'.
			'<param name="bgcolor" value="#000000" />'.
			'<param name="movie" value="'.$domain. $swf_url . '/2"/>'.
			'</object>';
		}

		$myspaceWidget =
		'<table cellpadding="0" cellspacing="0" style="width:400px; margin:6px auto; padding:0; background-color:black; border:1px solid black;">'.
		'<tr>'.
		'<th colspan="2" style="background-color:black; background: url('.$headerImage.') 0 0 no-repeat;"><a href="'.$hshowCallUrl.'" style="display:block; height:30px; overflow:hidden;"></a></th>'.
		'</tr>'.
		'<tr>'.
		'<td colspan="2">'.
		'<object type="application/x-shockwave-flash" allowScriptAccess="never" allowNetworking="internal" height="320" width="400" data="'.$domain. $swf_url . '/1">'.
		'<param name="allowScriptAccess" value="never" />'.
		'<param name="allowNetworking" value="internal" />'.
		'<param name="bgcolor" value="#000000" />'.
		'<param name="movie" value="'.$domain. $swf_url . '/1"/>'.
		'</object>'.
		'</td>'.
		'</tr>'.
		'<tr>'.
		'<td style="height:33px;"><a href="'.$widgetCallUrl.'contribute" style="display:block; width:199px; height:33px; background: url('.$domain.'/images/widget/wgt_btns2.gif) center 0 no-repeat; border-right:1px solid #000; overflow:hidden;"></a></td>'.
		'<td style="height:33px;"><a href="'.$editCallUrl.'" style="display:block; width:199px; height:33px; background: url('.$domain.'/images/widget/wgt_btns2.gif) center -33px no-repeat; border-left:1px solid #555; overflow:hidden;"></a></td>'.
		'</tr>'.
		'</table>';

		return array($genericWidget, $myspaceWidget);
	}

	/**
	 * Will create the URL for the hshow_id to be used as an HTML link
	 *
	 * @param string $hshow_id
	 * @return string URL link
	 */
	public static function getUrl ( $hshow_id )
	{
		return requestUtils::getWebRootUrl() . "browse?hshow_id=$hshow_id";
	}

	/**
	 * Will return an array of hshows that are 'related' to a given show
	 *
	 * @param string $hshow_id
	 * @return array of
	 */
	public static function getRelatedShows( $hshow_id, $kuser_id, $amount )
	{
		$c = new Criteria();
		$c->addJoin( hshowPeer::PRODUCER_ID, kuserPeer::ID, Criteria::INNER_JOIN);
		$c->add( hshowPeer::ID, 10000, Criteria::GREATER_EQUAL);

		//$c->add( hshowPeer::PRODUCER_ID, $kuser_id );

		// our related algorithm is based on finding shows that have similar 'heavy' tags
		if( $hshow_id )
		{
			$hshow = hshowPeer::retrieveByPK( $hshow_id );
			if( $hshow )
			{
				$tags_string = $hshow->getTags();
				if( $tags_string )
				{
					$tagsweight = array();
					foreach( ktagword::getTagsArray( $tags_string ) as $tag )
					{
						$tagsweight[$tag] = ktagword::getWeight( $tag );
					}
					arsort( $tagsweight );
					$counter = 0;
					foreach( $tagsweight as $tag => $weight )
					{
						if( $counter++ > 2 ) break;
						else
						{
							//we'll be looking for shows that have similar top tags (3 in this case)
							$c->addOr( hshowPeer::TAGS, '%'.$tag.'%', Criteria::LIKE );
						}
					}
				}

				// and of course, we don't want the show itself
				$c->addAnd( hshowPeer::ID, $hshow_id, Criteria::NOT_IN);
			}
		}
		// we want recent ones
		$c->addDescendingOrderByColumn( hshowPeer::UPDATED_AT );
		$c->setLimit( $amount );

		$shows = hshowPeer::doSelectJoinKuser( $c );

		//did we get enough?
		$amount_related = count ($shows);
		if(  $amount_related < $amount )
		{
			// let's get some more, which are not really related, but recent
			$c = new Criteria();
			$c->addJoin( hshowPeer::PRODUCER_ID, kuserPeer::ID, Criteria::INNER_JOIN);
			$c->addDescendingOrderByColumn( hshowPeer::UPDATED_AT );
			$c->setLimit( $amount - $amount_related );
			$moreshows = hshowPeer::doSelectJoinKuser( $c );
			return array_merge( $shows, $moreshows );
		}

		return $shows;

	}

	/**
	 * Will return formatted array of hshows data for shows that are 'related' to a given show
	 *
	 * @param string $hshow_id
	 * @return array of
	 */
	public static function getRelatedShowsData ( $hshow_id, $kuser_id = null, $amount = 50 )
	{
		$hshow_list = self::getRelatedShows ( $hshow_id, $kuser_id, $amount );

		$hshowdataarray = array();

		foreach( $hshow_list as $hshow )
		{

			$data = array ( 'id' => $hshow->getId(),
			'thumbnail_path' => $hshow->getThumbnailPath(),
			'show_entry_id' => $hshow->getShowEntryId(),
			'name' => $hshow->getName(),
			'producer_name' => $hshow->getkuser()->getScreenName(),
			'views' => $hshow->getViews()
			);
			$hshowdataarray[] = $data;
		}
		return $hshowdataarray;
	}

	public static function createTeamImage ( $hshow_id )
	{
		self::createTeam1Image($hshow_id);
		self::createTeam2Image($hshow_id);
	}

	/**
	 * Creates an combined image of the producer and some of the contributors
	 *
	 * @param int $hshow_id
	 */
	const DIM_X = 26;
	const DIM_Y = 23;
	public static function createTeam1Image ( $hshow_id )
	{
		try
		{
			$contentPath = myContentStorage::getFSContentRootPath() ;

			$hshow = hshowPeer::retrieveByPK( $hshow_id );
			if ( ! $hshow ) return NULL;

			// the canvas for the output -
			$im = imagecreatetruecolor(120 , 90 );

			$logo_path = kFile::fixPath( SF_ROOT_DIR.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'main'.DIRECTORY_SEPARATOR.'kLogoBig.gif' );
			$logoIm = imagecreatefromgif( $logo_path );
			$logoIm_x = imagesx($logoIm);
			$logoIm_y = imagesy($logoIm);
			imagecopyresampled($im, $logoIm, 0, 0, 0 , 0 , $logoIm_x *0.25 ,$logoIm_y*0.25, $logoIm_x , $logoIm_y);
			imagedestroy($logoIm);

			// get producer's image
			$producer = kuser::getKuserById( $hshow->getProducerId() );
			$producer_image_path = kFile::fixPath(  $contentPath . $producer->getPicturePath () );
			if (file_exists($producer_image_path))
			{
				list($sourcewidth, $sourceheight, $type, $attr, $srcIm ) = myFileConverter::createImageByFile( $producer_image_path );

				$srcIm_x = imagesx($srcIm);
				$srcIm_y = imagesy($srcIm);
				// producer -
				imagecopyresampled($im, $srcIm, 0, 0, $srcIm_x * 0.1 , $srcIm_y * 0.1 , self::DIM_X * 2  ,self::DIM_Y * 2, $srcIm_x * 0.9 , $srcIm_y * 0.9 );
				imagedestroy($srcIm);
			}

			// fetch as many different kusers as possible who contributed to the hshow
			// first entries willcome up first
			$c = new Criteria();
			$c->add ( entryPeer::HSHOW_ID , $hshow_id );
			$c->add ( entryPeer::TYPE , entryType::MEDIA_CLIP, Criteria::EQUAL );
			//$c->add ( entryPeer::PICTURE, null, Criteria::NOT_EQUAL );
			$c->setLimit( 16 ); // we'll need 16 images of contributers
			$c->addGroupByColumn(entryPeer::KUSER_ID);
			$c->addDescendingOrderByColumn ( entryPeer::CREATED_AT );
			$entries = entryPeer::doSelectJoinkuser( $c );

			if ( $entries == NULL || count ( $entries ) == 0 )
			{
				imagedestroy($im);
				return;
			}

			//		$entry_index = 0;
			$entry_list_len = count ( $entries );
			reset ( $entries );

			if ( $entry_list_len > 0 )
			{
				/*
				 $pos = array(2,3,4, 7,8,9, 10,11,12,13,14, 15,16,17,18,19);
				 $i = 20;
				 while(--$i)
				 {
					$p1 = rand(0, 15);
					$p2 = rand(0, 15);
					$p = $pos[$p1];
					$pos[$p1] = $pos[$p2];
					$pos[$p2] = $p;
					}

					$i = count($entries);
					while($i--)
					{
					$x = current($pos) % 5;
					$y = floor(current($pos) / 5);
					next($pos);
					self::addKuserPictureFromEntry ( $contentPath , $im ,$entries , $x , $y );
					}
					*/

				for ( $y = 0 ; $y <= 1 ; ++$y )
				for ( $x = 2 ; $x <= 4 ; ++ $x  )
				{
					self::addKuserPictureFromEntry ( $contentPath , $im ,$entries , $x , $y );
				}

				for ( $y = 2 ; $y <= 3 ; ++$y )
				for ( $x = 0 ; $x <= 4 ; ++ $x  )
				{
					self::addKuserPictureFromEntry ( $contentPath , $im ,$entries , $x , $y );
				}
			}
			else
			{
				// no contributers - need to create some other image
			}


			// add the clapper image on top


			$clapper_path = kFile::fixPath( SF_ROOT_DIR.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'mykaltura'.DIRECTORY_SEPARATOR.'productionicon.png' );
			$clapperIm = imagecreatefrompng( $clapper_path );
			imagecopyresampled($im, $clapperIm, ( 1.2 * self::DIM_X ) , (1.2 * self::DIM_Y), 0, 0, self::DIM_X ,self::DIM_Y , imagesx($clapperIm) , imagesy($clapperIm) );
			imagedestroy($clapperIm);

			$path = kFile::fixPath( $contentPath.$hshow->getTeamPicturePath() );

			kFile::fullMkdir($path);

			imagepng($im, $path);
			imagedestroy($im);

			$hshow->setHasTeamImage ( true );
			$hshow->save();
		}
		catch ( Exception $ex )
		{
			// nothing much we can do here !

		}
	}

	public static function createTeam2Image ( $hshow_id )
	{
		try
		{
			$hshow = hshowPeer::retrieveByPK( $hshow_id );
			if ( ! $hshow ) return NULL;

			$contentPath = myContentStorage::getFSContentRootPath() ;

			// TODO - maybe start from some kaltura background - so if image is not full - still interesting
			$im = imagecreatetruecolor(24 * 7 - 1, 24  * 2 - 1);

			$logo_path = kFile::fixPath( SF_ROOT_DIR.'/web/images/browse/contributorsBG.gif');
			$im = imagecreatefromgif( $logo_path );

			// fetch as many different kusers as possible who contributed to the hshow
			// first entries will come up first
			$c = new Criteria();
			$c->add ( entryPeer::HSHOW_ID , $hshow_id );
			$c->add ( entryPeer::TYPE , entryType::MEDIA_CLIP, Criteria::EQUAL );
			//$c->add ( entryPeer::PICTURE, null, Criteria::NOT_EQUAL );
			$c->setLimit( 14 ); // we'll need 14 images of contributers
			$c->addGroupByColumn(entryPeer::KUSER_ID);
			$c->addDescendingOrderByColumn ( entryPeer::CREATED_AT );
			$entries = BaseentryPeer::doSelectJoinkuser( $c );

			if ( $entries == NULL || count ( $entries ) == 0 )
			{
				imagedestroy($im);
				return;
			}

			$entry_list_len = count ( $entries );
			reset ( $entries );

			if ( $entry_list_len > 0 )
			{
				for ( $y = 0 ; $y <= 1 ; ++$y )
				for ( $x = 0 ; $x <= 6 ; ++ $x  )
				{
					self::addKuserPictureFromEntry ( $contentPath , $im ,$entries , $x , $y, 1, 24, 24 );
				}
			}
			else
			{
				// no contributers - need to create some other image
			}


			$path = kFile::fixPath( $contentPath.$hshow->getTeam2PicturePath() );

			kFile::fullMkdir($path);

			imagepng($im, $path);
			imagedestroy($im);

			$hshow->setHasTeamImage ( true );
			$hshow->save();
		}
		catch ( Exception $ex )
		{
			// nothing much we can do here !

		}
	}

	private static function addKuserPictureFromEntry ( $contentPath , $im , &$entries , $x , $y , $border = 1, $width = self::DIM_X, $height = self::DIM_Y)
	{
		$entry = current ($entries );

		if ( $entry == NULL )
		{
			// for now - if there are not enough images - stop !
			return ;

			// if we reach here - we want to rotate the images we already used
			reset ( $entries );
			$entry = current ($entries );
		}
		$kuser =  $entry->getKuser();
		$kuser_image_path = kFile::fixPath(  $contentPath . $kuser->getPicturePath () );

		if (file_exists($kuser_image_path))
		{
			list($sourcewidth, $sourceheight, $type, $attr, $kuserIm ) = myFileConverter::createImageByFile( $kuser_image_path );

			if ($kuserIm)
			{
				$kuserIm_x = imagesx($kuserIm);
				$kuserIm_y = imagesy($kuserIm);
				// focus on the ceter of the image - ignore 10% from each side to make the center bigger
				imagecopyresampled($im, $kuserIm, $width * $x , $height * $y, $kuserIm_x * 0.1 , $kuserIm_y * 0.1 , $width - $border  ,$height - $border, $kuserIm_x * 0.9  , $kuserIm_y * 0.9 );
				imagedestroy($kuserIm);
			}
		}
		next ( $entries );
	}

	public static function isSubscribed($hshow_id, $kuser_id, $subscription_type = null)
	{
		$c = new Criteria ();
		$c->add ( HshowKuserPeer::HSHOW_ID , $hshow_id);
		$c->add ( HshowKuserPeer::KUSER_ID , $kuser_id);

		if ($subscription_type !== null)
		$c->add ( HshowKuserPeer::SUBSCRIPTION_TYPE, $subscription_type );

		return HshowKuserPeer::doSelectOne( $c );
	}

	public static function subscribe($hshow_id, $kuser_id, &$message)
	{
		// first check if user already subscribed to this show
		$hshowKuser = self::isSubscribed($hshow_id, $kuser_id);
		if ( $hshowKuser != NULL )
		{
			$message = "You are already subscribed to this Kaltura";
			return false;
		}

		$hshow = hshowPeer::retrieveByPK($hshow_id);
		if (!$hshow)
		{
			$message = "Kaltura $hshow_id doesn't exist";
			return false;
		}

		$kuser = kuserPeer::retrieveByPK($kuser_id);
		if (!$kuser)
		{
			$message = "User $kuser_id doesn't exist";
			return false;
		}

		$showname = $hshow->getName();
		$subscriberscreenname = $kuser->getScreenName();

		// subscribe
		$hshowKuser = new HshowKuser();
		$hshowKuser->setHshowId($hshow_id);
		$hshowKuser->setKuserId($kuser_id);
		$hshowKuser->setSubscriptionType(HshowKuser::HSHOW_SUBSCRIPTION_NORMAL);
		// alert:: KALTURAS_PRODUCED_ALERT_TYPE_SUBSCRIBER_ADDED
		$hshowKuser->setAlertType(21);
		$hshowKuser->save();

		$message = "You are now subscribed to $showname. You can receive updates and join the discussion.";
		return true;
	}

	public static function unsubscribe( $hshow_id, $kuser_id, &$message )
	{
		// first check if user already subscribed to this show
		$hshowKuser = self::isSubscribed($hshow_id, $kuser_id, HshowKuser::HSHOW_SUBSCRIPTION_NORMAL);

		if ( !$hshowKuser )
		{
			$hshow = hshowPeer::retrieveByPK($hshow_id);
			if (!$hshow)
			{
				$message = "Kaltura $hshow_id doesn't exist.";
			}
			else
			{
				$kuser = kuserPeer::retrieveByPK($kuser_id);
				if (!$kuser)
				{
					$message = "User $kuser_id doesn't exist.";
				}
				else
				$message = "Error - You are not subscribed to this Kaltura.";
			}

			return false;
		}

		// ok, we found he entry, so delete it.
		$hshowKuser->delete();
		$message = "You have unsubscribed from this Kaltura.";
		return true;
	}

	public static function canEditHshow ( $hshow_id , $existing_hshow , $likuser_id )
	{
		if ( $existing_hshow == NULL )
		{
			// TODO - some good error -
			// TODO - let's make a list of all errors we encounter and see how we use the I18N and built-in configuration mechanism to maintain the list
			// and later on translate the errors.
			// ERROR::fatal ( 12345 , "Hshow with id [" .  $hshow_id . "] does not exist in the system. This is either an innocent mistake or you are a wicked bastard" );
			// TODO - think of our policy - what do we do if we notice what looks like an attemp to harm the system ?
			// because the system is not stable, mistakes like this one might very possibly be innocent, but later on - what should happen in XSS / SQL injection /
			// attemp to insert malformed data ?

			return false;
		}

		// make sure the logged-in user is allowed to access this hshow in 2 aspects:
		// 1. - it is produced by him or a template
		if ( $existing_hshow->getProducerId() != $likuser_id )
		{
			//ERROR::fatal ( 10101 , "User (with id [" . $likuser_id . "] is attempting to modify a hshow with id [$hshow_id] that does not belong to him (producer_id [" . $existing_hshow->getProducerId() . "] !!" );

			return false;
		}

		return true;
	}

	public static function fromatPermissionText ( $hshow_id , $hshow = null )
	{
		if ( $hshow == NULL )
		{
			$hshow = hshowPeer::retrieveByPK ( $hshow_id );
		}

		if ( !$hshow )
		{
			// ERROR !
			return "";
		}

		$pwd_permissions = $hshow->getViewPermissions() == hshow::HSHOW_PERMISSION_INVITE_ONLY ||
		$hshow->getEditPermissions() == hshow::HSHOW_PERMISSION_INVITE_ONLY ||
		$hshow->getContribPermissions() == hshow::HSHOW_PERMISSION_INVITE_ONLY;

		// no password protection
		if ( ! $pwd_permissions ) return "";


		$str =
		( $hshow->getViewPermissions() == hshow::HSHOW_PERMISSION_INVITE_ONLY ? "View password " . $hshow->getViewPassword() . " " : "") .
		( $hshow->getContribPermissions() == hshow::HSHOW_PERMISSION_INVITE_ONLY ? "Contribute password " . $hshow->getContribPassword() . " " : "") .
		( $hshow->getEditPermissions() == hshow::HSHOW_PERMISSION_INVITE_ONLY ? "Edit password " . $hshow->getEditPassword() . " " : "") ;

		return $str;
	}

	public static function getViewerType($hshow, $kuserId)
	{
		$viewerType = HshowKuser::HSHOWKUSER_VIEWER_USER; // viewer
		if ($kuserId)
		{
			if ($hshow->getProducerId() == $kuserId) {
				$viewerType = HshowKuser::HSHOWKUSER_VIEWER_PRODUCER; // producer
			}
			else
			{
				if (myHshowUtils::isSubscribed($hshow->getId(), $kuserId))
				$viewerType = HshowKuser::HSHOWKUSER_VIEWER_SUBSCRIBER; // subscriber;
			}
		}

		return $viewerType;
	}

	private static function resetHshowStats ( $target_hshow , $reset_entry_stats = false )
	{
		// set all statistics to 0
		$target_hshow->setComments ( 0 );
		$target_hshow->setRank ( 0 );
		$target_hshow->setViews ( 0 );
		$target_hshow->setVotes ( 0 );
		$target_hshow->setFavorites ( 0 );
		if ( $reset_entry_stats )
		{
			$target_hshow->setEntries ( 0 );
			$target_hshow->setContributors ( 0 );
		}
		$target_hshow->setSubscribers ( 0 );
		$target_hshow->setNumberOfUpdates ( 0 );

		$target_hshow->setCreatedAt( time() );
		$target_hshow->setUpdatedAt( time() );

	}

	public static function shalowCloneById ( $source_hshow_id , $new_prodcuer_id )
	{
		$hshow = hshowPeer::retrieveByPK( $source_hshow_id );
		if ( $hshow ) return self::shalowClone( $hshow , $new_prodcuer_id );
		else NULL;
	}

	public static function shalowClone ( hshow $source_hshow , $new_prodcuer_id )
	{
		$target_hshow = $source_hshow->copy();

		$target_hshow->setProducerId( $new_prodcuer_id ) ;

		$target_hshow->save();

		self::resetHshowStats( $target_hshow , true );
		if (!$source_hshow->getEpisodeId())
			$target_hshow->setEpisodeId( $source_hshow->getId());
		//$target_hshow->setHasRoughcut($source_hshow->getHasRoughcut());

		$target_show_entry = $target_hshow->createEntry ( entry::ENTRY_MEDIA_TYPE_SHOW , $new_prodcuer_id );

		$content = myContentStorage::getFSContentRootPath();
		$source_thumbnail_path = $source_hshow->getThumbnailPath();
		$target_hshow->setThumbnail ( null );
		$target_hshow->setThumbnail ( $source_hshow->getThumbnail() );
		$target_thumbnail_path = $target_hshow->getThumbnailPath();

//		myContentStorage::moveFile( $content . $source_thumbnail_path , $content . $target_thumbnail_path , false , true );

		$target_hshow->save();

		// copy the show_entry file content
		$source_show_entry = entryPeer::retrieveByPK( $source_hshow->getShowEntryId() );

		$source_show_entry_data_key = $source_show_entry->getSyncKey(entry::FILE_SYNC_ENTRY_SUB_TYPE_DATA);
		$target_show_entry->setData ( null );
		$target_show_entry->setData ( $source_show_entry->getData() );
		$target_show_entry_data_key = $target_show_entry->getSyncKey(entry::FILE_SYNC_ENTRY_SUB_TYPE_DATA);
		
		$target_show_entry->setName ( $source_show_entry->getName() );
		$target_show_entry->setLengthInMsecs( $source_show_entry->getLengthInMsecs() );
		
		kFileSyncUtils::softCopy($source_show_entry_data_key, $target_show_entry_data_key);
		//myContentStorage::moveFile( $content . $source_show_entry_path , $content . $target_show_entry_path , false , true );

		myEntryUtils::createThumbnail($target_show_entry, $source_show_entry, true);
		
//		$target_hshow->setHasRoughcut(true);
//		$target_hshow->save();
		
		$target_show_entry->save();

		return $target_hshow;
	}


	// use the entry's thumbnail as this hshow's thumbnail
	public static function updateThumbnail ( $hshow , entry $entry , $should_force = false )
	{
		// We don't want to copy thumbnails of entries that are not ready - they are bad and will later be replaced anyway
		if ( $entry->getThumbnail() != null && $entry->isReady() )
		{
			$show_entry = $hshow->getShowEntry();
			return myEntryUtils::createThumbnail ( $show_entry , $entry , $should_force );
		}
		return false;
	}


	public static function getHshowAndEntry ( &$hshow_id , &$entry_id )
	{
		$error = null;
		$hshow = null;
		$entry = null;
		$error_obj = null;
		if ( $entry_id == NULL || $entry_id == "-1" )
		{
			if ($hshow_id)
			{
				$hshow = hshowPeer::retrieveByPK( $hshow_id );
				if ( ! $hshow )
				{
					$error =  APIErrors::INVALID_HSHOW_ID; // "hshow [$hshow_id] does not exist";
					$error_obj = array ( $error , $hshow_id  );
				}
				else
				{
					$entry_id = $hshow->getShowEntryId();
					$entry = $hshow->getShowEntry();
				}
			}
		}
		else
		{
			$entry = entryPeer::retrieveByPK($entry_id);
			if ( $entry )
			{
				$hshow = @$entry->getHshow();
				$hshow_id = $entry->getHshowId();
			}
		}

		if ( $entry == NULL )
		{
			$error =  APIErrors::INVALID_ENTRY_ID; //"No such entry [$entry_id]" ;
			$error_obj = array ( $error , "entry" , $entry_id  );
		}

		return array ( $hshow , $entry , $error , $error_obj );
	}

	/*
	 * @param unknown_type $generic_id
	 * A generic_id is a strgin starting with w- or k- or e-
	 * then comes the real id -
	 * 	w- a widget id which is a 32 character md5 string
	 *  k- a hshow id which is an integer
	 *  e- an entry id which is an integer
	 */
// TODO - cache the ids !!!
	public static function getWidgetHshowEntryFromGenericId( $generic_id )
	{
		if ( $generic_id == null )
			return null;
		$prefix = substr ( $generic_id , 0 , 2 );
		if ( $prefix == "w-" )
		{
			$id = substr ( $generic_id , 2 ); // the rest of the string
			$widget = widgetPeer::retrieveByPK( $id , null , widgetPeer::WIDGET_PEER_JOIN_ENTRY +  widgetPeer::WIDGET_PEER_JOIN_HSHOW ) ;
			if ( ! $widget )
				return null;
			$hshow = $widget->getHshow();
			$entry = $widget->getEntry();

			return array ( $widget , $hshow , $entry );
		}
		elseif ( $prefix == "k-" )
		{
			$id = substr ( $generic_id , 2 ); // the rest of the string
			list ( $hshow , $entry , $error ) = self::getHshowAndEntry ( $id , -1 );
			if ( $error )	return null;
			return array ( null , $hshow , $entry );
		}
		elseif ( $prefix == "e-" )
		{
			$id = substr ( $generic_id , 2 ); // the rest of the string
			list ( $hshow , $entry , $error ) = self::getHshowAndEntry ( -1 , $id );
			if ( $error )	return null;
			return array ( null , $hshow , $entry );
		}
		else
		{
			// not a good prefix - why guess ???
			return null;
		}
	}

	/**
	 * Will search for a hshow for the specific partner & key.
	 * The key can be combined from the kuser_id and the group_id
	 * If not found - will create one
	 * If both the kuser_id & group_id are null - always create one
	 */
	public static function getDefaultHshow ( $partner_id , $subp_id, $puser_kuser , $group_id = null , $allow_quick_edit = null , $create_anyway = false , $default_name = null )
	{
		$kuser_id = null;
		// make sure puser_kuser object exists so function will not exit with FATAL
		if($puser_kuser)
		{
			$kuser_id = $puser_kuser->getKuserId();
		}
		$key = $group_id != null ? $group_id : $kuser_id;
		if ( !$create_anyway )
		{
			$c = new Criteria();
			myCriteria::addComment( $c , "myHshowUtils::getDefaultHshow");
			$c->add ( hshowPeer::GROUP_ID , $key );
			$hshow = hshowPeer::doSelectOne( $c );
			if ( $hshow ) return $hshow;
					// no hshow - create using the service
			$name = "{$key}'s generated show'";
		}
		else
		{
			$name = "a generated show'";
		}

		if	( $default_name ) 
			$name = $default_name;
		
		$extra_params = array ( "hshow_groupId" => $key , "hshow_allowQuickEdit" => $allow_quick_edit ); // set the groupId with the key so we'll find it next time round
		$hshow = myPartnerServicesClient::createHshow ( "" , $puser_kuser->getPuserId() , $name , $partner_id , $subp_id , $extra_params );
		
		return $hshow;
	}
	
	public static function getHshowFromPartnerPolicy ( $partner_id, $subp_id , $puser_kuser , $hshow_id , $entry )
	{
	    if ( $hshow_id == hshow::HSHOW_ID_USE_DEFAULT )
        {
// see if the partner has some default hshow to add to
            $hshow = myPartnerUtils::getDefaultHshow ( $partner_id, $subp_id , $puser_kuser  );
if ( $hshow ) $hshow_id = $hshow->getId();
        }
		elseif ( $hshow_id == hshow::HSHOW_ID_CREATE_NEW )
        {
// if the partner allows - create a new hshow 
            $hshow = myPartnerUtils::getDefaultHshow ( $partner_id, $subp_id , $puser_kuser , null , true );
if ( $hshow ) $hshow_id = $hshow->getId();
        }   
		else
        {
$hshow = hshowPeer::retrieveByPK( $hshow_id );
        }

if ( ! $hshow )
        {
            // the partner is attempting to add an entry to some invalid or non-existing kwho
            $this->addError( APIErrors::INVALID_HSHOW_ID, $hshow_id );
            return;
        }	
        return $hshow;	
	}	
}
?>
