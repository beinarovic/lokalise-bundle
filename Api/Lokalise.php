<?php
namespace Alicorn\LokaliseBundle\Api;

class Lokalise
{
    private $baseUrl;
    private $apiToken;
    private $projectId;
    private $type;
    private $useOriginal;
    private $bundleStructure;

    public function __construct($baseUrl, $apiToken, $projectId, $type, $useOriginal, $bundleStructure)
    {
        $this->baseUrl = $baseUrl;
        $this->apiToken = $apiToken;
        $this->projectId = $projectId;
        $this->type = $type;
        $this->useOriginal = $useOriginal;
        $this->bundleStructure = $bundleStructure;
    }

    /**
     * @return array
     */
    public function projectExport()
    {
        return $this->sendPost('project/export', [
            'type' => $this->type,
            'use_original' => $this->useOriginal,
            'bundle_structure' => $this->bundleStructure,
        ]);
    }

    /**
     * @param $requestUri
     * @param array $postData
     * @return array
     * @throws \Exception
     */
    private function sendPost($requestUri, array $postData)
    {
        if (!$this->apiToken || !$this->projectId) {
            throw new \Exception("Lokalise API not configured. Missing required parameters.");
        }
        $channel = curl_init($this->baseUrl . $requestUri);
        $encodedData = '';

        $postData['api_token'] = $this->apiToken;
        $postData['id'] = $this->projectId;
        foreach($postData as $name => $value) {
            $encodedData .= urlencode($name).'='.urlencode($value).'&';
        }

        $encodedData = substr($encodedData, 0, strlen($encodedData)-1);
        curl_setopt($channel, CURLOPT_POSTFIELDS,  $encodedData);
        curl_setopt($channel, CURLOPT_HEADER, 0);
        curl_setopt($channel, CURLOPT_POST, 1);
        curl_setopt($channel, CURLOPT_RETURNTRANSFER, 1);
        $contents = curl_exec($channel);
        curl_close($channel);
        
        return json_decode($contents, true);
    }
}
