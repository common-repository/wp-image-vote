<?php
/**
 * Image Vote Ajax Process
 *
 * @copyright   
 * @link        
 * @package     WP Image Vote
 * @version     
 */
require_once('../../../../wp-config.php');

require_once(PLUGIN_IMAGE_VOTE . '/_controller/ImageVotePublic.php');
require_once(PLUGIN_IMAGE_VOTE . '/_component/functions.php');
require_once(PLUGIN_IMAGE_VOTE . '/_component/logger.php');

//iv_trace_log(var_export($_POST, true));

//Ž¿–âƒf[ƒ^Žæ“¾
$json = $_POST['question_data'];

$json = str_replace("\\\\", '__@@ESCAPE@@__', $json);   //ˆê’U‘Þ”ð
$json = str_replace("\\", '', $json);                   //Á‹Ž
$json = str_replace("__@@ESCAPE@@__", "\\", $json);     //–ß‚·

$question_data = json_decode($json, true);
$tmp = array();
foreach ($question_data as $key=>$data) {
    $name  = str_replace('[]', '', $data['name']);
    $value = unicode_encode($data['value']);
    $tmp[$name][] = $value;
}
$params = array();
foreach ($tmp as $key=>$question) {
    if (substr($key, 0, 21) != 'iv_question_image_id_') {
        $key = str_replace('iv_question_', '', $key);
        $val = $question;
        $params[$key] = $val;
    }
}
//iv_trace_log(var_export($params, true));

$results = ImageVotePublicModel::saveQuestionVote($params);
echo json_encode($results);
