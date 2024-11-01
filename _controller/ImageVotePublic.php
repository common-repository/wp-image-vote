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
        //ƒ‚ƒfƒ‹‚ÌÝ’è‚ð‚·‚é
        $this->model = ImageVotePublicModel::getContents($manage_id);
        //template•`‰æ
        $this->exec('public_contents');
    }

    function execute_question($question_list) {
        //ƒ‚ƒfƒ‹‚ÌÝ’è‚ð‚·‚é
        $this->model = $question_list;
        //template•`‰æ
        $this->exec('public_question');
    }
}
