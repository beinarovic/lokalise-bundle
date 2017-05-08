<?php
namespace Alicorn\LokaliseBundle\Service;

class Downloader
{
    private $lokaliseHost;
    private $webPath;
    private $symfonyPath;
    private $extractFilePath;
    private $rootDir;

    public function __construct($lokaliseHostl, $webPath, $symfonyPath, $extractFilePath, $rootDir)
    {
        $this->lokaliseHost = $lokaliseHostl;
        $this->webPath = $webPath;
        $this->symfonyPath = $symfonyPath;
        $this->extractFilePath = $extractFilePath;
        $this->rootDir = $rootDir;
    }

    /**
     * @param string $filename
     * @return bool
     */
    public function extract($filename)
    {
        $url = $this->lokaliseHost . $filename;

        $zip = new \ZipArchive();

        $ch = curl_init();
        $fp = fopen($this->extractFilePath, "w");

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_exec($ch);

        curl_close($ch);
        fclose($fp);

        if ($zip->open($this->extractFilePath)) {
            if ($this->webPath) {
                $zip->extractTo($this->rootDir . '/../' . $this->webPath);
            }
            if ($this->symfonyPath) {
                $zip->extractTo($this->rootDir . '/../' . $this->symfonyPath);
            }
            $zip->close();

            return true;
        }

        return false;
    }
}
