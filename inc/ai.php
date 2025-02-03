<?php
if (!defined('ABSPATH')) {
    exit;
}

// 記事生成処理
function auto_post_gpt_fetch_content() {
    $api_provider = get_option('auto_post_gpt_api_provider', 'openai');
    
    if ($api_provider === 'openai') {
        return auto_post_gpt_fetch_gpt4_content();
    } elseif ($api_provider === 'perplexity') {
        return auto_post_gpt_fetch_perplexity_content();
    }

    return '記事の生成に失敗しました。';
}

// OpenAI API (GPT-4) で記事を取得
function auto_post_gpt_fetch_gpt4_content() {
    $openai_key = get_option('auto_post_gpt_openai_key', '');
    $prompts = get_option('auto_post_gpt_prompts', array());
    $prompt = $prompts[array_rand($prompts)] ?? '今日の面白い話題についての記事を作成してください。';

    if (empty($openai_key)) {
        error_log('OpenAI APIキーが設定されていません。');
        return '';
    }

    $response = wp_remote_post('https://api.openai.com/v1/chat/completions', array(
        'timeout' => 30,
        'headers' => array(
            'Authorization' => 'Bearer ' . $openai_key,
            'Content-Type'  => 'application/json',
        ),
        'body' => json_encode(array(
            'model'    => 'gpt-4o',
            'messages' => array(
                array('role' => 'user', 'content' => $prompt)
            ),
            'temperature' => 1.0,
            'max_tokens' => 1000,
        )),
    ));

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    return $data['choices'][0]['message']['content'] ?? '';
}

// Perplexity API で記事を取得
function auto_post_gpt_fetch_perplexity_content() {
    $perplexity_key = get_option('auto_post_gpt_perplexity_key', '');
    $prompts = get_option('auto_post_gpt_prompts', array());
    $prompt = $prompts[array_rand($prompts)] ?? '今日の面白い話題についての記事を作成してください。';

    if (empty($perplexity_key)) {
        error_log('Perplexity APIキーが設定されていません。');
        return '';
    }

    $response = wp_remote_post('https://api.perplexity.ai/v1/completions', array(
        'timeout' => 30,
        'headers' => array(
            'Authorization' => 'Bearer ' . $perplexity_key,
            'Content-Type'  => 'application/json',
        ),
        'body' => json_encode(array(
            'model'    => 'perplexity-latest',
            'prompt'   => $prompt,
            'temperature' => 1.0,
            'max_tokens' => 1000,
        )),
    ));

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    return $data['choices'][0]['text'] ?? '';
}
