<h3><?php __e(IVLNG_ADMIN_OPTION_TITLE) ?></h3>
<form name="wp_image_vote" action="<?php echo $_SERVER["REQUEST_URI"] ?>" method="post">
  <input type="hidden" id="action" name="iv_action" value="setting" />

  <div>
    <?php __e(IVLANG_ADMIN_OPTION_1) ?>
  </div>
  <div>
    <?php __e(IVLANG_ADMIN_OPTION_2) ?>
  </div>
  <div>
    <?php __e(IVLANG_ADMIN_OPTION_3) ?>
  </div>
  <div>
    <?php __e(IVLANG_ADMIN_OPTION_4) ?>
  </div>
  <div>
    <?php __e(IVLANG_ADMIN_OPTION_5) ?>
  </div>
  <div>
    <?php __e(IVLANG_ADMIN_OPTION_6) ?>
  </div>
  <div>
    <?php __e(IVLANG_ADMIN_OPTION_7) ?>
  </div>
  <div>
    <?php __e(IVLANG_ADMIN_OPTION_8) ?>
  </div>
  <div>
    <?php __e(IVLANG_ADMIN_OPTION_9) ?>
  </div>
  <div>
    <?php __e(IVLANG_ADMIN_OPTION_10) ?>
  </div>
  <div>
    <?php __e(IVLANG_ADMIN_OPTION_11) ?>
  </div>
  <div>
    <?php __e(IVLANG_ADMIN_OPTION_12) ?>
  </div>

  <div>
    <image src="<?php echo WP_PLUGIN_URL ?>/<?php echo IV_PLUGIN_NAME ?>/images/001.png" class="iv_op_img" />
  </div>
</form>
