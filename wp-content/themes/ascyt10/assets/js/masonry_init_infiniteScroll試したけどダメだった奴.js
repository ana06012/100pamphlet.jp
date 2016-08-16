jQuery(function($){

  //lazyload のイニシャライズ
  $("img.lazy").lazyload({
    effect: 'fadeIn',
    effectspeed: 1000,
    threshold: 400
  });

  var min_width = 480;

  //画面幅による分岐と imagesLoaded, Masonry のイニシャライズを関数化
  function masonry_update() {
    var $container = $('#d-port');
    if ( $('html').width() < min_width ) {
        $container.masonry('destroy');
    } else {
      $container.imagesLoaded(function(){
        $container.masonry({
          itemSelector: '.d-port-item',
          columnWidth: 240
        });
      });
    }
  }

  masonry_update();


  $container.infinitescroll({
		navSelector  : '.navigation',
		nextSelector : '.navigation a',
		itemSelector : '#d-port .d-port-item',
		maxPage : 5,
		animate:true,
		extraScrollPx: -200,
		loading: {
			finishedMsg: '終わりです！',
			img: 'loading.gif'
		}
	},

//trigger Masonry as a callback
	function( newElements ) {
		var $newElems = $( newElements );
		$newElems.imagesLoaded(function(){
			$container.masonry( 'appended', $newElems, true );
		});
		$(".navigation").insertAfter("#d-port").delay(300).fadeIn(600);
	});
	$('#d-port').infinitescroll('unbind'); // 初期化
	$(".navigation a").click(function(){
		$('#d-port').infinitescroll('retrieve');
		return false;
	});


  //リサイズ時の処理
  var timer = false;
  $(window).resize(function(){
    if (timer !== false) {
      clearTimeout(timer);
    }
    timer = setTimeout(function() {
      masonry_update();
    }, 200);
  });

    //lmagnificPopup のイニシャライズ
    $('.d-port-item-img').magnificPopup({
          delegate: 'a',
          type: 'image',
          disableOn: function() {
              if( $(window).width() < 480 ) {
                  return false;
              }
              return true;
          },
          gallery: { //ギャラリーオプション
              enabled:true
          },
          image: {
              // image コンテントタイプのオプション
              cursor: null,
              titleSrc: function(item) {
                  return item.el.find('img').attr('alt');
              }
          }
    });
});
