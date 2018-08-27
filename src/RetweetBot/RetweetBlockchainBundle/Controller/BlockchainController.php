<?php

namespace RetweetBot\RetweetBlockchainBundle\Controller;

use RetweetBot\RetweetBlockchainBundle\Entities\Tweet;
use RetweetBot\RetweetBlockchainBundle\Services\AbrahamTwitterOAuthWrapper;
use RetweetBot\RetweetBlockchainBundle\Services\RedisWrapper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class BlockchainController extends Controller {

  /**
   * Fetches 100 tweets with hashtag #blockchain and finds top 10 tweets
   * that hasn't been retweeted. Makes sure that only one tweet from a user
   * is retweeted in a day
   */
  public function fetchAndCalculateAction() {
    /** @var AbrahamTwitterOAuthWrapper $twitterOAuth */
    $twitterOAuth = $this->container->get('fetch.tweets.abraham.twitteroauth');

    /** @var RedisWrapper $cache */
    $cache = $this->container->get('retweetbot.redis');

    $tweets = $twitterOAuth->getTweetsForBlockchainTag();

    $retweets = [];

    foreach ($tweets as $tweet) {
      // create tweet object
      $tweetObj = new Tweet($tweet);

      // check if the user's limit for today has been reached or not
      if (!$cache->hasItem($tweetObj->getUser()->getId())) {
        $retweets[] = $tweetObj->getId();
        $cache->putItem($tweetObj->getUser()->getId());
      }
    }

    // if not then retweet else do nothing
    foreach ($retweets as $retweet) {
      $twitterOAuth->retweet($retweet);
    }

    return new JsonResponse(["Hey!, I am a Tweet Bot!! :)"]);
  }
}
