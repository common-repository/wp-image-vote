<?php
/**
 * Image Vote Admin Option Class
 *
 * @copyright   
 * @link        
 * @package     WP Image Vote
 * @version     
 */
class ImageVoteAdminOption extends ImageVoteAdmin {

    /**
     * Base Controller
     *
     */
    function execute() {

        //----------------------------------------------------------------
        //処理の振分け
        //----------------------------------------------------------------
        switch ($this->request->getParam('iv_action')) {
            //----------------------------------------------------------------
            //
            //----------------------------------------------------------------
            default:
                $this->model = ImageVoteModel::getOptions();
                $this->exec('admin/option');
                break;
        }
    }
}
