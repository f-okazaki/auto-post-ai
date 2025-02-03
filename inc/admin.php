<?php
if (!defined('ABSPATH')) {
    exit;
}

// 管理メニューの追加
function auto_post_ai_admin_menu() {
    add_menu_page(
        'Auto Post GPT-4',
        'Auto Post GPT-4',
        'manage_options',
        'auto-post-gpt-4',
        'auto_post_ai_admin_page',
        'dashicons-admin-site-alt3',
        25
    );
}
add_action('admin_menu', 'auto_post_ai_admin_menu');

// 設定ページ
function auto_post_ai_admin_page() {
    ?>
    <div class="wrap">
        <h1>Auto Post AI 管理</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('auto_post_ai_options');
            do_settings_sections('auto-post-gpt-4');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
