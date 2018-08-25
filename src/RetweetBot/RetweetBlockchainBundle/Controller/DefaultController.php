<?php

namespace RetweetBot\RetweetBlockchainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@RetweetBlockchain/Default/index.html.twig');
    }
}
