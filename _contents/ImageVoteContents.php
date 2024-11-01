<?php
/**
 * Image Vote Contents
 *
 * @copyright   
 * @link        
 * @package     WP Image Vote
 * @version     
 */
function imagevote_contents_controller($content = '') {
    //埋込みID一覧を取得
    $manage_id_list = ImageVotePublicModel::getManageIdList();

    //コンテンツで置換
    $question_list = array();
    foreach ($manage_id_list as $manage_id) {
        //埋込みIDの判定
        if (preg_match("/" . $manage_id . "/", $content)) {
            $contents = ImageVotePublicModel::getContents($manage_id);
            //質問タイプの一覧を生成
            if ($contents['iv_contents_type'] == '2') {
                $question_list[$contents['contents_id']] = $contents;
            }
            ob_start();
            imagevote_contents_writer($manage_id);
            $output = ob_get_contents();
            ob_end_clean();
            $content = preg_replace("/(<p>)*" . $manage_id . "(<\/p>)*/", $output, $content);
        }
    }
    ob_start();
    imagevote_question_writer($question_list);
    $output = ob_get_contents();
    ob_end_clean();
    $content = $output . $content;
    //置換済みコンテンツを返す
    return $content;
}

/**
 * コンテンツの書出し
 */
function imagevote_contents_writer($manage_id) {
    require_once(PLUGIN_IMAGE_VOTE . '/_controller/ImageVotePublic.php');
    $iv_controller = & new ImageVotePublic();
    $iv_controller->execute($manage_id);
}

/**
 * 質問コンテンツの書出し
 */
function imagevote_question_writer($question_list) {
    require_once(PLUGIN_IMAGE_VOTE . '/_controller/ImageVotePublic.php');
    $iv_controller = & new ImageVotePublic();
    $iv_controller->execute_question($question_list);
}
