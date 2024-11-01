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

$results = ImageVotePublicModel::saveNormalVote();
echo json_encode($results);
