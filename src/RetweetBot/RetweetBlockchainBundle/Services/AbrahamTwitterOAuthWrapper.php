<?php


namespace RetweetBot\RetweetBlockchainBundle\Services;


use Abraham\TwitterOAuth\TwitterOAuth;

class AbrahamTwitterOAuthWrapper {

  /**
   * @var TwitterOAuth
   * Abraham TwitterOAuth Service holder variable
   */
  public $twitterOAuth;

  /**
   * AbrahamTwitterOAuthWrapper constructor.
   * @param TwitterOAuth $twitterOAuth
   */
  public function __construct(TwitterOAuth $twitterOAuth) {
    $this->twitterOAuth = $twitterOAuth;
  }

  /**
   * Gets the connection for the Twitter API
   * 
   * @return TwitterOAuth
   */
  public function getConnection(): TwitterOAuth {
    return $this->twitterOAuth;
  }
}