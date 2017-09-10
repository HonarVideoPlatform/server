<?php

class myCommentUtils
{
	protected static function createCommentData($comment)
	{
		$commentData = array(
			"id" => $comment->getId(),
		  	"screenName" => $comment->getkuser()->getScreenName(),
		  	"picture" => $comment->getkuser()->getPicturePath(),
		  	"comment" => $comment->getComment(),
			"createdAt" => $comment->getFormattedCreatedAt(),
			);
			
		return $commentData;
	}
	
	/**
	 * Executes getComments action, retrieving the required data for a comment
	 * given the entry id the comment refers to. the data will be used by the view to
	 * return an ajax response.
	 * The request may include 3 fields: page number, page size, entry id.
	 */
	public static function getComments($page, $pageSize, $hshowId, $kuserId)
	{
		$commentsData = array(); // this array will hold the comments data
		$subjectid =  $hshowId > 0 ? $hshowId : $kuserId;
		$subjecttype = $hshowId > 0 ? Comment::COMMENT_TYPE_HSHOW : Comment::COMMENT_TYPE_USER;
	    
		$pager = commentPeer::getOrderedPager( $subjecttype , $subjectid, $pageSize, $page);
	    
		$comments = array();
		
		foreach ($pager->getResults() as $comment)
			$comments[] = self::createCommentData($comment);

		return array('comments' => $comments, 'page' => $page, 'lastPage' => $pager->getLastPage(), 'totalComments' => $pager->getNbResults());
	}
}

?>