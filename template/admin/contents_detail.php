<script>
/**
 * 追加ボタン押下時
 */
function add_contents() {
    jQuery("#iv_action").val('contents_add');
    document.getElementById('wp_image_vote').submit();
}
/**
 * 更新ボタン押下時
 */
function update_contents(key) {
    jQuery("#iv_action").val('contents_update');
    jQuery("#image_id").val(key);
    document.getElementById('wp_image_vote').submit();
}
/**
 * 削除ボタン押下時
 */
function delete_contents(key) {
    if (confirm('<?php __e(IVLNG_CONFIRM_DELETE) ?>')) {
        jQuery("#iv_action").val('contents_delete');
        jQuery("#image_id").val(key);
        document.getElementById('wp_image_vote').submit();
    }
}
</script>

<?php //画面タイトル（コンテンツ画像登録画面） ?>
<h3><?php __e(IVLNG_ADMIN_CONTENTS_DETAIL_TITLE) ?></h3>

<form id="wp_image_vote" name="wp_image_vote" action="<?php echo $_SERVER["REQUEST_URI"] ?>" method="post" enctype="multipart/form-data">
  <?php //プラグイン制御用情報 ?>
  <?php echo $this->hvars(); ?>

  <?php //ユーザーテンプレート情報 ?>
  <?php __e(IVLNG_ADMIN_CONTENTS_THEME); ?>
  <?php echo bloginfo('template_directory'); ?><br />

  <?php //画像追加ボタン ?>
  <p class="submit"><?php echo $this->input(array('type'=>'button', 'value'=>__v(IVLNG_ADMIN_CONTENTS_DETAIL_ADD)." &raquo;", 'onclick'=>"javascript:add_contents();")); ?></p>
  <hr />
  <div>
    <?php //管理画像を表示する ?>
    <?php if (is_array($this->model['details'])): ?>
    <?php $i = 1; ?>
    <?php foreach ($this->model['details'] as $key=>$images): ?>
    <?php __e(IVLNG_ADMIN_CONTENTS_DETAIL_ID); ?>
    <?php echo $images['manage_id']; ?><br />
    <?php if (!isset($images['image_iv_name'] )): ?>
    <?php
        $i_contents_file = array(
        'type'  => 'file',
        'name'  => "iv_contents_file_{$key}",
        'value' => $this->model["iv_contents_file_{$key}"],
        );
    ?>
    <?php echo $this->input($i_contents_file) ?><br />
    <?php else: ?>
    <img src="<?php echo bloginfo('template_directory') . '/iv_files/' . $images['image_iv_name'] ?>" width="200px">
    <?php endif; ?>
    <p class="submit">
      <?php if (!isset($images['image_iv_name'] )): ?>
      <?php echo $this->input(array('type'=>'button', 'value'=>__v(IVLNG_UPDATE)." &raquo;", 'onclick'=>"javascript:update_contents('" . $key . "');")); ?>
      <?php endif; ?>
      <?php echo $this->input(array('type'=>'button', 'value'=>__v(IVLNG_DELETE)." &raquo;", 'onclick'=>"javascript:delete_contents('" . $key . "');")); ?>
    </p>
    <hr />
    <?php $i++; ?>
    <?php endforeach; ?>
    <?php endif; ?>
  </div>
</form>
<a href="/wp-admin/admin.php?page=ImageVoteAdminContents.php"><?php __e(IVLNG_BACK); ?></a>
