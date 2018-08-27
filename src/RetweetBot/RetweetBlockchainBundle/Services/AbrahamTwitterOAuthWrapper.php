<?php


namespace RetweetBot\RetweetBlockchainBundle\Services;


use Abraham\TwitterOAuth\TwitterOAuth;

class AbrahamTwitterOAuthWrapper {

  /**
   * @var TwitterOAuth
   * Abraham TwitterOAuth Service holder variable
   */
  private $twitterOAuth;

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

  /**
   * Verifies the the token and secret credentials for the user
   *
   * @return object
   */
  public function verifyDetails(): object {
    return $this->twitterOAuth->get("account/verify_credentials");
  }

  /**
   * Gets most recent 50 Tweets for #blockchain in language english
   *
   * @return array
   */
  public function getTweetsForBlockchainTag(): array {
    $tweets = $this->twitterOAuth->get("search/tweets",
        [
            "q"    => "#blockchain",
            "lang" => "en",
            "count" => 50
        ]);

    return $tweets->statuses;
  }

  /**
   * Posts a retweet with the given id
   *
   * @param int $id
   * Id of the tweet to be retweeted
   */
  public function retweet(int $id) {
    $this->twitterOAuth->post("statuses/retweet", ["id" => $id]);
  }
}