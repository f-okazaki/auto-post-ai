<?php
if (!defined('ABSPATH')) {
    exit;
}

use Abraham\TwitterOAuth\TwitterOAuth;

function auto_post_gpt_tweet($post_id) {
    $twitter_key = get_option('auto_post_gpt_twitter_key', '');
    $twitter_secret = get_option('auto_post_gpt_twitter_secret', '');
    $access_token = get_option('auto_post_gpt_access_token', '');
    $access_secret = get_option('auto_post_gpt_access_secret', '');

    if (!$twitter_key || !$twitter_secret || !$access_token || !$access_secret) {
        error_log('Twitter APIキーが設定されていません。');
        return;
    }

    $post = get_post($post_id);
    if (!$post || $post->post_status !== 'publish') return;

    $tweet_text = $post->post_title . ' ' . get_permalink($post_id);

    $connection = new TwitterOAuth(
        $twitter_key,
        $twitter_secret,
        $access_token,
        $access_secret
    );

    $tweet_data = ['text' => $tweet_text];
    $tweet_result = $connection->post('tweets', $tweet_data);

    if ($connection->getLastHttpCode() === 201) {
        error_log('Tweet successful: ' . $tweet_text);
    } else {
        error_log('Twitter API Error: ' . print_r($tweet_result, true));
    }
}
add_action('publish_post', 'auto_post_gpt_tweet');
