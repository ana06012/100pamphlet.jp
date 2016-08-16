<?php
$url = "http://chat.100pamphlet.jp/api/v1/users";
$json = file_get_contents($url);
$json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$arr = json_decode($json,true);

if ($arr === NULL) {
	return;
}else{
	$json_count = count($arr["users"]);

// 	$designer_ids = array();
// 	for($i=$json_count-1;$i>=0;$i--){
// 		$designer_ids[] = $arr["users"][$i]["id"];
// 	}

	$designer_ids_pre = array();
	$designer_ids = array();
	for($i=$json_count-1;$i>=0;$i--){
		$designer_ids_pre[] = $arr["users"][$i]["id"];
	}
	shuffle($designer_ids_pre);
	for($i=10;$i>=0;$i--){
		$designer_ids[] = $designer_ids_pre[$i];
	}

	$arr_portfolios = array();
	foreach( $designer_ids as $designer_id ){
		$url_designer = 'http://chat.100pamphlet.jp/api/v1/users?id='.$designer_id;
		$json_designer = file_get_contents($url_designer);
		$json_designer = mb_convert_encoding($json_designer, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
		$arr_designer = json_decode($json_designer,true);

		if ($arr_designer === NULL) {
			return;
		}else{
			$json_designer_count = count($arr_designer["user"]["portfolio"]);
			for($i=$json_designer_count-1;$i>=0;$i--){
				$arr_portfolios[] = array('d_id'=>$designer_id,'d_portfolio'=>$arr_designer["user"]["portfolio"][$i]["file"]);
			}
		}

		if(!wbsExistPost('designer', $designer_id)){
			$my_post = array(
				'post_name' => $designer_id,
				'post_title' => 'デザイナー'.$designer_id,
				'post_status' => 'publish',
				'post_type' => 'designer'
			);
			// 投稿をデータベースへ追加
			wp_insert_post( $my_post );
		}
	}
	shuffle($arr_portfolios);
}

 ?>



					<?php
					foreach( $arr_portfolios as $arr_portfolio ){
						echo '<div class="d-port-item"><div class="d-port-item-img">';
						echo '<a href="http://chat.100pamphlet.jp/upload/portfolio/'.$arr_portfolio['d_portfolio'].'">';
						echo '<img class="lazy" data-original="http://chat.100pamphlet.jp/upload/portfolio/'.$arr_portfolio['d_portfolio'].'" src="http://chat.100pamphlet.jp/upload/portfolio/'.$arr_portfolio['d_portfolio'].'"></a></div>';
						echo '<div class="d-port-item-txt"><span class="black-icon"><a href="./'.$arr_portfolio['d_id'].'/">このデザイナーを見る</a></span></div>';
						echo '</div>';
					}
					?>
