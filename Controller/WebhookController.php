<?php

namespace Alicorn\LokaliseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WebhookController extends Controller
{
    /**
     * @Route("")
     * @Method("POST")
     */
    public function indexAction(Request $request)
    {
        $lokaliseHost = $this->container->getParameter('alicorn_lokalise.host');
        $webPath = $this->container->getParameter('alicorn_lokalise.web_path');
        $symfonyPath = $this->container->getParameter('alicorn_lokalise.symfony_path');
        $extractFilePath = $this->container->getParameter('alicorn_lokalise.extract_file');
        $rootDir = $this->container->getParameter('kernel.root_dir');
        $fileName = $request->request->get('file');
        $url = $lokaliseHost . $fileName;

        $zip = new \ZipArchive();

        $ch = curl_init();
        $fp = fopen($extractFilePath, "w");

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_exec($ch);

        curl_close($ch);
        fclose($fp);

        if ($zip->open($extractFilePath)) {
            if ($webPath) {
                $zip->extractTo($rootDir . '/../' . $webPath);
            }
            if ($symfonyPath) {
                $zip->extractTo($rootDir . '/../' . $symfonyPath);
            }
            $zip->close();

            return new Response("OK");
        }

        return new Response("Could not download remote file.");
    }
}
