$(function(){
 var topBtn = $('.scrollTop');
 topBtn.hide();
 $(window).scroll(function(){
  if($(this).scrollTop() > 100){
   topBtn.fadeIn();
  }
  else{
   topBtn.fadeOut();
  }
 });
 topBtn.click(function(){
  $('body,html').animate({
   scrollTop: 0
  },500);
  return false;
 });

 $('#main_visual .catchphrase').addClass('show');
 $('#main_visual .catchphrase2').addClass('show');

 var imgs = $(".slide img");
 var img_num = imgs.length;
 var count = 0;
 setInterval(changeVisual,6000);
 function changeVisual(){
  count = (count + 1) % img_num;
  imgs.removeClass("main_visual");
  imgs.eq(count).addClass("main_visual");
 }

 $('#news .flex').slick({
  autoplay: true, // 自動再生
  autoplaySpeed: 6000, // 自動再生時の次にスライドするまでの時間(初期値：3000)
  infinite: true, //スライドのループ
  speed: 600, // スライダーの動く速さ(初期値：300)
  <!--dots: true,--> // スライダー下部に表示されるページネーション
  arrows: false, //スライダー左右の矢印
  slidesToScroll: 1, // 動かす画像の数
  slidesToShow: 3, // 表示させる画像の数
  responsive: [{
   breakpoint: 768, // 768px以下で以降の設定に切り替え
   settings: {
    slidesToShow: 1,
   }
  }]
 });

 $(window).scroll(function(){
  var features = document.querySelector('#features h1');
  var ft_left = document.querySelector('.ft_left');
  var ft_center = document.querySelector('.ft_center');
  var ft_right = document.querySelector('.ft_right');
  var academic = document.getElementById('academic');
  var science = document.querySelector('.science');
  var international = document.querySelector('.international');
  var literature = document.querySelector('.literature');
  var medical = document.querySelector('.medical');
  var depa_ichiran_btn = document.querySelector('.depa_ichiran_btn');
  var news = document.getElementById('news');
  var event = document.getElementById('event');
  var media = document.getElementById('media');
  var contact = document.getElementById('contact');
  var show_arr = new Array(features,ft_left,ft_center,ft_right,academic,science,international,literature,medical,depa_ichiran_btn,news,event,media,contact);
  var trigger = 100;
  for(var i = 0; i < show_arr.length; i++){
   if(window.innerHeight > show_arr[i].getBoundingClientRect().top + trigger){
    show_arr[i].classList.add('show');
   }
  }
 });
});
