<?php
define('IVLNG_ADMIN',                               'WP Image Vote');

define('IVLNG_UPDATE',                              'Update');
define('IVLNG_DELETE',                              'Delete');
define('IVLNG_BACK',                                'Back');
define('IVLNG_CLOSE',                               'Close');
define('IVLNG_SEARCH',                              'Search');
define('IVLNG_CONFIRM_DELETE',                      '削除します。よろしいですか？');
define('IVLNG_VOTE',                                '投票する');
define('IVLNG_VOTE_SUCCESS',                        '投票しました。');
define('IVLNG_ORDER_ASC',                           '昇順');
define('IVLNG_ORDER_DESC',                          '降順');
define('IVLNG_COLLECT_KB_IP',                       '同一IPアドレスを除く');
define('IVLNG_COLLECT_KB_NOTHING',                  '制限しない');
define('IVLNG_OUTPUT_KB_IMAGE_ID',                  '画像単位');
define('IVLNG_OUTPUT_KB_NOTHING',                   '生データ');
define('IVLNG_CSV_KB_DISPLAY',                      '画面表示');
define('IVLNG_CSV_KB_FILE',                         'CSVファイル出力');
define('IVLNG_KIKAN_KB_0',                          '全て');
define('IVLNG_KIKAN_KB_1',                          '日別');
define('IVLNG_KIKAN_KB_2',                          '週別');
define('IVLNG_KIKAN_KB_3',                          '月別');
define('IVLNG_KIKAN_KB_4',                          '年別');
define('IVLNG_KARA',                                '～');
define('IVLNG_RANK',                                '順位');
define('IVLNG_IMAGE',                               '画像');
define('IVLNG_CNT',                                 '得票数');
define('IVLNG_DATA',                                 '日時');

define('IVLNG_ADMIN_MENU',                          'アンケート投票');
define('IVLNG_ADMIN_MENU_OPTION',                   '基本設定');
define('IVLNG_ADMIN_MENU_CONTENTS',                 'コンテンツ管理');
define('IVLNG_ADMIN_MENU_RESULTS',                  '投票結果');

define('IVLNG_ADMIN_OPTION_TITLE',                  '使い方');

define('IVLNG_ADMIN_CONTENTS_THEME',                '現在のテーマのパス：');
define('IVLNG_ADMIN_CONTENTS_TITLE',                'コンテンツ登録');
define('IVLNG_ADMIN_CONTENTS_ADD',                  'コンテンツ追加');
define('IVLNG_ADMIN_CONTENTS_DETAIL',               '詳細登録');
define('IVLNG_ADMIN_CONTENTS_QUESTION',             'アンケート登録');
define('IVLNG_ADMIN_CONTENTS_NAME',                 '企画名称');
define('IVLNG_ADMIN_CONTENTS_TYPE',                 'タイプ');
define('IVLNG_ADMIN_CONTENTS_TYPE1',                '単純投票');
define('IVLNG_ADMIN_CONTENTS_TYPE2',                'アンケート回収機能付');
define('IVLNG_ADMIN_CONTENTS_COUNT',                '登録済み画像数');
define('IVLNG_ADMIN_CONTENTS_REGIST_DT',            '登録日');
define('IVLNG_ADMIN_CONTENTS_ALL',                  '総投票数');
define('IVLNG_ADMIN_CONTENTS_REQUIRE_TITLE',        '企画名称は必須項目です。');

define('IVLNG_ADMIN_CONTENTS_DETAIL_TITLE',         '詳細登録');
define('IVLNG_ADMIN_CONTENTS_DETAIL_ADD',           '画像追加');
define('IVLNG_ADMIN_CONTENTS_DETAIL_ID',            '画像管理ID：');

define('IVLNG_ADMIN_CONTENTS_QUESTION_TITLE',       'アンケート登録');
define('IVLNG_ADMIN_CONTENTS_QUESTION_ADD',         '質問追加');
define('IVLNG_ADMIN_CONTENTS_QUESTION_TYPE',        '質問タイプ');
define('IVLNG_ADMIN_CONTENTS_QUESTION_TYPE1',       'テキスト');
define('IVLNG_ADMIN_CONTENTS_QUESTION_TYPE2',       'テキストエリア');
define('IVLNG_ADMIN_CONTENTS_QUESTION_TYPE3',       'リストボックス');
define('IVLNG_ADMIN_CONTENTS_QUESTION_TYPE4',       'ラジオボタン');
define('IVLNG_ADMIN_CONTENTS_QUESTION_TYPE5',       'チェックボックス');
define('IVLNG_ADMIN_CONTENTS_QUESTION_LABEL',       '質問ラベル');
define('IVLNG_ADMIN_CONTENTS_QUESTION_LIST',        '値リスト');
define('IVLNG_ADMIN_CONTENTS_QUESTION_REQUIRE',     '必須');
define('IVLNG_ADMIN_CONTENTS_QUESTION_LIST_SAMPLE', '「:」区切りで値リストを並べてください。（リスト、ラジオ、チェックのみ有効）');

define('IVLNG_ADMIN_RESULTS_TITLE',                 '投票結果');
define('IVLNG_ADMIN_RESULTS_CRITERIA',              '▼検索条件');
define('IVLNG_ADMIN_RESULTS_CONTENTS',              '企画');
define('IVLNG_ADMIN_RESULTS_ORDER',                 '並び順');
define('IVLNG_ADMIN_RESULTS_RANKING',               'ランキング区分');
define('IVLNG_ADMIN_RESULTS_COLLECT',               '名寄区分');
define('IVLNG_ADMIN_RESULTS_OUTPUT',                '出力区分');
define('IVLNG_ADMIN_RESULTS_KIKAN_SYUBETU',         '期間種別');
define('IVLNG_ADMIN_RESULTS_KIKAN',                 '対象期間');

define('IVLANG_ADMIN_OPTION_1',                     '1. コンテンツ管理にて、企画（コンテンツ）を追加する。');
define('IVLANG_ADMIN_OPTION_2',                     '2. 企画名称を適切に設定する。');
define('IVLANG_ADMIN_OPTION_3',                     '3. 企画タイプを設定する。');
define('IVLANG_ADMIN_OPTION_4',                     '4. 「更新」で変更を確定する。');
define('IVLANG_ADMIN_OPTION_5',                     '5. 「詳細登録」へ遷移する。');
define('IVLANG_ADMIN_OPTION_6',                     '6. 詳細登録にて、投票してもらう画像を追加する。');
define('IVLANG_ADMIN_OPTION_7',                     '7. 画像を選択し、「更新」で追加を確定する。');
define('IVLANG_ADMIN_OPTION_8',                     '8. 画像の追加が終わったら「戻る」でコンテンツ管理へ遷移する。');
define('IVLANG_ADMIN_OPTION_9',                     '9. アンケート機能を使用する場合、「アンケート登録」へ遷移する。（後は適当に。。。）');
define('IVLANG_ADMIN_OPTION_10',                    '10.コンテンツ管理画面にて、「登録済み画像数」の数をクリックすると、ページ貼付け用のIDが表示される。');
define('IVLANG_ADMIN_OPTION_11',                    '11.表示されている画像IDを下図のようにページ設定する。');
define('IVLANG_ADMIN_OPTION_12',                    '12.終わり');

