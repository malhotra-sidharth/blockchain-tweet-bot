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

    // Check if it has run in last 18 mins or not
    if (false === $cache->checkIfReady()) {
      return new JsonResponse(
          ["Hey!! You are doing it too fast!! Let's slow down a bit. I don't wanna spam."]);
    }

    // update the last run time
    $cache->updateTime();

    $tweets = $twitterOAuth->getTweetsForBlockchainTag();

    $retweets = [];

    // iterate through the tweets
    foreach ($tweets as $tweet) {
      // create tweet object
      $tweetObj = new Tweet($tweet);

      // check if the user's limit for today has been reached or not
      if (!$cache->hasItem($tweetObj->getUser()->getId())) {
        $retweets[] = $tweetObj->getId();
        $cache->putItem($tweetObj->getUser()->getId());
      }

      // don't exceed more the count of 10 retweets every interval
      if (10 == count($retweets)) {
        break;
      }
    }

    // if not then retweet else do nothing
    foreach ($retweets as $retweet) {
      $twitterOAuth->retweet($retweet);
    }

    return new JsonResponse(["Hey!, I am a Tweet Bot!! :)"]);
  }
}
