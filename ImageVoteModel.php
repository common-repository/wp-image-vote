<?php
/**
 * Image Vote Model Class
 *
 * @copyright   
 * @link        
 * @package     WP Image Vote
 * @version     
 */
class ImageVoteModel {

    /**
     * Initialyze
     */
    function initialyze() {
        require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
        //オプションの追加
        $params = array();
        add_option('wp_iv_options', $params);

        //Simple Cart用テーブルの作成
        ImageVoteModel::createTables();
    }

    /**
     * Destoroy Simple Cart
     */
    function destroy() {
        //Image Vote用オプションの削除
        //delete_option('wp_iv_options');
    }

    /**
     * Create Simple Cart Tables
     *
     */
    function createTables() {
        global $wpdb;
        include(PLUGIN_IMAGE_VOTE . '/_table/createtable.php');
        foreach ($wp_iv_tbls as $tbl_name) {
            if ($wpdb->get_var("show tables like '$tbl_name'") != $tbl_name) {
                dbDelta($wp_iv_sqls[$tbl_name]);
            }
        }
    }

    /**
     * Getting Setting Infomation
     */
    function getOptions() {
        $params = get_option('wp_iv_options');
        return $params;
    }

    /**
     * Save Setting Infomation
     */
    function saveOptions($params) {
        update_option('wp_iv_options', $params);
    }
}
