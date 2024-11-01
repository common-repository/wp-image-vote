<?php
//ビュー用データを取得
$contents_id      = $this->model['contents_id'];
$image_id         = $this->model['image_id'];
$iv_contents_type = $this->model['iv_contents_type'];
$image_iv_name    = $this->model['image_iv_name'];
$questions        = $this->model['questions'];

//投票用URL生成
$normal_request_url = WP_PLUGIN_URL . '/' . IV_PLUGIN_NAME . '/ajax/iv-normal_vote.php';
?>

<?php //標準投票 ?>
<?php if ($iv_contents_type == '1'): ?>
<script>
/**
 * 標準投票リクエスト
 */
function iv_normal_submit_<?php echo $image_id ?>() {
    jQuery.post('<?php echo $normal_request_url ?>', {
        contents_id : '<?php echo $contents_id ?>',
        image_id    : '<?php echo $image_id ?>'
    },
    function (response) {
        if (response == 'true') {
            alert('<?php echo IVLNG_VOTE_SUCCESS ?>');
        }
    }, 'json');
    return true;
}
</script>
<?php endif; ?>

<?php //画像表示 ?>
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td>
    <img src="<?php echo bloginfo('template_directory') ?>/iv_files/<?php echo $image_iv_name ?>" />
  </td>
  </tr>

  <?php //投票ボタン ?>
  <tr>
  <td align="center">
  <?php
    $event = "javascript:iv_normal_submit_{$image_id}();";
    if ($iv_contents_type == '2') {
        $event = "javascript:iv_question_show_{$contents_id}('{$image_id}');";
    }
    $i_btn_vote = array(
    'type'    => 'button',
    'id'      => "iv_btn_vote_{$image_id}",
    'value'   => __v(IVLNG_VOTE),
    'onclick' => $event
    );
  ?>
  <?php echo $this->input($i_btn_vote); ?>
  </td>
  </tr>
</table>
