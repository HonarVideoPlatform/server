<?php

class DeliveryProfileLimeLightHttp extends DeliveryProfileHttp {
	
	protected function doGetFlavorAssetUrl(asset $flavorAsset)
	{
		$url = parent::doGetFlavorAssetUrl($flavorAsset);
		$url = "/s" . $url;
		$url .= '?novar=0';
		return $this->addSeekFromBytes($flavorAsset, $url, 'fs');
	}
	
	// doGetFileSyncUrl - Inherit from parent
}

