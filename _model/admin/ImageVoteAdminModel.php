<?php
/**
 * Image Vote Admin Model Class
 *
 * @copyright   
 * @link        
 * @package     WP Image Vote
 * @version     
 */

class ImageVoteAdminModel {

    /**
     * コンテンツ一覧取得
     */
    function getContentsList() {
        $options = ImageVoteModel::getOptions();
        return $options['contents'];
    }

    /**
     * コンテンツ取得
     */
    function getContents($contents_id) {
        $options = ImageVoteModel::getOptions();
        return $options['contents'][$contents_id];
    }

    /**
     * コンテンツ詳細取得
     */
    function getContentsDetail($contents_id, $image_id) {
        $options = ImageVoteModel::getOptions();
        return $options['contents'][$contents_id]['details'][$image_id];
    }

    /**
     * 質問取得
     */
    function getContentsQuestion($contents_id, $question_id) {
        $options = ImageVoteModel::getOptions();
        return $options['contents'][$contents_id]['questions'][$question_id];
    }

    /**
     * コンテンツ登録
     */
    function saveContents($params = array()) {
        $options = ImageVoteModel::getOptions();
        if (!isset($params['contents_id'])) {
            //コンテンツIDを採番する
            $contents_id = ImageVoteFunctions::Rand8();
            //コンテンツ新規追加
            $i = count($options['contents']) + 1;
            $params['contents_id'] = $contents_id;
            $params['iv_contents_title']  = "test_{$i}";
            $params['iv_contents_type']   = '1';
            $params['contents_regist_dt'] = date('Ymd', time());
        }
        //コンテンツを保存する
        $options['contents'][$params['contents_id']] = $params;
        ImageVoteModel::saveOptions($options);
        return $params;
    }

    /**
     * コンテンツ削除
     */
    function deleteContents($contents_id) {
        $contents = ImageVoteAdminModel::getContents($contents_id);
        //詳細情報を削除する
        if (is_array($contents['details'])) {
            foreach ($contents['details'] as $image_id=>$detail) {
                ImageVoteAdminModel::deleteContentsDetail($contents_id, $image_id);
            }
        }
        $options = ImageVoteModel::getOptions();
        unset($options['contents'][$contents_id]);
        ImageVoteModel::saveOptions($options);
    }

    /**
     * コンテンツ詳細更新
     */
    function saveContentsDetail($contents_id, $params = array()) {
        if (!isset($params['image_id'])) {
            //画像IDを採番する
            $image_id = ImageVoteFunctions::Rand8();
            //画像新規追加
            $params['image_id']  = $image_id;
            $params['manage_id'] = '__IV_ID_' . $image_id;
        }
        else {
            $params['image_iv_name'] = "iv_{$params['image_id']}_{$params['image_name']}";
            $iv_dir = get_template_directory() . '/iv_files';
            if (!is_dir($iv_dir)) {
                @mkdir($iv_dir);
            }
            move_uploaded_file($params['image_tmp'], $iv_dir . '/' . $params['image_iv_name']);
        }
        //コンテンツを保存する
        $options = ImageVoteModel::getOptions();
        $options['contents'][$contents_id]['details'][$params['image_id']] = $params;
        ImageVoteModel::saveOptions($options);
        return $params;
    }

    /**
     * コンテンツ詳細削除
     */
    function deleteContentsDetail($contents_id, $image_id) {
        $options = ImageVoteModel::getOptions();
        //コンテンツを削除
        $contents_detail = $options['contents'][$contents_id]['details'][$image_id];
        $iv_file = get_template_directory() . '/iv_files/' . $contents_detail['image_iv_name'];
        @unlink($iv_file);
        unset($options['contents'][$contents_id]['details'][$image_id]);
        //コンテンツを保存する
        ImageVoteModel::saveOptions($options);
    }

    /**
     * 質問詳細更新
     */
    function saveContentsQuestion($contents_id, $params = array()) {
        if (!isset($params['question_id'])) {
            //質問IDを採番する
            $question_id = ImageVoteFunctions::Rand8();
            //質問新規追加
            $params['question_id'] = $question_id;
        }
        //質問を保存する
        $options = ImageVoteModel::getOptions();
        $options['contents'][$contents_id]['questions'][$params['question_id']] = $params;
        ImageVoteModel::saveOptions($options);
        return $params;
    }

    /**
     * 質問削除
     */
    function deleteContentsQuestion($contents_id, $question_id) {
        $options = ImageVoteModel::getOptions();
        //質問を削除
        $contents_question = $options['contents'][$contents_id]['questions'][$question_id];
        unset($options['contents'][$contents_id]['questions'][$question_id]);
        //質問を保存する
        ImageVoteModel::saveOptions($options);
    }

    /**
     * 投票結果用　検索条件の取得
     */
    function getResultsSearch() {
        $options = ImageVoteModel::getOptions();

        $params = array();

        //企画一覧
        $param['contents']['title'] = __v(IVLNG_ADMIN_RESULTS_CONTENTS);
        foreach ($options['contents'] as $contents) {
            $param['contents']['data'][$contents['contents_id']] = $contents['iv_contents_title'];
        }

        //ランキング（画像単位／生データ（最大100件））
        $param['ranking_kb']['title'] = __v(IVLNG_ADMIN_RESULTS_RANKING);
        $param['ranking_kb']['data']  = array(
            '1' => __v(IVLNG_OUTPUT_KB_IMAGE_ID),
            '2' => __v(IVLNG_OUTPUT_KB_NOTHING),
        );

        //名寄せ方法（IPアドレス）
        $param['collect_kb']['title'] = __v(IVLNG_ADMIN_RESULTS_COLLECT);
        $param['collect_kb']['data']  = array(
            '1' => __v(IVLNG_COLLECT_KB_IP),
            '2' => __v(IVLNG_COLLECT_KB_NOTHING)
        );

        //出力区分（生データは全件）
        $param['output_kb']['title'] = __v(IVLNG_ADMIN_RESULTS_OUTPUT);
        $param['output_kb']['data']  = array(
            '1' => __v(IVLNG_CSV_KB_DISPLAY),
            '2' => __v(IVLNG_CSV_KB_FILE)
        );

        //期間種別
/*
        $param['kikan_syubetu']['title'] = __v(IVLNG_ADMIN_RESULTS_KIKAN_SYUBETU);
        $param['kikan_syubetu']['data']  = array(
            '0' => __v(IVLNG_KIKAN_KB_0),
            '1' => __v(IVLNG_KIKAN_KB_1),
            '2' => __v(IVLNG_KIKAN_KB_2),
            '3' => __v(IVLNG_KIKAN_KB_3),
            '4' => __v(IVLNG_KIKAN_KB_4)
        );
*/

        //昇順／降順
/*
        $param['order']['title'] = __v(IVLNG_ADMIN_RESULTS_ORDER);
        $param['order']['data']  = array(
            '1' => __v(IVLNG_ORDER_ASC),
            '2' => __v(IVLNG_ORDER_DESC)
        );
*/
        return $param;
    }

    /**
     * 投票結果用　投票結果の取得
     */
    function getResults($criteria) {
        global $wpdb;

        //テーブル名取得
        $iv_data_table = $wpdb->prefix . 'iv_data';

        $columns_kikan = null;
        $columns_list  = null;
        $criteria_list = array();

        //企画設定
        $criteria_list[] = "a.contents_id = {$criteria['contents']}";

        //期間設定
        if (!is_null($criteria['from']) && $criteria['from'] != '') {
            $from = $criteria['from'];
            $from = str_replace(' ', '', $from);
            $from = str_replace('/', '', $from);
            $from = str_replace(':', '', $from);
            $criteria_list[] = "a.yymmdd >= {$from}";
        }
        if (!is_null($criteria['to']) && $criteria['to'] != '') {
            $to = $criteria['to'];
            $to = str_replace(' ', '', $to);
            $to = str_replace('/', '', $to);
            $to = str_replace(':', '', $to);
            $criteria_list[] = "a.yymmdd <= {$to}";
        }

        //データ取得期間の設定
        if ($criteria['ranking_kb'] == 1) {
            if ($criteria['kikan_syubetu'] == 0) {
                $columns_kikan  = "";
            }
            else if ($criteria['kikan_syubetu'] == 1) {
                $columns_kikan  = "a.yymmdd,";
            }
            else if ($criteria['kikan_syubetu'] == 2) {
                $columns_kikan  = "a.yyww,";
            }
            else if ($criteria['kikan_syubetu'] == 3) {
                $columns_kikan  = "a.yymm,";
            }
            else if ($criteria['kikan_syubetu'] == 4) {
                $columns_kikan  = "a.yyyy,";
            }
        }
        else {
            $columns_kikan  = "";
        }
        //収集単位
        if ($criteria['ranking_kb'] == 1) {
            $columns_list  = "{$columns_kikan} a.contents_id, a.image_id";
        }

        //名寄せ方法
        $sub_query = null;
        $criteria_str = @implode(' and ', $criteria_list);
        if ($criteria['ranking_kb'] == 1
         && $criteria['collect_kb'] == 1) {
            $sub_query = "select {$columns_list}, count(*) as cnt, a.ip_address from {$iv_data_table} as a where {$criteria_str} group by {$columns_list}, a.ip_address ";
            $query = "
                select a.*
                from (
                    select 
                        {$columns_list}, count(*) as cnt
                    from ({$sub_query}) as a
                    group by 
                        {$columns_list}
                    order by 
                        a.cnt desc
                ) as a
                order by 
                    a.cnt desc
            ";
        }
        else if ($criteria['ranking_kb'] == 1
              && $criteria['collect_kb'] == 2) {
            $sub_query = "select {$columns_list}, count(*) as cnt, a.regist_date from {$iv_data_table} as a where {$criteria_str} group by {$columns_list}, a.regist_date ";
            $query = "
                select a.*
                from (
                    select 
                        {$columns_list}, count(*) as cnt
                    from ({$sub_query}) as a
                    group by 
                        {$columns_list}
                ) as a
                order by 
                    a.cnt desc
            ";
        }
        else {
            $query = "select a.* from {$iv_data_table} as a where {$criteria_str}";
        }
        $results['criteria'] = $criteria;
        $results['list'] = $wpdb->get_results($query, ARRAY_A);
        return $results;
    }
}
