<script>
/**
 * 追加ボタン押下時
 */
function add_question() {
    jQuery("#iv_action").val('question_add');
    document.getElementById('wp_image_vote').submit();
}
/**
 * 更新ボタン押下時
 */
function update_question(key) {
    jQuery("#iv_action").val('question_update');
    jQuery("#question_id").val(key);
    document.getElementById('wp_image_vote').submit();
}
/**
 * 削除ボタン押下時
 */
function delete_question(key) {
    if (confirm('<?php __e(IVLNG_CONFIRM_DELETE) ?>')) {
        jQuery("#iv_action").val('question_delete');
        jQuery("#question_id").val(key);
        document.getElementById('wp_image_vote').submit();
    }
}
</script>

<?php //画面タイトル（質問登録画面） ?>
<h3><?php __e(IVLNG_ADMIN_CONTENTS_QUESTION_TITLE) ?></h3>

<form id="wp_image_vote" name="wp_image_vote" action="<?php echo $_SERVER["REQUEST_URI"] ?>" method="post">
  <?php //プラグイン制御用情報 ?>
  <?php echo $this->hvars(); ?>

  <?php //ユーザーテンプレート情報 ?>
  <?php __e(IVLNG_ADMIN_CONTENTS_THEME); ?>
  <?php echo bloginfo('template_directory'); ?><br />

  <?php //質問追加ボタン ?>
  <p class="submit"><?php echo $this->input(array('type'=>'button', 'value'=>__v(IVLNG_ADMIN_CONTENTS_QUESTION_ADD)." &raquo;", 'onclick'=>"javascript:add_question();")); ?></p>
  <hr />
  <div>
    <?php //質問情報を表示する ?>
    <?php if (is_array($this->model['questions'])): ?>
    <?php $i = 1; ?>
    <?php foreach ($this->model['questions'] as $key=>$question): ?>

    <table>

    <?php //--------------------------------- ?>
    <?php //タイプ ?>
    <?php //--------------------------------- ?>
    <tr>
    <td>
      <?php __e(IVLNG_ADMIN_CONTENTS_QUESTION_TYPE); ?>
    </td>
    <td>
      <?php
        $s_question_type = array('name' => "iv_question_type_{$key}");
        $s_question_type_options = array(
        'list' => array(
            '1' => __v(IVLNG_ADMIN_CONTENTS_QUESTION_TYPE1),
            '2' => __v(IVLNG_ADMIN_CONTENTS_QUESTION_TYPE2),
            '3' => __v(IVLNG_ADMIN_CONTENTS_QUESTION_TYPE3),
            '4' => __v(IVLNG_ADMIN_CONTENTS_QUESTION_TYPE4),
            '5' => __v(IVLNG_ADMIN_CONTENTS_QUESTION_TYPE5)
            ),
        'default' => $question['question_type']
        );
      ?>
      <?php echo $this->select($s_question_type, $s_question_type_options) ?>
    </td>
    </tr>

    <?php //--------------------------------- ?>
    <?php //ラベル ?>
    <?php //--------------------------------- ?>
    <tr>
    <td>
      <?php __e(IVLNG_ADMIN_CONTENTS_QUESTION_LABEL); ?>
    </td>
    <td>
      <?php
        $i_question_lbl = array(
        'type'  => 'text',
        'name'  => "iv_question_label_{$key}",
        'value' => $question["question_label"],
        'class' => 'input_j'
        );
      ?>
      <?php echo $this->input($i_question_lbl) ?>
    </td>
    </tr>

    <?php //--------------------------------- ?>
    <?php //値リスト ?>
    <?php //--------------------------------- ?>
    <tr>
    <td valign='top'>
      <?php __e(IVLNG_ADMIN_CONTENTS_QUESTION_LIST); ?>
    </td>
    <td>
      <?php
        $i_question_list = array(
        'type'  => 'text',
        'name'  => "iv_question_list_{$key}",
        'value' => $question["question_list"],
        'class' => 'input_j',
        'style' => 'width:240px;'
        );
      ?>
      <?php echo $this->input($i_question_list) ?><br />
      <?php __e(IVLNG_ADMIN_CONTENTS_QUESTION_LIST_SAMPLE); ?>
    </td>
    </tr>

    <?php //--------------------------------- ?>
    <?php //必須項目 ?>
    <?php //--------------------------------- ?>
    <tr>
    <td>
      <?php __e(IVLNG_ADMIN_CONTENTS_QUESTION_REQUIRE); ?>
    </td>
    <td>
      <?php
        $i_question_require = array(
        'type'    => 'checkbox',
        'name'    => "iv_question_require_{$key}",
        'value'   => '1',
        'checked' => ($question["question_require"]=='1')?'checked':''
        );
      ?>
      <?php echo $this->input($i_question_require) ?>
    </td>
    </tr>


    </table>

    <p class="submit">
      <?php echo $this->input(array('type'=>'button', 'value'=>__v(IVLNG_UPDATE)." &raquo;", 'onclick'=>"javascript:update_question('" . $key . "');")); ?>
      <?php echo $this->input(array('type'=>'button', 'value'=>__v(IVLNG_DELETE)." &raquo;", 'onclick'=>"javascript:delete_question('" . $key . "');")); ?>
    </p>
    <hr />
    <?php $i++; ?>
    <?php endforeach; ?>
    <?php endif; ?>
  </div>
</form>
<a href="/wp-admin/admin.php?page=ImageVoteAdminContents.php"><?php __e(IVLNG_BACK); ?></a>
