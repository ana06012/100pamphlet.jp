var now_post_num = 5; // 現在表示されている数
var get_post_num = 5; // 一度に取得する数

$(function() {
    $("#more_disp a").live("click", function() {

        $("#more_disp").html('<img class="ajax_loading" src="http://tollino.sakura.ne.jp/corp/wp-content/themes/ascyt10/images/ajax_loader.gif" />');

        $.ajax({
            type: 'post',
            url: 'http://tollino.sakura.ne.jp/corp/wp-content/themes/ascyt10/more-disp.php',
            data: {
                'now_post_num': now_post_num,
                'get_post_num': get_post_num
            },
            success: function(data) {
                now_post_num = now_post_num + get_post_num;
                data = JSON.parse(data);
                $("#content").append(data['html']);
                $("#more_disp").remove();
                if (!data['noDataFlg']) {
                    $("#content").append('<div id="more_disp"><a href="#">もっと表示</a></div>');
                }
            }
        });
        return false;
    });
});