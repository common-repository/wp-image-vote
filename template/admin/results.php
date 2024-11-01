<script>
function toggle_search() {
    jQuery("#div_iv_search").toggle("slow");
}
function search_results() {
    jQuery("#iv_action").val('search');
    document.getElementById('wp_image_vote').submit();
}
function criteria_controller() {
    var ranking_kb = jQuery("#iv_search_ranking_kb").val();
    if (ranking_kb == 1) {
        jQuery("#tr_collect_kb").show();
        jQuery("#tr_kikan_syubetu").show();
    }
    else {
        jQuery("#tr_collect_kb").hide();
        jQuery("#tr_kikan_syubetu").hide();
    }
}
jQuery(document).ready(function() {
    jQuery("#iv_search_ranking_kb").unbind('change');
    jQuery("#iv_search_ranking_kb").change(function() {
        criteria_controller();
    }).change();
});
</script>

<?php //画面タイトル（投票結果画面） ?>
<h3><?php __e(IVLNG_ADMIN_RESULTS_TITLE) ?></h3>

<form id="wp_image_vote" name="wp_image_vote" action="<?php echo $_SERVER["REQUEST_URI"] ?>" method="post">
  <?php //プラグイン制御用情報 ?>
  <?php echo $this->hvars(); ?>

  <?php //検索条件 ?>
  <div>
    <a href="#" onclick="javascript:toggle_search();"><?php echo __e(IVLNG_ADMIN_RESULTS_CRITERIA) ?></a>
  </div>
  <div id="div_iv_search" style="display:none;">
    <table class="results_table">
    <?php foreach($this->model['search'] as $key=>$search): ?>
    <tr id="tr_<?php echo $key ?>">
      <td>
        <?php __e($search['title']); ?>
      </td>
      <td>
      <?php
        $s_criteria = array('id' => "iv_search_{$key}", 'name' => "iv_search_{$key}");
        $s_criteria_options = array('list' => $search['data'], 'default' => $this->model['result']['criteria'][$key]);
      ?>
      <?php echo $this->select($s_criteria, $s_criteria_options) ?>
      </td>
    </tr>
    <?php endforeach; ?>
    <tr>
      <td>
        <?php __e(IVLNG_ADMIN_RESULTS_KIKAN); ?>
      </td>
      <td>
      <?php
        $f_params = array(
            'type' => 'text',
            'name' => 'iv_search_f_ymd'
        );
        $t_params = array(
            'type' => 'text',
            'name' => 'iv_search_t_ymd',
        );
      ?>
      <?php echo $this->input($f_params) ?><?php echo IVLNG_KARA ?><?php echo $this->input($t_params) ?>
      </td>
    </tr>
    </table>
    <p class="submit">
      <?php echo $this->input(array('type'=>'button', 'value'=>__v(IVLNG_SEARCH)." &raquo;", 'onclick'=>"javascript:search_results();")); ?>
    </p>
  </div>

  <?php //結果テーブル ?>
  <?php if (is_array($this->model['result']['list'])): ?>
  <div class="iv_results">
  <table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <?php //画像別 ?>
    <?php if ($this->model['result']['criteria']['ranking_kb'] == 1): ?>
    <th width="40px" ><?php __e(IVLNG_RANK); ?></th>
    <th width="100px"><?php __e(IVLNG_IMAGE); ?></th>
    <th width="40px" ><?php __e(IVLNG_CNT); ?></th>
    <?php //全データ ?>
    <?php else: ?>
    <th width="5%"><?php __e(IVLNG_IMAGE); ?></th>
    <th width="5%"><?php __e(IVLNG_DATA); ?></th>
    <?php foreach ($this->model['contents']['questions'] as $key=>$item): ?>
    <th width="5%"><?php echo $item['question_label']; ?></th>
    <?php endforeach; ?>
    <?php endif; ?>
  </tr>
  </thead>
  <tbody>
  <?php //順位 ?>
  <?php
    $i = 1;
  ?>
  <?php foreach ($this->model['result']['list'] as $key=>$item): ?>
  <?php
    $kikan_syubetu = $this->model['result']['criteria']['kikan_syubetu'];
    $image_name    = $this->model['contents']['details'][$item['image_id']]['image_iv_name'];
    $cnt           = $item['cnt'];
  ?>
  <tr>
  <?php //画像別 ?>
  <?php if ($this->model['result']['criteria']['ranking_kb'] == 1): ?>
    <?php //順位 ?>
    <td><?php echo $i ?></td>
    <?php //画像 ?>
    <td><img src="<?php echo bloginfo('template_directory') . '/iv_files/' . $image_name ?>" width="100px"></td>
    <?php //得票数 ?>
    <td><?php echo $cnt ?></td>

  <?php //全データ ?>
  <?php else: ?>
    <?php //画像 ?>
    <td><img src="<?php echo bloginfo('template_directory') . '/iv_files/' . $image_name ?>" width="100px"></td>
    <td><?php echo $item['regist_date'] ?></td>
    <?php for ($j=1; $j<=20; $j++): ?>
    <?php if (isset($this->model['contents']['questions'][$item["question_id_{$j}"]])): ?>
    <td><?php echo null2br($item["question_vl_{$j}"]) ?></td>
    <?php endif; ?>
    <?php endfor; ?>
  <?php endif; ?>
  </tr>
  <?php $i++ ?>
  <?php endforeach; ?>
  </table>
  </div>
  <?php endif; ?>

</form>
