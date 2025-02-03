<?php
if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/gpt.php';

// 記事の自動生成処理
function auto_post_ai_generate_article() {
    $content = auto_post_ai_fetch_content(); // GPT-4 または Perplexity から記事を取得

    $post_data = array(
        'post_title'   => wp_trim_words($content, 10, '...'),
        'post_content' => $content,
        'post_status'  => 'publish',
        'post_author'  => 1,
    );

    $post_id = wp_insert_post($post_data);

    if (!is_wp_error($post_id)) {
        error_log("記事が投稿されました: ID {$post_id}");
        auto_post_ai_tweet($post_id);
    }
}
