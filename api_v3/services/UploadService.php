<?php

/**
 *
 * @service upload
 * @package api
 * @subpackage services
 * @deprecated Please use UploadToken service
 */
class UploadService extends KalturaEntryService
{
	/**
	 * 
	 * @action upload
	 * @param file $fileData The file data
	 * @return string Upload token id
	 */
	function uploadAction($fileData)
	{
		$hsUnique = md5($this->getHs()->toSecureString());
		
		$uniqueId = md5($fileData["name"]);
		
		$ext = pathinfo($fileData["name"], PATHINFO_EXTENSION);
		$token = $hsUnique."_".$uniqueId.".".$ext;
		
		$res = myUploadUtils::uploadFileByToken($fileData, $token, "", null, true);
	
		return $res["token"];
	}
	
	/**
	 * 
	 * @action getUploadedFileTokenByFileName
	 * @param string $fileName
	 * @return KalturaUploadResponse
	 */
	function getUploadedFileTokenByFileNameAction($fileName)
	{
		KalturaResponseCacher::disableConditionalCache();
		
		$res = new KalturaUploadResponse();
		$hsUnique = md5($this->getHs()->toSecureString());
		
		$uniqueId = md5($fileName);
		
		$ext = pathinfo($fileName, PATHINFO_EXTENSION);
		$token = $hsUnique."_".$uniqueId.".".$ext;
		
		$entryFullPath = myUploadUtils::getUploadPath($token, "", null , strtolower($ext)); // filesync ok
		if (!file_exists($entryFullPath))
			throw new KalturaAPIException(KalturaErrors::UPLOADED_FILE_NOT_FOUND_BY_TOKEN);
			
		$res->uploadTokenId = $token;
		$res->fileSize = kFile::fileSize($entryFullPath);
		return $res; 
	}
}