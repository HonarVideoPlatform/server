<?php
/**
 * @package plugins.tvComDistribution
 * @subpackage model.enum
 */ 
interface TVComDistributionField extends BaseEnum
{
	const GUID_ID 							= 'GUID_ID';
	const MEDIA_TITLE 						= 'MEDIA_TITLE';
	const MEDIA_DESCRIPTION 				= 'MEDIA_DESCRIPTION';
	const MEDIA_KEYWORDS 					= 'MEDIA_KEYWORDS';
	const ITEM_PUB_DATE 					= 'ITEM_PUB_DATE';
	const ITEM_EXP_DATE 					= 'ITEM_EXP_DATE';
	const ITEM_LINK 						= 'ITEM_LINK';
	const MEDIA_COPYRIGHT 					= 'MEDIA_COPYRIGHT';
	const MEDIA_RATING 						= 'MEDIA_RATING';
	const MEDIA_RESTRICTION_TYPE 			= 'MEDIA_RESTRICTION_TYPE';
	const MEDIA_RESTRICTION_COUNTRIES 		= 'MEDIA_RESTRICTION_COUNTRIES';
	const MEDIA_CATEGORY_SHOW_TMSID 		= 'MEDIA_CATEGORY_SHOW_TMSID';
	const MEDIA_CATEGORY_SHOW_TMSID_LABEL	= 'MEDIA_CATEGORY_SHOW_TMSID_LABEL';
	const MEDIA_CATEGORY_EPISODE_TMSID 		= 'MEDIA_CATEGORY_EPISODE_TMSID';
	const MEDIA_CATEGORY_EPISODE_TMSID_LABEL = 'MEDIA_CATEGORY_EPISODE_TMSID_LABEL';
	const MEDIA_CATEGORY_EPISODE_TYPE 		= 'MEDIA_CATEGORY_EPISODE_TYPE';
	const MEDIA_CATEGORY_ORIGINAL_AIR_DATE 	= 'MEDIA_CATEGORY_ORIGINAL_AIR_DATE';
	const MEDIA_CATEGORY_VIDEO_FORMAT 		= 'MEDIA_CATEGORY_VIDEO_FORMAT';
	const MEDIA_CATEGORY_SEASON_NUMBER 		= 'MEDIA_CATEGORY_SEASON_NUMBER';
	const MEDIA_CATEGORY_EPISODE_NUMBER 	= 'MEDIA_CATEGORY_EPISODE_NUMBER';
}