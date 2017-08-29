<?php
/**
 * @package Core
 * @subpackage model.data
 */
class hStorageDeleteJobData extends hStorageJobData
{
    /**
     * @return hStorageDeleteJobData
     */
    public static function getInstance($protocol)
    {
        $data = null;

        $data = KalturaPluginManager::loadObject('hStorageDeleteJobData', $protocol);
        
        if (!$data)
            $data = new hStorageDeleteJobData();
        
        return $data;
    }
    /**
     * @var StorageProfile $storage
     * @var FileSync $fileSync
     */
    public function setJobData (StorageProfile $storage, FileSync $filesync)
    {
        $this->setServerUrl($storage->getStorageUrl()); 
        $this->setServerUsername($storage->getStorageUsername()); 
        $this->setServerPassword($storage->getStoragePassword());
        $this->setServerPrivateKey($storage->getPrivateKey());
        $this->setServerPublicKey($storage->getPublicKey());
        $this->setServerPassPhrase($storage->getPassPhrase());
        $this->setFtpPassiveMode($storage->getStorageFtpPassiveMode());

        $this->setSrcFileSyncId($filesync->getId());
        $this->setDestFileSyncStoredPath($storage->getStorageBaseDir() . '/' . $filesync->getFilePath());
    }
    
}
