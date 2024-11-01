<?php
/*
Plugin Name: WP Image Vote
Plugin URI: 
Description: WP Image Vote Plugin
Version: 0.1.0
Author: tshiro.
Author URI: 
*/

define('PLUGIN_IMAGE_VOTE', WP_PLUGIN_DIR . '/wp-image-vote');

if (get_locale()=='ja' || get_locale()=='en') {
    require_once(PLUGIN_IMAGE_VOTE . '/languages/language_' . get_locale() . '.php');
}
else {
    require_once(PLUGIN_IMAGE_VOTE . '/languages/language_ja.php');
}
require_once(PLUGIN_IMAGE_VOTE . '/ImageVoteDefine.php');
require_once(PLUGIN_IMAGE_VOTE . '/ImageVoteModel.php');
require_once(PLUGIN_IMAGE_VOTE . '/_component/ImageVote.php');
require_once(PLUGIN_IMAGE_VOTE . '/_component/ImageVoteFunctions.php');
require_once(PLUGIN_IMAGE_VOTE . '/_component/ImageVoteRequestVo.php');
require_once(PLUGIN_IMAGE_VOTE . '/_component/functions.php');
require_once(PLUGIN_IMAGE_VOTE . '/_component/logger.php');

add_action('wp_print_styles', array('ImageVoteFunctions', 'attachCss'));
add_action('wp_print_scripts', array('ImageVoteFunctions', 'attachCss'));
add_action('wp_print_scripts', array('ImageVoteFunctions', 'attachJs'));

//ダッシュボードまたは管理パネルが表示されている
if (is_admin()) {
    require_once(PLUGIN_IMAGE_VOTE . '/_controller/admin/ImageVoteAdmin.php');
    require_once(PLUGIN_IMAGE_VOTE . '/_model/admin/ImageVoteAdminModel.php');

    //CSV出力
    if ($_POST['iv_search_output_kb']==2) {
        //検索条件を取得する
        $criteria = array();
        $criteria['contents']      = $_POST["iv_search_contents"];
        $criteria['order']         = $_POST["iv_search_order"];
        $criteria['ranking_kb']    = $_POST["iv_search_ranking_kb"];
        $criteria['collect_kb']    = $_POST["iv_search_collect_kb"];
        $criteria['output_kb']     = $_POST["iv_search_output_kb"];
        $criteria['kikan_syubetu'] = $_POST["iv_search_kikan_syubetu"];
        $criteria['from']          = $_POST["iv_search_f_ymd"];
        $criteria['to']            = $_POST["iv_search_t_ymd"];
        $results = ImageVoteAdminModel::getResults($criteria);
        $contents = null;
        foreach ($results['list'] as $item) {
            $contents .= @implode(chr(9), $item) . chr(10);
        }
        header("Content-Disposition: attachment; filename=\"iv_ranking_" . date('Ymdhis') . ".csv\"");
        header('Content-Length: ' . strlen($contents));
        header('Content-Type: application/octet-stream');
        echo $contents;
        exit;
    }
    else {
        //クラスのインスタンス化
        $iv_admin = & new ImageVoteAdmin();

        //プラグインアクティベートhook
        register_activation_hook(__FILE__, array(&$iv_admin, 'initialize'));

        //プラグインディアクティベートhook
        register_deactivation_hook(__FILE__, array(&$iv_admin, 'destroy'));

        //hook
        add_action('admin_menu', array(&$iv_admin, 'addAdminMenu'));
    }
}
else {
    require_once(PLUGIN_IMAGE_VOTE . '/_contents/ImageVoteContents.php');
    require_once(PLUGIN_IMAGE_VOTE . '/_model/ImageVotePublicModel.php');

    //コンテンツ差替え
    add_filter('the_content', 'imagevote_contents_controller', 99);
}
