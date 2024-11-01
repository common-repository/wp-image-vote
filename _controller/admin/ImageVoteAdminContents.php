<?php
/**
 * Image Vote Admin Contents Class
 *
 * @copyright   
 * @link        
 * @package     WP Image Vote
 * @version     
 */
class ImageVoteAdminContents extends ImageVoteAdmin {

    /**
     * Base Controller
     */
    function execute() {
        //画面制御用（hidden）
        $this->hidden_vars['iv_action']   = '';
        $this->hidden_vars['contents_id'] = '';
        $this->hidden_vars['image_id']    = '';
        $this->hidden_vars['question_id'] = '';

        //----------------------------------------------------------------
        //処理の振分け
        //----------------------------------------------------------------
        switch ($this->request->getParam('iv_action')) {
            //----------------------------------------------------------------
            //コンテンツ追加
            //----------------------------------------------------------------
            case 'add':
                //コンテンツを保存する
                ImageVoteAdminModel::saveContents();
                //モデルの設定をする
                $this->model = ImageVoteAdminModel::getContentsList();
                //template描画
                $this->exec('admin/contents');
                break;
            //----------------------------------------------------------------
            //コンテンツ更新
            //----------------------------------------------------------------
            case 'update':
                //データ取得
                $contents_id = $this->request->getParam('contents_id');
                $contents = ImageVoteAdminModel::getContents($contents_id);
                $contents['iv_contents_title'] = $this->request->getParam("iv_contents_title_{$contents_id}");
                $contents['iv_contents_type']  = $this->request->getParam("iv_contents_type_{$contents_id}");
                //コンテンツを保存する
                $contents = ImageVoteAdminModel::saveContents($contents);
                //モデルの設定をする
                $this->model = ImageVoteAdminModel::getContentsList();
                //template描画
                $this->exec('admin/contents');
                break;
            //----------------------------------------------------------------
            //コンテンツ削除
            //----------------------------------------------------------------
            case 'delete':
                //データ取得
                $contents_id = $this->request->getParam('contents_id');
                //コンテンツを削除
                ImageVoteAdminModel::deleteContents($contents_id);
                //モデルの設定をする
                $this->model = ImageVoteAdminModel::getContentsList();
                //template描画
                $this->exec('admin/contents');
                break;
            //----------------------------------------------------------------
            //コンテンツ詳細登録画面へ
            //----------------------------------------------------------------
            case 'detail':
                //データ取得
                $contents_id = $this->request->getParam('contents_id');
                //モデルの設定をする
                $this->model = ImageVoteAdminModel::getContents($contents_id);
                $this->hidden_vars['contents_id'] = $contents_id;
                //template描画
                $this->exec('admin/contents_detail');
                break;
            //----------------------------------------------------------------
            //コンテンツ詳細追加
            //----------------------------------------------------------------
            case 'contents_add':
                //データ取得
                $contents_id = $this->request->getParam('contents_id');
                //詳細新規追加
                ImageVoteAdminModel::saveContentsDetail($contents_id);
                //モデルの設定をする
                $this->model = ImageVoteAdminModel::getContents($contents_id);
                $this->hidden_vars['contents_id'] = $contents_id;
                //template描画
                $this->exec('admin/contents_detail');
                break;
            //----------------------------------------------------------------
            //コンテンツ詳細更新
            //----------------------------------------------------------------
            case 'contents_update':
                //データ取得
                $contents_id = $this->request->getParam('contents_id');
                $image_id    = $this->request->getParam('image_id');
                $file_info   = $_FILES["iv_contents_file_{$image_id}"];
                //コンテンツ詳細の設定
                $contents_detail = ImageVoteAdminModel::getContentsDetail($contents_id, $image_id);
                $contents_detail['image_name'] = $file_info['name'];
                $contents_detail['image_type'] = $file_info['type'];
                $contents_detail['image_size'] = $file_info['size'];
                $contents_detail['image_tmp']  = $file_info['tmp_name'];
                //保存する
                ImageVoteAdminModel::saveContentsDetail($contents_id, $contents_detail);
                //モデルの設定をする
                $this->model = ImageVoteAdminModel::getContents($contents_id);
                $this->hidden_vars['contents_id'] = $contents_id;
                //template描画
                $this->exec('admin/contents_detail');
                break;
            //----------------------------------------------------------------
            //コンテンツ詳細削除
            //----------------------------------------------------------------
            case 'contents_delete':
                //データ取得
                $contents_id = $this->request->getParam('contents_id');
                $image_id    = $this->request->getParam('image_id');
                //コンテンツを削除
                ImageVoteAdminModel::deleteContentsDetail($contents_id, $image_id);
                //モデルの設定をする
                $this->model = ImageVoteAdminModel::getContents($contents_id);
                $this->hidden_vars['contents_id'] = $contents_id;
                //template描画
                $this->exec('admin/contents_detail');
                break;
            //----------------------------------------------------------------
            //アンケート登録画面へ
            //----------------------------------------------------------------
            case 'question':
                //データ取得
                $contents_id = $this->request->getParam('contents_id');
                //モデルの設定をする
                $this->model = ImageVoteAdminModel::getContents($contents_id);
                $this->hidden_vars['contents_id'] = $contents_id;
                //template描画
                $this->exec('admin/contents_question');
                break;
            //----------------------------------------------------------------
            //質問追加
            //----------------------------------------------------------------
            case 'question_add':
                //データ取得
                $contents_id = $this->request->getParam('contents_id');
                //質問新規追加
                ImageVoteAdminModel::saveContentsQuestion($contents_id);
                //モデルの設定をする
                $this->model = ImageVoteAdminModel::getContents($contents_id);
                $this->hidden_vars['contents_id'] = $contents_id;
                //template描画
                $this->exec('admin/contents_question');
                break;
            //----------------------------------------------------------------
            //質問更新
            //----------------------------------------------------------------
            case 'question_update':
                //データ取得
                $contents_id      = $this->request->getParam('contents_id');
                $question_id      = $this->request->getParam('question_id');
                $question_type    = $this->request->getParam("iv_question_type_{$question_id}");
                $question_label   = $this->request->getParam("iv_question_label_{$question_id}");
                $question_list    = $this->request->getParam("iv_question_list_{$question_id}");
                $question_require = $this->request->getParam("iv_question_require_{$question_id}");
                //コンテンツ詳細の設定
                $contents_question = ImageVoteAdminModel::getContentsQuestion($contents_id, $question_id);
                $contents_question['question_type']    = $question_type;
                $contents_question['question_label']   = $question_label;
                $contents_question['question_list']    = $question_list;
                $contents_question['question_require'] = $question_require;
                //保存する
                ImageVoteAdminModel::saveContentsQuestion($contents_id, $contents_question);
                //モデルの設定をする
                $this->model = ImageVoteAdminModel::getContents($contents_id);
                $this->hidden_vars['contents_id'] = $contents_id;
                //template描画
                $this->exec('admin/contents_question');
                break;
            //----------------------------------------------------------------
            //質問削除
            //----------------------------------------------------------------
            case 'question_delete':
                //データ取得
                $contents_id = $this->request->getParam('contents_id');
                $question_id = $this->request->getParam('question_id');
                //コンテンツを削除
                ImageVoteAdminModel::deleteContentsQuestion($contents_id, $question_id);
                //モデルの設定をする
                $this->model = ImageVoteAdminModel::getContents($contents_id);
                $this->hidden_vars['contents_id'] = $contents_id;
                //template描画
                $this->exec('admin/contents_question');
                break;
            //----------------------------------------------------------------
            //
            //----------------------------------------------------------------
            default:
                //モデルの設定をする
                $this->model = ImageVoteAdminModel::getContentsList();
                //template描画
                $this->exec('admin/contents');
                break;
        }
    }
}
