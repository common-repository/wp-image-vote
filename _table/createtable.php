<?php
/**
 * テーブル作成
 *
 * @copyright   
 * @link        
 * @package     WP Image Vote
 * @version     
 */
global $wpdb;

//----------------------------------------------------------------
//デフォルトキャラセットの取得
//----------------------------------------------------------------
if (!empty($wpdb->charset)) {
    $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
}

//----------------------------------------------------------------
//ランキング管理用
//----------------------------------------------------------------
$table_name = $wpdb->prefix . 'iv_data';
$wp_iv_tbls[$table_name] = $table_name;
$wp_iv_sqls[$table_name] = "CREATE TABLE {$table_name} (
    id                  bigint(20)  NOT NULL AUTO_INCREMENT PRIMARY KEY,
    contents_id         bigint(20)  NOT NULL,
    image_id            bigint(20)  NOT NULL,
    ip_address          text        NOT NULL,
    yymmdd              varchar(8)  NOT NULL,
    yyww                varchar(6)  NOT NULL,
    yymm                varchar(6)  NOT NULL,
    yyyy                varchar(4)  NOT NULL,
    question_id_1       bigint(20)  NULL,
    question_vl_1       text        NULL,
    question_id_2       bigint(20)  NULL,
    question_vl_2       text        NULL,
    question_id_3       bigint(20)  NULL,
    question_vl_3       text        NULL,
    question_id_4       bigint(20)  NULL,
    question_vl_4       text        NULL,
    question_id_5       bigint(20)  NULL,
    question_vl_5       text        NULL,
    question_id_6       bigint(20)  NULL,
    question_vl_6       text        NULL,
    question_id_7       bigint(20)  NULL,
    question_vl_7       text        NULL,
    question_id_8       bigint(20)  NULL,
    question_vl_8       text        NULL,
    question_id_9       bigint(20)  NULL,
    question_vl_9       text        NULL,
    question_id_10      bigint(20)  NULL,
    question_vl_10      text        NULL,
    question_id_11      bigint(20)  NULL,
    question_vl_11      text        NULL,
    question_id_12      bigint(20)  NULL,
    question_vl_12      text        NULL,
    question_id_13      bigint(20)  NULL,
    question_vl_13      text        NULL,
    question_id_14      bigint(20)  NULL,
    question_vl_14      text        NULL,
    question_id_15      bigint(20)  NULL,
    question_vl_15      text        NULL,
    question_id_16      bigint(20)  NULL,
    question_vl_16      text        NULL,
    question_id_17      bigint(20)  NULL,
    question_vl_17      text        NULL,
    question_id_18      bigint(20)  NULL,
    question_vl_18      text        NULL,
    question_id_19      bigint(20)  NULL,
    question_vl_19      text        NULL,
    question_id_20      bigint(20)  NULL,
    question_vl_20      text        NULL,
    regist_date         datetime    NULL,
    UNIQUE KEY ukey_{$wpdb->prefix}iv_data (id)
    ) {$charset_collate};";
