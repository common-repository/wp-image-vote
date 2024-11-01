<?php
/**
 * Image Vote Admin Results Class
 *
 * @copyright   
 * @link        
 * @package     WP Image Vote
 * @version     
 */
class ImageVoteAdminResults extends ImageVoteAdmin {

    /**
     * Base Controller
     *
     */
    function execute() {
        //画面制御用（hidden）
        $this->hidden_vars['iv_action']   = '';

        //----------------------------------------------------------------
        //処理の振分け
        //----------------------------------------------------------------
        switch ($this->request->getParam('iv_action')) {
            //----------------------------------------------------------------
            //検索
            //----------------------------------------------------------------
            case 'search':
                //検索条件を取得する
                $criteria = array();
                $criteria['contents']      = $this->request->getParam("iv_search_contents");
                $criteria['order']         = $this->request->getParam("iv_search_order");
                $criteria['ranking_kb']    = $this->request->getParam("iv_search_ranking_kb");
                $criteria['collect_kb']    = $this->request->getParam("iv_search_collect_kb");
                $criteria['output_kb']     = $this->request->getParam("iv_search_output_kb");
                $criteria['kikan_syubetu'] = $this->request->getParam("iv_search_kikan_syubetu");
                $criteria['from']          = $this->request->getParam("iv_search_f_ymd");
                $criteria['to']            = $this->request->getParam("iv_search_t_ymd");
                //モデルの設定をする
                $this->model['search']   = ImageVoteAdminModel::getResultsSearch();
                $this->model['result']   = ImageVoteAdminModel::getResults($criteria);
                $this->model['contents'] = ImageVoteAdminModel::getContents($criteria['contents']);
                //template描画
                $this->exec('admin/results');
                break;
            //----------------------------------------------------------------
            //
            //----------------------------------------------------------------
            default:
                //モデルの設定をする
                $this->model['search']  = ImageVoteAdminModel::getResultsSearch();
                //template描画
                $this->exec('admin/results');
                break;
        }
    }
}
