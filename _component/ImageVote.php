<?php
/**
 * Image Vote Class
 *
 * @copyright   
 * @link        
 * @package     WP Image Vote
 * @version     
 */
class ImageVote {
    var $view;              //view管理用変数
    var $request;           //request管理用変数
    var $hidden_vars;       //hidden管理用変数
    var $model;             //model管理用変数
    var $template;

    /**
     * コンストラクタ
     *
     */
    function ImageVote() {
        if (version_compare($wp_version, '2.6', '<')) {// Using old WordPress
            load_plugin_textdomain('image-vote', 'wp-content/plugins/' . IV_PLUGIN_NAME . '/languages');
        }
        else {
            load_plugin_textdomain('image-vote', 'wp-content/plugins/' . IV_PLUGIN_NAME . '/languages', IV_PLUGIN_NAME . '/languages');
        }
        $this->request = new ImageVoteRequestVo();
    }

    /**
     * 画面描画メソッド実行
     *
     */
    function exec($template) {
        $this->template = $template;

        $this->header_contents();
        $this->header();
        $this->title();
        $this->load_template();
        $this->footer();
        $this->footer_contents();
    }

    /**
     * テンプレートファイルのローディング
     *
     */
    function load_template() {
        $file = WP_PLUGIN_DIR . '/' . IV_PLUGIN_NAME . '/template/' . $this->template . '.php';
        if (file_exists($file)) {
            ob_start();
            include($file);
            $contents = ob_get_contents();
            ob_end_clean();
        }
        echo $contents;
    }

    /**
     * ヘッダーHTML出力
     * abstract扱い
     *
     */
    function header() {
    }

    /**
     * フッターHTML出力
     * abstract扱い
     *
     */
    function footer() {
    }

    /**
     * タイトルHTML出力
     * abstract扱い
     *
     */
    function title() {
    }

    /**
     * コンテンツエリア開始HTML出力
     *
     */
    function header_contents() {
        echo "<div class='iv_contents'>";
    }

    /**
     * コンテンツエリア終了HTML出力
     *
     */
    function footer_contents() {
        echo "</div>";
    }

    /**
     * Hiddenタグの一括出力
     *
     */
    function hvars() {
        ImageVoteFunctions::EchoHTMLHiddens ($this->hidden_vars);
    }

    /**
     * Inputタグ出力
     *
     */
    function input($params) {
        return ImageVoteFunctions::HTMLInput($params);
    }

    /**
     * Textareaタグ出力
     *
     */
    function text($params) {
        return ImageVoteFunctions::HTMLText($params);
    }

    /**
     * Selectタグ出力
     *
     */
    function select($id, $params) {
        return ImageVoteFunctions::HTMLSelect($id, $params);
    }

    /**
     * Linkタグ出力
     *
     */
    function link($params) {
        return ImageVoteFunctions::HTMLLink($params);
    }

    /**
     * Submitタグ出力
     *
     */
    function submit($params) {
        return ImageVoteFunctions::HTMLSubmit($params);
    }

    /**
     * Ymdタグ出力
     *
     */
    function ymd($params) {
        return ImageVoteFunctions::HTMLYyyymmdd($params);
    }

    /**
     * Pageタグ出力
     *
     */
    function page($params) {
        return ImageVoteFunctions::HTMLPage($params);
    }

    /**
     * Output Error Message
     *
     */
    function error($param) {
        echo ImageVoteFunctions::HTMLError($param);
    }
}
