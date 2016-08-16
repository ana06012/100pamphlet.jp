<?php
global $taxonomy_name;
global $post_type;
global $post_type_name;
global $postname;
$post_type = esc_html(get_post_type_object(get_post_type())->name);
$post_type_name = esc_html(get_post_type_object(get_post_type())->label );
$taxonomy_name = $post_type.'_cat';
$post_id = $post->post_name;
$postname = get_the_title( $post->ID );

$url_designer = 'http://chat.100pamphlet.jp/api/v1/users?id='.$post_id;
$json_designer = file_get_contents($url_designer);
$json_designer = mb_convert_encoding($json_designer, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$arr_designer = json_decode($json_designer,true);

if ($arr_designer === NULL) {
	return;
}else{
	$avatar_image = $arr_designer["user"]["avatar_image"];
	$history = $arr_designer["user"]["history"];
	$json_designer_count = count($arr_designer["user"]["portfolio"]);
	for($i=$json_designer_count-1;$i>=0;$i--){
		$arr_portfolios[] = array('d_id'=>$designer_id,'d_portfolio'=>$arr_designer["user"]["portfolio"][$i]["file"]);
	}
}
shuffle($arr_portfolios);


get_header(); ?>
	<section id="main" class="main-contents mf">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">

					<?php if(!is_front_page()): ?>
					<div class="breadcrumbs">
						<?php if(function_exists('bcn_display'))
						{
							bcn_display();
						}?>
					</div>
					<?php endif; ?>

					<div class="row mt-20 mb-20">
						<div class="col-sm-6 mb-10">
							<img src="http://chat.100pamphlet.jp<?php echo $avatar_image; ?>" class="boder-gray" >
						</div>
						<div class="col-sm-6"><?php echo $history; ?></div>
					</div>

					<div id="d-port">
					<?php
					foreach( $arr_portfolios as $arr_portfolio ){
						echo '<div class="d-port-item"><div class="d-port-item-img">';
						echo '<a href="http://chat.100pamphlet.jp/upload/portfolio/'.$arr_portfolio['d_portfolio'].'">';
						echo '<img class="lazy" data-original="http://chat.100pamphlet.jp/upload/portfolio/'.$arr_portfolio['d_portfolio'].'" src="http://chat.100pamphlet.jp/upload/portfolio/'.$arr_portfolio['d_portfolio'].'"></a></div>';
						echo '</div>';
					}
					?>
					</div>

				</div>

			</div>
		</div>
	</section>
<?php get_footer(); ?>