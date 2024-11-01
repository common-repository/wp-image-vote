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
     * �R���e���c�ꗗ�擾
     */
    function getContentsList() {
        $options = ImageVoteModel::getOptions();
        return $options['contents'];
    }

    /**
     * �R���e���c�擾
     */
    function getContents($contents_id) {
        $options = ImageVoteModel::getOptions();
        return $options['contents'][$contents_id];
    }

    /**
     * �R���e���c�ڍ׎擾
     */
    function getContentsDetail($contents_id, $image_id) {
        $options = ImageVoteModel::getOptions();
        return $options['contents'][$contents_id]['details'][$image_id];
    }

    /**
     * ����擾
     */
    function getContentsQuestion($contents_id, $question_id) {
        $options = ImageVoteModel::getOptions();
        return $options['contents'][$contents_id]['questions'][$question_id];
    }

    /**
     * �R���e���c�o�^
     */
    function saveContents($params = array()) {
        $options = ImageVoteModel::getOptions();
        if (!isset($params['contents_id'])) {
            //�R���e���cID���̔Ԃ���
            $contents_id = ImageVoteFunctions::Rand8();
            //�R���e���c�V�K�ǉ�
            $i = count($options['contents']) + 1;
            $params['contents_id'] = $contents_id;
            $params['iv_contents_title']  = "test_{$i}";
            $params['iv_contents_type']   = '1';
            $params['contents_regist_dt'] = date('Ymd', time());
        }
        //�R���e���c��ۑ�����
        $options['contents'][$params['contents_id']] = $params;
        ImageVoteModel::saveOptions($options);
        return $params;
    }

    /**
     * �R���e���c�폜
     */
    function deleteContents($contents_id) {
        $contents = ImageVoteAdminModel::getContents($contents_id);
        //�ڍ׏����폜����
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
     * �R���e���c�ڍ׍X�V
     */
    function saveContentsDetail($contents_id, $params = array()) {
        if (!isset($params['image_id'])) {
            //�摜ID���̔Ԃ���
            $image_id = ImageVoteFunctions::Rand8();
            //�摜�V�K�ǉ�
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
        //�R���e���c��ۑ�����
        $options = ImageVoteModel::getOptions();
        $options['contents'][$contents_id]['details'][$params['image_id']] = $params;
        ImageVoteModel::saveOptions($options);
        return $params;
    }

    /**
     * �R���e���c�ڍ׍폜
     */
    function deleteContentsDetail($contents_id, $image_id) {
        $options = ImageVoteModel::getOptions();
        //�R���e���c���폜
        $contents_detail = $options['contents'][$contents_id]['details'][$image_id];
        $iv_file = get_template_directory() . '/iv_files/' . $contents_detail['image_iv_name'];
        @unlink($iv_file);
        unset($options['contents'][$contents_id]['details'][$image_id]);
        //�R���e���c��ۑ�����
        ImageVoteModel::saveOptions($options);
    }

    /**
     * ����ڍ׍X�V
     */
    function saveContentsQuestion($contents_id, $params = array()) {
        if (!isset($params['question_id'])) {
            //����ID���̔Ԃ���
            $question_id = ImageVoteFunctions::Rand8();
            //����V�K�ǉ�
            $params['question_id'] = $question_id;
        }
        //�����ۑ�����
        $options = ImageVoteModel::getOptions();
        $options['contents'][$contents_id]['questions'][$params['question_id']] = $params;
        ImageVoteModel::saveOptions($options);
        return $params;
    }

    /**
     * ����폜
     */
    function deleteContentsQuestion($contents_id, $question_id) {
        $options = ImageVoteModel::getOptions();
        //������폜
        $contents_question = $options['contents'][$contents_id]['questions'][$question_id];
        unset($options['contents'][$contents_id]['questions'][$question_id]);
        //�����ۑ�����
        ImageVoteModel::saveOptions($options);
    }

    /**
     * ���[���ʗp�@���������̎擾
     */
    function getResultsSearch() {
        $options = ImageVoteModel::getOptions();

        $params = array();

        //���ꗗ
        $param['contents']['title'] = __v(IVLNG_ADMIN_RESULTS_CONTENTS);
        foreach ($options['contents'] as $contents) {
            $param['contents']['data'][$contents['contents_id']] = $contents['iv_contents_title'];
        }

        //�����L���O�i�摜�P�ʁ^���f�[�^�i�ő�100���j�j
        $param['ranking_kb']['title'] = __v(IVLNG_ADMIN_RESULTS_RANKING);
        $param['ranking_kb']['data']  = array(
            '1' => __v(IVLNG_OUTPUT_KB_IMAGE_ID),
            '2' => __v(IVLNG_OUTPUT_KB_NOTHING),
        );

        //���񂹕��@�iIP�A�h���X�j
        $param['collect_kb']['title'] = __v(IVLNG_ADMIN_RESULTS_COLLECT);
        $param['collect_kb']['data']  = array(
            '1' => __v(IVLNG_COLLECT_KB_IP),
            '2' => __v(IVLNG_COLLECT_KB_NOTHING)
        );

        //�o�͋敪�i���f�[�^�͑S���j
        $param['output_kb']['title'] = __v(IVLNG_ADMIN_RESULTS_OUTPUT);
        $param['output_kb']['data']  = array(
            '1' => __v(IVLNG_CSV_KB_DISPLAY),
            '2' => __v(IVLNG_CSV_KB_FILE)
        );

        //���Ԏ��
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

        //�����^�~��
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
     * ���[���ʗp�@���[���ʂ̎擾
     */
    function getResults($criteria) {
        global $wpdb;

        //�e�[�u�����擾
        $iv_data_table = $wpdb->prefix . 'iv_data';

        $columns_kikan = null;
        $columns_list  = null;
        $criteria_list = array();

        //���ݒ�
        $criteria_list[] = "a.contents_id = {$criteria['contents']}";

        //���Ԑݒ�
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

        //�f�[�^�擾���Ԃ̐ݒ�
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
        //���W�P��
        if ($criteria['ranking_kb'] == 1) {
            $columns_list  = "{$columns_kikan} a.contents_id, a.image_id";
        }

        //���񂹕��@
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
