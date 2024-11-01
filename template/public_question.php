<?php //背景用DIV ?>
<div id="iv_question_contents" class="iv_question_content_background"></div>

<?php if (is_array($this->model)): ?>
<?php foreach($this->model as $question) : ?>
<?php
//ビュー用データを取得
$contents_id      = $question['contents_id'];
$image_id         = $question['image_id'];
$iv_contents_type = $question['iv_contents_type'];
$image_iv_name    = $question['image_iv_name'];
$questions        = $question['questions'];

//質問用URL生成
$question_request_url = WP_PLUGIN_URL . '/' . IV_PLUGIN_NAME . '/ajax/iv-question_vote.php';
?>
<script>
/**
 * アンケート投票画面表示
 */
function iv_question_show_<?php echo $contents_id ?>(image_id) {
    jQuery("#iv_question_image_id_<?php echo $contents_id ?>").val(image_id);
    var scroll_top    = (document.body.scrollTop==0)?document.documentElement.scrollTop:document.body.scrollTop;
    var scroll_height = (document.body.scrollHeight==0)?document.documentElement.scrollHeight:document.body.scrollHeight;
    var scroll_width  = (document.body.scrollWidth==0)?document.documentElement.scrollWidth:document.body.scrollWidth;
    var b_obj = jQuery("#iv_question_contents");
    var q_obj = jQuery("#iv_question_<?php echo $contents_id ?>");
    b_obj.css('height', scroll_height + 'px');
    b_obj.css('width', scroll_width + 'px');
    q_obj.css('top', (scroll_top + 100) + 'px');
    b_obj.fadeIn('slow');
    q_obj.fadeIn('slow');
}
/**
 * アンケート投票リクエスト
 */
function iv_question_submit_<?php echo $contents_id ?>() {
    var form = jQuery("#frm_iv_question_<?php echo $contents_id ?>");
    question_data = jQuery.toJSON(form.serializeArray());
    jQuery.post('<?php echo $question_request_url ?>', {
        contents_id   : '<?php echo $contents_id ?>',
        image_id      : jQuery("#iv_question_image_id_<?php echo $contents_id ?>").val(),
        question_data : question_data
    },
    function (response) {
        if (response == 'true') {
            alert('<?php echo IVLNG_VOTE_SUCCESS ?>');
            var b_obj = jQuery("#iv_question_contents");
            var q_obj = jQuery("#iv_question_<?php echo $contents_id ?>");
            q_obj.fadeOut('slow');
            b_obj.fadeOut('slow');
        }
    }, 'json');
    return true;
}
/**
 * アンケート投票画面を閉じる
 */
function iv_question_close_<?php echo $contents_id ?>() {
    var b_obj = jQuery("#iv_question_contents");
    var q_obj = jQuery("#iv_question_<?php echo $contents_id ?>");
    q_obj.fadeOut('slow');
    b_obj.fadeOut('slow');
    return true;
}
</script>
<div id="iv_question_<?php echo $contents_id ?>" class="iv_question">
<form id="frm_iv_question_<?php echo $contents_id ?>">
<?php
    $i_hidden = array(
    'type'    => 'hidden',
    'id'      => "iv_question_image_id_{$contents_id}",
    'name'    => "iv_question_image_id_{$contents_id}",
    'value'   => ''
    );
?>
<?php echo $this->input($i_hidden); ?>
<table border="0" cellspacing="0" cellpadding="0">
  <?php if (is_array($questions)): ?>
  <?php foreach ($questions as $question): ?>
  <tr>
  <td align="right" nowrap><?php echo $question['question_label'] ?></a>
  <td align="left">
  <?php //テキスト ?>
  <?php if ($question['question_type'] == '1'): ?>
  <?php
    $i_txt = array(
    'type'    => 'text',
    'id'      => "iv_question_{$question['question_id']}",
    'name'    => "iv_question_{$question['question_id']}",
    'value'   => ''
    );
  ?>
  <?php echo $this->input($i_txt); ?>

  <?php //テキストエリア ?>
  <?php elseif ($question['question_type'] == '2'): ?>
  <?php
    $i_txtarea = array(
    'id'      => "iv_question_{$question['question_id']}",
    'name'    => "iv_question_{$question['question_id']}",
    );
  ?>
  <?php echo $this->text($i_txtarea); ?>

  <?php //リストボックス ?>
  <?php elseif ($question['question_type'] == '3'): ?>
  <?php
    $s_select = array(
    'id'      => "iv_question_{$question['question_id']}",
    'name'    => "iv_question_{$question['question_id']}",
    );
    $list = @explode(';', $question['question_list']);
    $s_select_options = array(
    'list' => array(''=>'') + $list,
    'default' => ''
    );
  ?>
  <?php echo $this->select($s_select, $s_select_options) ?>

  <?php //ラジオボタン ?>
  <?php elseif ($question['question_type'] == '4'): ?>
  <?php
    $list = @explode(';', $question['question_list']);
    $i = 0;
    foreach ($list as $val) {
        $i_radio = array(
        'type'    => 'radio',
        'id'      => "iv_question_{$question['question_id']}_{$i}",
        'name'    => "iv_question_{$question['question_id']}",
        'value'   => $val
        );
        if ($i==0) {
            $i_radio = array_merge($i_radio, array('checked'=>'checked'));
        }
        echo $this->input($i_radio) . $val . ' ';
        $i++;
    }
  ?>

  <?php //チェックボックス ?>
  <?php elseif ($question['question_type'] == '5'): ?>
  <?php
    $list = @explode(';', $question['question_list']);
    $i = 0;
    foreach ($list as $val) {
        $i_check = array(
        'type'    => 'checkbox',
        'id'      => "iv_question_{$question['question_id']}_{$i}",
        'name'    => "iv_question_{$question['question_id']}[]",
        'value'   => $val
        );
        echo $this->input($i_check) . $val . ' ';
        $i++;
    }
  ?>

  <?php endif; ?>
  </td>
  </tr>
  <?php endforeach;?>
  <?php endif;?>

  <tr>
  <td align="center" colspan="2">
  <?php //投票ボタン ?>
  <?php
    $i_btn_vote = array(
    'type'    => 'button',
    'id'      => "iv_btn_vote_{$contents_id}",
    'value'   => __v(IVLNG_VOTE),
    'onclick' => "javascript:iv_question_submit_{$contents_id}();"
    );
  ?>
  <?php echo $this->input($i_btn_vote); ?>

  <?php //閉じるボタン ?>
  <?php
    $i_btn_close = array(
    'type'    => 'button',
    'id'      => "iv_btn_close_{$contents_id}",
    'value'   => __v(IVLNG_CLOSE),
    'onclick' => "javascript:iv_question_close_{$contents_id}();"
    );
  ?>
  <?php echo $this->input($i_btn_close); ?>
  </td>
  </tr>
</table>
</form>
</div>
<?php endforeach; ?>
<?php endif;?>
