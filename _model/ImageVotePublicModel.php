<?php
/**
 * Image Vote Public Model Class
 *
 * @copyright   
 * @link        
 * @package     WP Image Vote
 * @version     
 */

class ImageVotePublicModel {

    /**
     * ������ID���X�g�擾
     */
    function getManageIdList() {
        //�I�v�V�����擾
        $options = ImageVoteModel::getOptions();
        //�R���e���c�擾
        $contents_list = $options['contents'];
        $manage_list = array();
        foreach ($contents_list as $contents) {
            foreach ($contents['details'] as $detail) {
                $manage_list[$detail['manage_id']] = $detail['manage_id'];
            }
        }
        return $manage_list;
    }

    /**
     * �^�O�o�͗p�R���e���c�ꗗ�擾
     */
    function getContents($manage_id) {
        //�I�v�V�����擾
        $options = ImageVoteModel::getOptions();
        $public_contents = array();
        foreach ($options['contents'] as $contents) {
            foreach ($contents['details'] as $detail) {
                if ($detail['manage_id'] == $manage_id) {
                    $public_contents = $detail;
                    $public_contents['contents_id']       = $contents['contents_id'];
                    $public_contents['iv_contents_title'] = $contents['iv_contents_title'];
                    $public_contents['iv_contents_type']  = $contents['iv_contents_type'];
                    $public_contents['questions']         = $contents['questions'];
                    break;
                }
            }
        }
        return $public_contents;
    }

    /**
     * �P�����[
     */
    function saveNormalVote() {
        global $wpdb;

        //�e�[�u�����擾
        $iv_data_table = $wpdb->prefix . 'iv_data';

        //���ݎ����擾
        $tm = time();

        //�e�[�u���ۑ�
        $wpdb->insert(
            $iv_data_table,
            array(
            'contents_id' => $_POST['contents_id'],
            'image_id'    => $_POST['image_id'],
            'ip_address'  => $_SERVER['REMOTE_ADDR'],
            'yymmdd'      => date('Ymd', $tm),
            'yyww'        => date('YW', $tm),
            'yymm'        => date('Ym', $tm),
            'yyyy'        => date('Y', $tm),
            'regist_date' => date('YmdHis', $tm)
            )
        );
        return 'true';
    }

    /**
     * �A���P�[�g���[
     */
    function saveQuestionVote($questions) {

        //�A���P�[�g���`
        $params = array();
        $i = 1;
        foreach ($questions as $key=>$val) {
            $params["question_id_{$i}"] = $key;
            if (count($val) > 1) {
                $params["question_vl_{$i}"] = json_encode($val);
            }
            else {
                $params["question_vl_{$i}"] = $val[0];
            }
            $i++;
        }
        //iv_trace_log(var_export($params, true));

        global $wpdb;

        //�e�[�u�����擾
        $iv_data_table = $wpdb->prefix . 'iv_data';

        //���ݎ����擾
        $tm = time();

        //�e�[�u���ۑ�
        $wpdb->insert(
            $iv_data_table,
            array_merge(
                array(
                'contents_id' => $_POST['contents_id'],
                'image_id'    => $_POST['image_id'],
                'ip_address'  => $_SERVER['REMOTE_ADDR'],
                'yymmdd'      => date('Ymd', $tm),
                'yyww'        => date('YW', $tm),
                'yymm'        => date('Ym', $tm),
                'yyyy'        => date('Y', $tm),
                'regist_date' => date('YmdHis', $tm)
                ),
                $params
            )
        );
        return 'true';
    }
}
