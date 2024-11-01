<?php
/**
 * Image Vote Public Class
 *
 * @copyright   
 * @link        
 * @package     WP Image Vote
 * @version     
 */
class ImageVotePublic extends ImageVote {

    function header_contents() {
    }

    function footer_contents() {
    }

    function execute($manage_id) {
        //���f���̐ݒ������
        $this->model = ImageVotePublicModel::getContents($manage_id);
        //template�`��
        $this->exec('public_contents');
    }

    function execute_question($question_list) {
        //���f���̐ݒ������
        $this->model = $question_list;
        //template�`��
        $this->exec('public_question');
    }
}
