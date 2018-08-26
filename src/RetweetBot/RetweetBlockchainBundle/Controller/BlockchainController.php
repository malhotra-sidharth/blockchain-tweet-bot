<?php

namespace RetweetBot\RetweetBlockchainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlockchainController extends Controller
{

    /**
     * Fetches 100 tweets with hashtag #blockchain and finds top 10 tweets
     * that hasn't been retweeted. Makes sure that only one tweet from a user 
     * is retweeted in a day
     */
    public function fetchAndCalculateAction() {
        $consumer_secret = $this->getParameter('consumer_secret');
        $consumer_key = $this->getParameter('consumer_key');
        $access_token = $this->getParameter('access_token');
        $access_secret = $this->getParameter('access_secret');

    }
}
