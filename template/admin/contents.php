<script>
/**
 * 必須チェック
 */
function check_contents(key) {
    var val = jQuery("#iv_contents_title_" + key).val();
    if (val == '') {
        alert("<?php __e(IVLNG_ADMIN_CONTENTS_REQUIRE_TITLE); ?>");
        return false;
    }
    return true;
}
/**
 * 追加ボタン押下時
 */
function add_contents() {
    jQuery("#iv_action").val('add');
    document.getElementById('wp_image_vote').submit();
}
/**
 * 更新ボタン押下時
 */
function update_contents(key) {
    if (check_contents(key)) {
        jQuery("#iv_action").val('update');
        jQuery("#contents_id").val(key);
        document.getElementById('wp_image_vote').submit();
    }
}
/**
 * 削除ボタン押下時
 */
function delete_contents(key) {
    if (confirm('<?php __e(IVLNG_CONFIRM_DELETE) ?>')) {
        jQuery("#iv_action").val('delete');
        jQuery("#contents_id").val(key);
        document.getElementById('wp_image_vote').submit();
    }
}
/**
 * 詳細登録ボタン押下時
 */
function detail_contents(key) {
    if (check_contents(key)) {
        jQuery("#iv_action").val('detail');
        jQuery("#contents_id").val(key);
        document.getElementById('wp_image_vote').submit();
    }
}
/**
 * アンケート登録ボタン押下時
 */
function question_contents(key) {
    if (check_contents(key)) {
        jQuery("#iv_action").val('question');
        jQuery("#contents_id").val(key);
        document.getElementById('wp_image_vote').submit();
    }
}
function toggle_manage_id(key) {
    jQuery("#manage_id_list_" + key).toggle("slow");
}
</script>

<?php //画面タイトル（コンテンツ登録画面） ?>
<h3><?php __e(IVLNG_ADMIN_CONTENTS_TITLE) ?></h3>

<form id="wp_image_vote" name="wp_image_vote" action="<?php echo $_SERVER["REQUEST_URI"] ?>" method="post">
  <?php //プラグイン制御用情報 ?>
  <?php echo $this->hvars(); ?>

  <?php //ユーザーテンプレート情報 ?>
  <?php __e(IVLNG_ADMIN_CONTENTS_THEME); ?>
  <?php echo bloginfo('template_directory'); ?><br />

  <?php //追加ボタン ?>
  <p class="submit"><?php echo $this->input(array('type'=>'button', 'value'=>__v(IVLNG_ADMIN_CONTENTS_ADD)." &raquo;", 'onclick'=>"javascript:add_contents();")); ?></p>
  <hr />
  <div>
    <?php //コンテンツを表示する ?>
    <?php if (is_array($this->model)): ?>
    <?php foreach ($this->model as $key=>$contents): ?>

    <table>

    <?php //--------------------------------- ?>
    <?php //タイトル ?>
    <?php //--------------------------------- ?>
    <tr>
    <td>
      <?php __e(IVLNG_ADMIN_CONTENTS_NAME) ?>
    </td>
    <td>
      <?php
        $i_contents_title = array(
        'type'  => 'text',
        'id'    => "iv_contents_title_{$key}",
        'name'  => "iv_contents_title_{$key}",
        'value' => $contents["iv_contents_title"],
        'class' => 'input_j'
        );
      ?>
      <?php echo $this->input($i_contents_title) ?>
    </td>
    </tr>

    <?php //--------------------------------- ?>
    <?php //タイプ ?>
    <?php //--------------------------------- ?>
    <tr>
    <td>
      <?php __e(IVLNG_ADMIN_CONTENTS_TYPE) ?>
    </td>
    <td>
      <?php
        $i_contents_type1 = array(
        'type'    => 'radio',
        'name'    => "iv_contents_type_{$key}",
        'value'   => '1',
        'checked' => ($contents["iv_contents_type"]=='1')?'checked':''
        );
        $i_contents_type2 = array(
        'type'    => 'radio',
        'name'    => "iv_contents_type_{$key}",
        'value'   => '2',
        'checked' => ($contents["iv_contents_type"]=='2')?'checked':''
        );
      ?>
      <?php echo $this->input($i_contents_type1) ?><?php __e(IVLNG_ADMIN_CONTENTS_TYPE1) ?>
      <?php echo $this->input($i_contents_type2) ?><?php __e(IVLNG_ADMIN_CONTENTS_TYPE2) ?>
    </td>
    </tr>

    <?php //--------------------------------- ?>
    <?php //登録済み画像数 ?>
    <?php //--------------------------------- ?>
    <tr>
    <td valign="top">
      <?php __e(IVLNG_ADMIN_CONTENTS_COUNT) ?>
    </td>
    <td>
      <a href="#" onclick="javascript:toggle_manage_id('<?php echo $key ?>');"><?php echo count($contents['details']) ?></a>
      <div id="manage_id_list_<?php echo $key ?>" style="display:none;">
      <?php foreach ($contents['details'] as $detail): ?>
        <?php echo $detail['manage_id']; ?><br />
      <?php endforeach; ?>
      </div>
    </td>
    </tr>

    <?php //--------------------------------- ?>
    <?php //登録日 ?>
    <?php //--------------------------------- ?>
    <tr>
    <td>
      <?php __e(IVLNG_ADMIN_CONTENTS_REGIST_DT) ?>
    </td>
    <td>
      <?php
        $yy = substr($contents['contents_regist_dt'], 0, 4);
        $mm = substr($contents['contents_regist_dt'], 4, 2);
        $dd = substr($contents['contents_regist_dt'], 6, 2);
      ?>
      <?php echo $yy . '/' . $mm . '/' . $dd ?>
    </td>
    </tr>

    </table>

    <p class="submit">
      <?php echo $this->input(array('type'=>'button', 'value'=>__v(IVLNG_DELETE)." &raquo;", 'onclick'=>"javascript:delete_contents('" . $key . "');")); ?>
      <?php echo $this->input(array('type'=>'button', 'value'=>__v(IVLNG_UPDATE)." &raquo;", 'onclick'=>"javascript:update_contents('" . $key . "');")); ?>
      <?php echo $this->input(array('type'=>'button', 'value'=>__v(IVLNG_ADMIN_CONTENTS_DETAIL)." &raquo;", 'onclick'=>"javascript:detail_contents('" . $key . "');")); ?>
      <?php echo $this->input(array('type'=>'button', 'value'=>__v(IVLNG_ADMIN_CONTENTS_QUESTION)." &raquo;", 'onclick'=>"javascript:question_contents('" . $key . "');")); ?>
    </p>
    <hr />
    <?php endforeach; ?>
    <?php endif; ?>
  </div>
</form>
