//**************************************
// header
//**************************************

//ヘッダーナビ（スマホ）

$(function () {
  var mobileBreakpoint = 768;
  // 初期表示時に処理
  handleNavigation($(window).width());
  // ウィンドウサイズが変更されたときの処理
  $(window).resize(function() {
    handleNavigation($(window).width());
  });
  function handleNavigation(windowWidth) {
    if (windowWidth <= mobileBreakpoint) {
      // モバイル表示の処理
      $('.c-nav__list--head').off('click').on('click', function(){
        $(this).toggleClass('active');
        $(this).next('.c-nav__sub').slideToggle();
      });
    } else {
      // パソコン表示の処理
      $('.c-nav__list--head').removeClass('active'); // クラスを削除
      $('.c-nav__sub').removeAttr('style'); // inline styleを削除して表示に戻す
    }
  }
});

// スクロールするとロゴの色変更
$(function () {
  $(window).on("scroll", function () {
    const sliderHeight = $(".c-page-header").height();
    if (sliderHeight - 30 < $(this).scrollTop()) {
      $(".st-header").addClass("changeColor");
    } else {
      $(".st-header").removeClass("changeColor");
    }
  });
});

//**************************************
// 4bnr
//**************************************

$(document).ready(function() {
  var $button = $('#c-float');
  var hdrHeight = $('#inc-hd').outerHeight();
  var absoluteHeight = $('#c-btbnr').outerHeight(); 
  var btmHeight = $('#inc-ft').outerHeight(); + absoluteHeight;
  var mobileBreakpoint = 768;
  
  // スクロールイベントを監視
  $(window).on('scroll', function() {
    var scrollTop = $(window).scrollTop();
    var windowHeight = $(window).outerHeight();
    var documentHeight = $(document).outerHeight();
    var scrollBottom = documentHeight - (scrollTop + windowHeight);
    var windowWidth = $(window).width();
    
    // スクロール位置がhdrHeightを超えたらボタンを表示
    if (scrollTop > hdrHeight) {
      $button.fadeIn(300); // ふわっと表示
    } else {
      $button.fadeOut(300); // ふわっと非表示
    }

  });

  // ボタンをクリックしたらページトップへスクロール PAGE TOPクリックでスクロール（←クリック対象を限定）
  $('#c-float .c-pagetop a').on('click', function() {
    $('html, body').animate({ scrollTop: 0 }, 'slow');
  });
  
  // 富士平原wetherをクリックしたときに上に行かないようにする
  $('.c-weather a').on('click', function(event) {
    event.preventDefault(); // ← これでデフォルトの「ページ上部に移動」動作を防止
    T.window_open('Awk8ddCfr2gLVrfkNslvIV34RUrlraHQ');
  });

});



//**************************************
// grovalnavi
//**************************************
function setMenuBurger() {

  var $burger = $(".js-menu"),
    $nav = $(".c-nav"),
    $wrapper = $(".st-wrapper"),
    current_scroll_y; //\*

  function NAV_OPEN() {
    $nav.addClass('is-open');
    $nav.fadeIn();
    $('.st-header').addClass('is-open');
  }

  function NAV_CLOSE() {
    $nav.removeClass('is-open');
    $nav.fadeOut();
    $('.st-header').removeClass('is-open');

    setTimeout(function () {
      $('.st-header').removeClass('is-hide');
      $('.st-header').addClass('is-show');
    }, 100);
  }

  $burger.on("click", function (event) {
    event.preventDefault();

    if ($('.js-search').hasClass('is-active')) {
      $('.js-search').removeClass('is-active');
      $('.st-header__search-area').slideUp();
    }

    $(this).toggleClass("is-open");

    current_scroll_y = $(window).scrollTop();

    if ($(this).hasClass("is-open")) {
      $nav.stop().fadeIn();
      $burger.removeClass("is-close");
      NAV_OPEN();
    } else {
      $nav.stop().fadeOut();
      $burger.addClass("is-close");
      NAV_CLOSE();
    }
  });
}

$(function () {
  setMenuBurger();
});

//**************************************
// smooth scroll
//**************************************
function anchorScroll() {
  // ページ内リンクおよび同一ページの絶対パスに対してスクロールを制御
  $('a[href*="#"]:not(a.js-modal):not(.js-modal__close)').on('click', function (e) {
    // リンクのhref属性を取得
    var href = $(this).attr('href');
    var currentPath = window.location.pathname; // 現在のパス
    var linkPath = $(this).attr('href').split('#')[0]; // リンクのパス（ハッシュ以外の部分）

    // リンクが同じページ内のものか確認する
    if (linkPath === "" || linkPath === currentPath) {
      e.preventDefault(); // デフォルトの動作を無効にする
      var speed = 600;
      var targetId = href.split('#')[1]; // ハッシュ部分を取得
      var target = $('#' + targetId); // IDを持つ要素を取得

      // 画面幅に応じてスクロール位置を調整
      var scrollTop = $(window).width() <= 768 
                      ? target.offset().top - 60  // レスポンシブ時（768px以下）
                      : target.offset().top - 100; // 通常時

      // スムーズにスクロール
      $('body,html').animate({
        scrollTop: scrollTop
      }, speed, 'swing');
    }
  });
}

function scrollToHash() {
  // URLにハッシュが含まれている場合
  if (window.location.hash) {
    var target = $(window.location.hash);
    if (target.length) {
      var speed = 600;

      // 画面幅に応じてスクロール位置を調整
      var scrollTop = $(window).width() <= 768 
                      ? target.offset().top - 60  // レスポンシブ時（768px以下）
                      : target.offset().top - 100; // 通常時

      // アニメーションでスクロール
      $('body,html').animate({
        scrollTop: scrollTop
      }, speed, 'swing');
    }
  }
}

$(function () {
  anchorScroll();  // ページ内リンク用の処理
  scrollToHash();  // 別ページから遷移してきた場合の処理
});

//**************************************
// contact form
//**************************************
$(function () {
  $(".checkboxbtn").prop('checked', false);
  $('.checkboxbtn').click(function () {
    var check_count = $('.checkbox-area :checked').length;
    if (check_count == 1) {
      $(".formbtn").removeAttr("disabled");
      $(".formbtn").addClass("active");
    } else {
      $(".formbtn").attr("disabled", "disabled");
      $(".formbtn").removeClass("active");
    }
  })
});


document.addEventListener('DOMContentLoaded', function() {
  const fadeInElements = document.querySelectorAll('.fade-in');

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('show');
        observer.unobserve(entry.target); // 一度アニメーションしたら監視を停止
      }
    });
  }, { threshold: 0.5 }); // 50%が表示された時に発火

  fadeInElements.forEach(element => {
    observer.observe(element);
  });
});


$(document).ready(function() {
  $('.read-more-btn').click(function() {
    // 「続きを読む」部分をslideToggleで表示/非表示
    $('.more-content').slideToggle(600);
    $('.read-more-btn--wrap').toggleClass('active');
    // ボタンのテキストを切り替え
    if ($(this).text() === "続きを読む") {
      $(this).text("閉じる");
    } else {
      $(this).text("続きを読む");
    }
  });
});

/** ======================================================
 * 画像切り替え
 * ==================================================== */
var BREAK_POINT = 767;
function ImgSwitch() {
  var $img = $('.js-img-switch'),
    sp = '_sp.',
    pc = '_pc.';

  function imgChange() {
    var WINDOW_WIDTH = window.innerWidth;

    $img.each(function() {
      var $this = $(this);
      if (WINDOW_WIDTH < BREAK_POINT) {
        $this.attr('src', $this.attr('src').replace(pc, sp));
      } else {
        $this.attr('src', $this.attr('src').replace(sp, pc));
      }
    });
  }

  imgChange();

  // リサイズ処理
  var timer;
  $(window).on('resize', function() {
    clearTimeout(timer);
    timer = setTimeout(function() {
      imgChange();
    }, 200);
  });
}

$(function () {
  ImgSwitch();
});


document.addEventListener('DOMContentLoaded', function() {
  // 1. 取得したい要素をセレクタで取得
  var header    = document.getElementById('inc-hd');             // <header id="inc-hd" …>
  var logo      = header.querySelector('.c-header__logo');       // ロゴ部分
  var nav       = header.querySelector('.c-header__nav');        // ナビ（UL）
  var keyVisual = document.querySelector('.top_mv');             // キービジュアル全体を囲む要素 (.top_mv)

  // 取得できなかった場合は処理をやめる
  if (!header || !logo || !nav || !keyVisual) {
    return;
  }

  // 2. 事前にロゴの高さを取得しておく（px単位）
  var logoHeight = logo.offsetHeight;

  // 3. キービジュアルの「下端 (bottom)」の位置を計算
  //    offsetTop が要素の上端がドキュメント上で何pxかを返す
  //    offsetHeight が要素の高さ
  var keyVisualBottom = keyVisual.offsetTop + keyVisual.offsetHeight;

  // 4. スクロール時の処理
  function onScroll() {
    var scrollY = window.scrollY || window.pageYOffset;

    // PC表示判定：ここでは幅768px以上を「PC」として扱う例
    if (window.innerWidth >= 768) {
      // 「キービジュアルの下端を通り過ぎたか？」をチェック
      if (scrollY > keyVisualBottom) {
        if (!header.classList.contains('scrolled')) {
          // .scrolled を付与してロゴを隠し、ナビを上に詰める
          header.classList.add('scrolled');

          // --- (A) ロゴをフェードアウトかつ高さを 0 にする ---
          logo.style.maxHeight = logoHeight + 'px';  // ① 現在の高さを max-height にセット
          logo.offsetHeight;                         // ② 強制再描画
          logo.style.maxHeight = '0';                // ③ max-height:0 にする
          logo.style.opacity   = '0';                // ④ 不透明度も 0 に

          // --- (B) ナビを「画面上端から30px下」に配置する ---
          //    もともとロゴがある分だけ nav は下にいるので、
          //    最終的に上端から30px下にしたければ「ロゴの高さ − 30」を詰める。
          var moveY = logoHeight - 30;
          nav.style.transform = 'translateY(-' + moveY + 'px)';
        }
      } else {
        // キービジュアル範囲内に戻ったときは初期状態に戻す
        if (header.classList.contains('scrolled')) {
          header.classList.remove('scrolled');
          logo.style.maxHeight = '';
          logo.style.opacity   = '';
          nav.style.transform  = '';
        }
      }
    } else {
      // 幅768px未満（スマホ／タブレット）は常に初期状態に戻す
      if (header.classList.contains('scrolled')) {
        header.classList.remove('scrolled');
        logo.style.maxHeight = '';
        logo.style.opacity   = '';
        nav.style.transform  = '';
      }
    }
  }

  // 5. イベントリスナーを登録
  window.addEventListener('scroll', onScroll);

  // 6. リサイズ時にもリセット＆キービジュアル位置を再計算
  window.addEventListener('resize', function() {
    if (window.innerWidth < 768 && header.classList.contains('scrolled')) {
      header.classList.remove('scrolled');
      logo.style.maxHeight = '';
      logo.style.opacity   = '';
      nav.style.transform  = '';
    }
    // キービジュアルの位置・高さが変わる可能性があるため再計算
    keyVisualBottom = keyVisual.offsetTop + keyVisual.offsetHeight;
  });
});

