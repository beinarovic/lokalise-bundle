<?php

namespace Alicorn\LokaliseBundle\Controller;

use Alicorn\LokaliseBundle\Api\Downloader;
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
        $fileName = $request->request->get('file');

        /** @var Downloader $downloader */
        $downloader = $this->container->get('alicorn_lokalise.service.downloader');

        if ($downloader->extract($fileName)) {
            return new Response("OK");
        }

        return new Response("Could not download remote file.");
    }
}
