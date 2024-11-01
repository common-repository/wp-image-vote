<?php
/**
 * Image Vote Admin Class
 *
 * @copyright   
 * @link        
 * @package     WP Image Vote
 * @version     
 */
class ImageVoteAdmin extends ImageVote {

    /**
     * 有効化時の処理
     *
     */
    function initialize() {
        ImageVoteModel::initialyze();
    }

    /**
     * 無効化時の処理
     *
     */
    function destroy() {
        ImageVoteModel::destroy();
    }

    /**
     * 管理者用メニュー生成
     *
     */
    function addAdminMenu() {
        ImageVoteFunctions::attachMenus();
    }

    /**
     * Output Admin HTML Header
     *
     * @access private
     */
    function header() {
        ?>
        <div class='wrap'>
        <h2><?php _e(IVLNG_ADMIN, IV_DOMAIN); ?></h2>
        <?php
    }

    /**
     * Output Admin HTML Footer
     *
     * @access private
     */
    function footer() {
        ?>
        </div>
        <?php
    }
}
