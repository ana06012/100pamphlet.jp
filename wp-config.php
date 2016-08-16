<?php
/**
 * WordPress の基本設定
 *
 * このファイルは、インストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さずにこのファイルを "wp-config.php" という名前でコピーして
 * 直接編集して値を入力してもかまいません。
 *
 * このファイルは、以下の設定を含みます。
 *
 * * MySQL 設定
 * * 秘密鍵
 * * データベーステーブル接頭辞
 * * ABSPATH
 *
 * @link http://wpdocs.sourceforge.jp/wp-config.php_%E3%81%AE%E7%B7%A8%E9%9B%86
 *
 * @package WordPress
 */

// 注意:
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.sourceforge.jp/Codex:%E8%AB%87%E8%A9%B1%E5%AE%A4 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - この情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define('DB_NAME', 'nouentai-new_100pamph');

/** MySQL データベースのユーザー名 */
define('DB_USER', 'nouentai-new');

/** MySQL データベースのパスワード */
define('DB_PASSWORD', '8ireut7vyhs');

/** MySQL のホスト名 */
define('DB_HOST', 'mysql414.db.sakura.ne.jp');

/** データベースのテーブルを作成する際のデータベースの文字セット */
define('DB_CHARSET', 'utf8');

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define('DB_COLLATE', '');

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ',@7>W(Mr;u-}b|CYq`HsK4kfJOA{]}#]xym]+||2a3R WNC;mwcJNg.z)w@/*9a+');
define('SECURE_AUTH_KEY',  'eam}2rouxl:vHqUJLdv5!_Gkj.Squ[J]7Sj)CH; ht{SC~iKh}+a52Fu+aM6=F)q');
define('LOGGED_IN_KEY',    'URE=JRN-jxzUuFZ[Z6}!W2.i0kl$}^:7w7|xi)))bj@SQVJ#MD:-y|]FdQyi-^8,');
define('NONCE_KEY',        '|KM 0S;|llQPE$htCjq%+9-h@dS_GvgFcYpg%Fz]TCZrp8zGj1nL_w @j2;zl-CI');
define('AUTH_SALT',        'Z@pCd-`yr3t7[%n!L3&#0v/<GsvBU)O=6m8Oko)K~veH4I9r@Dh$J!tC(RUFuji5');
define('SECURE_AUTH_SALT', 'AlWZS@yU5 jl?MZ/`G9h6EhFGD^mZ1[`LK. m!w~z_kZHwOb_kD=;FS@||,R7C`,');
define('LOGGED_IN_SALT',   'khg(_Tou|j|8>+FK[$BZ1:J;QVl%+9B64S-..`;$3*W+}&VY%FpA8&+yevvT(<$P');
define('NONCE_SALT',       'd 3d?AgaLA<cGOzfn%nah,=Ro@<$f)+?aN3,usI3nxZk$~|MDBk4BQ(h-8[s!c95');

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix  = '100p_';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 *
 * その他のデバッグに利用できる定数については Codex をご覧ください。
 *
 * @link http://wpdocs.osdn.jp/WordPress%E3%81%A7%E3%81%AE%E3%83%87%E3%83%90%E3%83%83%E3%82%B0
 */
define('WP_DEBUG', false);

/* 編集が必要なのはここまでです ! WordPress でブログをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');


//--- disable auto upgrade
define( 'AUTOMATIC_UPDATER_DISABLED', true );


