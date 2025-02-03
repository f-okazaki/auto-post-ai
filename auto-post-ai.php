<?php
/*
Plugin Name: Auto Post GPT-4
Description: GPT-4を使ってWordPressに記事を自動投稿し、X（Twitter）へ自動ツイートするプラグイン
Version: 1.0
Author: Futoshi Okazaki
*/

if (!defined('ABSPATH')) {
    exit;
}

// 必要なファイルを読み込む
require_once __DIR__ . '/inc/admin.php';
require_once __DIR__ . '/inc/settings.php';
require_once __DIR__ . '/inc/post-handler.php';
require_once __DIR__ . '/inc/twitter.php';
require_once __DIR__ . '/inc/ai.php';

// スタイルとスクリプトの読み込み
function auto_post_ai_enqueue_assets() {
    wp_enqueue_style('auto-post-ai-style', plugin_dir_url(__FILE__) . 'assets/style.css');
    wp_enqueue_script('auto-post-ai-script', plugin_dir_url(__FILE__) . 'assets/script.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'auto_post_ai_enqueue_assets');
