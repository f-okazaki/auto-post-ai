<?php
if (!defined('ABSPATH')) {
    exit;
}

// 設定の登録
function auto_post_ai_register_settings() {
    register_setting('auto_post_ai_options', 'auto_post_ai_api_provider'); // どのAPIを使用するか
    register_setting('auto_post_ai_options', 'auto_post_ai_openai_key');   // OpenAI APIキー
    register_setting('auto_post_ai_options', 'auto_post_ai_perplexity_key'); // Perplexity APIキー
    register_setting('auto_post_ai_options', 'auto_post_ai_prompts', array('default' => array()));
}
add_action('admin_init', 'auto_post_ai_register_settings');

// APIプロバイダー選択フィールド
function auto_post_ai_api_provider_field() {
    $selected = get_option('auto_post_ai_api_provider', 'openai');
    ?>
    <select name="auto_post_ai_api_provider">
        <option value="openai" <?php selected($selected, 'openai'); ?>>GPT-4 (OpenAI)</option>
        <option value="perplexity" <?php selected($selected, 'perplexity'); ?>>Perplexity API</option>
    </select>
    <?php
}

// OpenAI APIキー
function auto_post_ai_openai_key_field() {
    echo "<input type='text' name='auto_post_ai_openai_key' value='" . esc_attr(get_option('auto_post_ai_openai_key', '')) . "' class='regular-text' />";
}

// Perplexity APIキー
function auto_post_ai_perplexity_key_field() {
    echo "<input type='text' name='auto_post_ai_perplexity_key' value='" . esc_attr(get_option('auto_post_ai_perplexity_key', '')) . "' class='regular-text' />";
}
