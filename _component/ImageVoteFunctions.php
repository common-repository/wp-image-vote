<?php
/**
 * Image Vote Functon Library
 *
 * @copyright   
 * @link        
 * @package     WP Image Vote
 * @version     
 */
class ImageVoteFunctions {

    /**
     * 管理者メニュー生成
     */
    function attachMenus() {
        $iv_ad_option_file   = 'ImageVoteAdminOption.php';
        $iv_ad_contents_file = 'ImageVoteAdminContents.php';
        $iv_ad_results_file  = 'ImageVoteAdminResults.php';

        require_once(PLUGIN_IMAGE_VOTE . '/_controller/admin/' . $iv_ad_option_file);
        require_once(PLUGIN_IMAGE_VOTE . '/_controller/admin/' . $iv_ad_contents_file);
        require_once(PLUGIN_IMAGE_VOTE . '/_controller/admin/' . $iv_ad_results_file);

        $iv_ad_option   = & new ImageVoteAdminOption();
        $iv_ad_contents = & new ImageVoteAdminContents();
        $iv_ad_results  = & new ImageVoteAdminResults();

        //add top menu
        add_menu_page(__(IVLNG_ADMIN_MENU_OPTION, IV_DOMAIN), __(IVLNG_ADMIN_MENU, IV_DOMAIN), 10, IV_PLUGIN_FILE, array(&$iv_ad_option, 'execute'), WP_PLUGIN_URL . '/' . IV_PLUGIN_NAME . '/images/vote.png');
        //add submenus
        add_submenu_page(IV_PLUGIN_FILE, __(IVLNG_ADMIN_MENU_CONTENTS, SC_DOMAIN), __(IVLNG_ADMIN_MENU_CONTENTS, SC_DOMAIN), 10, $iv_ad_contents_file, array(&$iv_ad_contents, 'execute'));
        add_submenu_page(IV_PLUGIN_FILE, __(IVLNG_ADMIN_MENU_RESULTS, SC_DOMAIN), __(IVLNG_ADMIN_MENU_RESULTS, SC_DOMAIN), 10, $iv_ad_results_file, array(&$iv_ad_results, 'execute'));
     }

    /**
     * CSS設定
     */
    function attachCss() {
        $css = WP_PLUGIN_URL . '/' . IV_PLUGIN_NAME . '/css/main.css';
        echo "<link rel='stylesheet' href='{$css}' type='text/css' media='' />";
    }

    /**
     * JS設定
     *
     */
    function attachJs() {
        wp_enqueue_script('jquery');
        wp_enqueue_script(IV_PLUGIN_NAME . '-json2', WP_PLUGIN_URL . '/' . IV_PLUGIN_NAME . '/js/jquery.json.js');
    }

    /**
     * Output Input HTML Tag
     */
    function HTMLInput ($params) {
        if (!isset($params['type'])) {
            $params['type'] = 'text';
        }
        if (!isset($params['name'])) {
            if (isset($params['id'])) {
                $params['name'] = $params['id'];
            }
        }
        $ck = $params['checked'];
        unset($params['checked']);
        $str = '';
        foreach ($params as $k=>$v) {
            $str .= " {$k}=\"{$v}\"";
        }
        return "<input {$str} {$ck} />";
    }

    /**
     * Output Submit HTML Tag
     */
    function HTMLSubmit ($params) {
        if (!isset($params['name'])) {
            if (isset($params['id'])) {
                $params['name'] = $params['id'];
            }
        }
        $val = $params['value'];
        unset($params['value']);
        $str = '';
        foreach ($params as $k=>$v) {
            $str .= " {$k}=\"{$v}\"";
        }
        return "<button type='submit' {$str} >{$val}</button>";
    }

    /**
     * Output Textarea HTML Tag
     */
    function HTMLText ($params) {
        if (!isset($params['name'])) {
            if (isset($params['id'])) {
                $params['name'] = $params['id'];
            }
        }
        $val = $params['value'];
        unset($params['value']);
        $str = '';
        foreach ($params as $k=>$v) {
            $str .= " {$k}=\"{$v}\"";
        }
        return "<textarea {$str} >{$val}</textarea>";
    }

    /**
     * Output Select HTML Tag
     */
    function HTMLSelect ($params, $options) {
        if (!isset($params['name'])) {
            $params['name'] = $params['id'];
        }
        $str = '';
        foreach ($params as $k=>$v) {
            $str .= " {$k}=\"{$v}\"";
        }
        $prm = '';
        if (isset($options['params'])) {
            foreach ($options['params'] as $k=>$v) {
                $prm .= " {$k}=\"{$v}\"";
            }
        }
        $opn = '';
        foreach ($options['list'] as $k=>$v) {
            $selected = '';
            if (isset($options['default'])&&!is_null($options['default'])&&$options['default']!='') {
                if ($k == $options['default']) {
                    $selected = "selected=\"selected\"";
                }
            }
            $opn.= "<option value='{$k}' {$prm} {$selected}>{$v}</option>";
        }
        return "<select {$str} >{$opn}</select>";
    }

    /**
     * Output Link HTML Tag
     */
    function HTMLLink ($params) {
        $val = $params['value'];
        unset($params['value']);
        $str = '';
        foreach ($params as $k=>$v) {
            $str .= " {$k}=\"{$v}\"";
        }
        return "<a {$str} >{$val}</a>";
    }

    /**
     * Output Error HTML Tag
     */
    function HTMLError($param) {
        return ($param=='')?'':'<br/><font color="red">'.$param.'</font>';
    }

    /**
     * Output Ymd HTML Tag
     */
    //==================================================================
    //データ取得部分
    //引数
    //$params['year_id']      : リストボックス年ＩＤ
    //$params['month_id']     : リストボックス月ＩＤ
    //$params['day_id']       : リストボックス日ＩＤ
    //$params['min_year']     : 最小年
    //$params['max_year']     : 最大年
    //$params['year']         : 年
    //$params['month']        : 月
    //$params['day']          : 日
    //$params['year_options'] : 年のリストボックスのオプション
    //$params['month_options']: 月のリストボックスのオプション
    //$params['day_options']  : 日のリストボックスのオプション
    //==================================================================
    function HTMLYyyymmdd($params) {
        $yy_id  = $params['year_id'];
        $mm_id  = $params['month_id'];
        $dd_id  = $params['day_id'];
        $yy_val = $params['year'];
        $mm_val = $params['month'];
        $dd_val = $params['day'];

        //現在年月日
        $tm = time();
        $current_yy = date('Y', $tm);
        $current_mm = date('m', $tm);
        $current_dd = date('d', $tm);

        //開始年が指定されていない場合、現在年-9を開始年とする。
        $min_yy = !isset($params['min_year'])?($current_yy - 3):$params['min_year'];
        //終了年が指定されていない場合、現在年+1を終了年とする。
        $max_yy = !isset($params['max_year'])?($current_yy + 1):$params['max_year'];

        //年リスト
        $yy_list = array();
        $yy_list[] = '';
        for ($y=$min_yy; $y<=$max_yy; $y++) {
            $yy_list[$y] = $y;
        }
        echo ImageVoteFunctions::HTMLSelect(array('id'=>$yy_id), array('list'=>$yy_list));
        echo '年';

        //月リスト
        $mm_list = array();
        $mm_list[] = '';
        for ($m=1; $m<=12; $m++) {
            $mm_list[$m] = ImageVoteFunctions::LPAD($m, 2);
        }
        echo ImageVoteFunctions::HTMLSelect(array('id'=>$mm_id), array('list'=>$mm_list));
        echo '月';

        //日リスト
        $dd_list = array();
        $dd_list[] = '';
        echo ImageVoteFunctions::HTMLSelect(array('id'=>$dd_id), array('list'=>$dd_list));
        echo '日';

        $js_function_create_dd_list = 'create_dd_list_' . $yy_id;
        ?>
        <script type="text/javascript" charset="utf-8">
        jQuery(function() {
            jQuery("#<?php echo $yy_id;?>")
                .change(function() {
                    document.getElementById('<?php echo $dd_id?>').length = 0;
                    setTimeout("<?php echo $js_function_create_dd_list?>('" + jQuery("#<?php echo $dd_id;?>").val() + "');", 100);
                }).val("<?php echo $yy_val;?>");
            jQuery("#<?php echo $mm_id;?>")
                .change(function() {
                    document.getElementById('<?php echo $dd_id?>').length = 0;
                    setTimeout("<?php echo $js_function_create_dd_list?>('" + jQuery("#<?php echo $dd_id;?>").val() + "');", 100);
                }).val("<?php echo $mm_val;?>");

            document.getElementById('<?php echo $dd_id?>').length = 0;
            setTimeout("<?php echo $js_function_create_dd_list?>('<?php echo $dd_val;?>');", 100);
        });

        /**
         * 年月日：日リストを作成
         *
         */
        function <?php echo $js_function_create_dd_list;?>(dd) {
            var yy = jQuery("#<?php echo $yy_id;?>").val();
            var mm = jQuery("#<?php echo $mm_id;?>").val();
            if (yy == '' || mm == '') {
                return true;
            }
            var dt = new Date(yy, mm, 0);
            var day_cnt = dt.getDate();

            var option_arr = new Array();
            option_arr[0] = "<option value=''></option>";
            for (var i=1; i<=day_cnt; i++) {
                var did = i;
                var dvl = i;
                if (i<10) {
                    dvl = '0'+ i;
                }
                var selected = "";
                if (did == dd) {
                    selected = "selected";
                }
                option_arr[i] = "<option value='" + did + "' " + selected + ">" + dvl + "</option>";
            }
            jQuery('#<?php echo $dd_id?>').append(option_arr.join('\n'));
        }
        </script>
        <?php
    }

    /**
     * Output Page HTML Tag
     *
     * $params
     * 'total-count':total count
     */
    function HTMLPage ($params) {
        if (!isset($params['total-count'])) {
            return '';
        }

        //REQUEST_URIを解析
        $uris = @explode("?", $_SERVER['REQUEST_URI']);
        $base_url = $uris[0];
        $query_params = array();
        if (count($uris)>1) {
            $querys = @explode("&", $uris[1]);
            $query_params = array();
            foreach ($querys as $query) {
                $tmp_params = @explode("=", $query);
                $query_params[$tmp_params[0]] = $tmp_params[1];
            }
        }
        $now_page = 1;
        if (isset($query_params['pager_id'])) {
            $now_page = $query_params['pager_id'];
        }
        unset($query_params['pager_id']);

        //POSTデータから条件を設定する「s_」を対象とする仕様。
        foreach ($_POST as $key=>$val) {
            if (substr($key, 0 ,2)=='s_') {
                if (is_array($val)) {
                    $i=0;
                    foreach ($val as $k=>$v) {
                        if (is_null($k)) {
                            $k = $i++;
                        }
                        $str = $key."[".$k."]";
                        $query_params[$str] = htmlentities($v);
                    }
                }
                else {
                    $query_params[$key] = htmlentities($val);
                }
            }
        }

        //再構成
        $base_url = site_url($base_url);
        if (count($query_params)>0) {
            $querys = array();
            foreach ($query_params as $key=>$val) {
                $querys[] = $key . '=' . $val;
            }
            $base_url = $base_url . "?" . @implode('&', $querys);
        }

        //全ページ数を算出
        $total_page = ceil($params['total-count'] / SC_PAGE_COUNT);
        $total_pages = array();
        for ($i=1; $i<=$total_page; $i++) {
            $total_pages[$i] = $i;
        }
        //現在ページから最大５つページ番号を表示するための制御
        $page_data = array();
        for ($i=($now_page-5); $i<=($now_page+5); $i++) {
            if (isset($total_pages[$i])) {
                $page_data[$i] = $base_url . '?pager_id=' . $i;
                if (count($query_params)>0) {
                    $page_data[$i] = $base_url . '&pager_id=' . $i;
                }
            }
        }

        //固定部生成
        $next_page = $now_page + 1;
        if ($next_page > $total_page) {
            $next_page = $total_page;
        }
        $prev_page = $now_page - 1;
        if ($prev_page < 1) {
            $prev_page = 1;
        }
        $link1 = $base_url . '?pager_id=1';
        if (count($query_params)>0) {
            $link1 = $base_url . '&pager_id=1';
        }
        $link2 = $base_url . '?pager_id=' . $prev_page;
        if (count($query_params)>0) {
            $link2 = $base_url . '&pager_id=' . $prev_page;
        }
        $link3 = $base_url . '?pager_id=' . $next_page;
        if (count($query_params)>0) {
            $link3 = $base_url . '&pager_id=' . $next_page;
        }
        $link4 = $base_url . '?pager_id=' . $total_page;
        if (count($query_params)>0) {
            $link4 = $base_url . '&pager_id=' . $total_page;
        }

        $page_html = array();
        if ($total_page > 0) {
            $page_html[] = ImageVoteFunctions::HTMLLink(array('href'=>$link1, 'value'=>__(SCLNG_PAGER_FIRST, SC_DOMAIN)));
            $page_html[] = ImageVoteFunctions::HTMLLink(array('href'=>$link2, 'value'=>__(SCLNG_PAGER_PREV, SC_DOMAIN)));
            foreach ($page_data as $key=>$data) {
                if ($key == $now_page) {
                    $page_html[] = $key;
                }
                else {
                    $page_html[] = ImageVoteFunctions::HTMLLink(array('href'=>$data, 'value'=>$key));
                }
            }
            $page_html[] = ImageVoteFunctions::HTMLLink(array('href'=>$link3, 'value'=>__(SCLNG_PAGER_NEXT, SC_DOMAIN)));
            $page_html[] = ImageVoteFunctions::HTMLLink(array('href'=>$link4, 'value'=>__(SCLNG_PAGER_LAST, SC_DOMAIN)));
        }
        $page_html[] = __(SCLNG_PAGER_TOTAL, SC_DOMAIN);
        $page_html[] = ":";
        $page_html[] = $params['total-count'];
        return @implode(' ', $page_html);
    }

    /**
     * Output Hidden HTML Tag's
     *
     */
    function EchoHTMLHiddens ($params) {
        if (is_array($params)) {
            foreach ($params as $key=>$val) {
                if (!is_array($val)) {
                    echo ImageVoteFunctions::HTMLInput(array('type'=>'hidden', 'id'=>$key, 'value'=>$val));
                }
                else {
                    foreach ($val as $k=>$v) {
                        $kname = $key . '[' . $k . ']';
                        echo ImageVoteFunctions::HTMLInput(array('type'=>'hidden', 'id'=>$key.'_'.$k, 'id'=>$kname, 'value'=>$v));
                    }
                }
            }
        }
    }

    /**
     * 乱数発生
     */
    function Rand8() {
        mt_srand((double) microtime() * 1000000);
        return substr(mt_rand(), 0, 8);
    }

    /**
     * 乱数発生
     */
    function RandMd5() {
        mt_srand((double) microtime() * 1000000);
        return md5(sha1(mt_rand()));
    }

    /**
     * フォルダを作成する
     */
    function Mkdir($dir) {
        if (!is_dir($dir)) {
            mkdir($dir);
            chmod($dir, 0755);
        }
    }

    /**
     * ファイルを移動する
     */
    function Move($from, $to) {
        if (file_exists($from)) {
            @unlink($to);
            if (@copy($from, $to)) {
                @unlink($from);
                return true;
            }
            else {
                return false;
            }
        }
        return false;
    }

    /**
     * ファイルをフォルダごと削除
     */
    function Rm($file) {
        require_once(WP_PLUGIN_DIR . '/' . SC_PLUGIN_NAME . '/_component/pear/System.php');
        System::rm("-r " . $file);
    }

    /**
     * 左0埋め
     */
    function LPAD($val1, $val2){
        return str_pad($val1, $val2, '0', STR_PAD_LEFT);
    }

    /**
     * テンプレートコンバーター
     *
     */
    function TemplateConvert($template_file=null, $model=null) {
        $file = WP_PLUGIN_DIR . '/' . SC_PLUGIN_NAME . '/template/' . $template_file;
        if (file_exists($file)) {
            ob_start();
            include($file);
            $contents = ob_get_contents();
            ob_end_clean();
            return $contents;
        }
    }

    /**
     * 新着判定
     */
    function NewValid($regist_date) {
        $sc_option = SimpleCartModel::getOptions();
        $new_day = $sc_option['sc_new'];
        if (isset($new_day)) {
            if (!is_null($new_day) && $new_day!='' && $new_day!=0) {
                $tm = time();
                $yy = date('Y', $tm);
                $mm = date('m', $tm);
                $dd = date('d', $tm);
                $new_limit = date('Ymd', mktime(0, 0, 0, $mm, ($dd-$new_day), $yy));
                $regist_dt = substr(str_replace('-', '', $regist_date), 0, 8);
                if ($regist_dt >= $new_limit) {
                    return true;
                }
            }
        }
        return false;
    }
}
