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

 $('#main_visual .catchphrase,#main_visual .catchphrase2').addClass('show');

 $('.hamburgerMenu .MenuButton').click(function(){
  $('.hamburgerMenu .MenuButton,.hamburgerMenu .Menu').toggleClass('show');
 });

 $('.hamburgerMenu .Menu > ul span').eq(0).click(function(){
  $('.hamburgerMenu .Menu > ul span + ul').eq(0).toggleClass('show');
 });
 $('.hamburgerMenu .Menu > ul span').eq(1).click(function(){
  $('.hamburgerMenu .Menu > ul span + ul').eq(1).toggleClass('show');
 });
 $('.hamburgerMenu .Menu > ul span').eq(2).click(function(){
  $('.hamburgerMenu .Menu > ul span + ul').eq(2).toggleClass('show');
 });
 $('.hamburgerMenu .Menu > ul span').eq(3).click(function(){
  $('.hamburgerMenu .Menu > ul span + ul').eq(3).toggleClass('show');
 });
 $('.hamburgerMenu .Menu > ul span').eq(4).click(function(){
  $('.hamburgerMenu .Menu > ul span + ul').eq(4).toggleClass('show');
 });
 $('.hamburgerMenu .Menu > ul span').eq(5).click(function(){
  $('.hamburgerMenu .Menu > ul span + ul').eq(5).toggleClass('show');
 });
 $('.hamburgerMenu .Menu > ul span').eq(6).click(function(){
  $('.hamburgerMenu .Menu > ul span + ul').eq(6).toggleClass('show');
 });
 $('.hamburgerMenu .Menu > ul span').eq(7).click(function(){
  $('.hamburgerMenu .Menu > ul span + ul').eq(7).toggleClass('show');
 });
 $('.hamburgerMenu .Menu > ul span').eq(8).click(function(){
  $('.hamburgerMenu .Menu > ul span + ul').eq(8).toggleClass('show');
 });
 $('.hamburgerMenu .Menu > ul span').eq(9).click(function(){
  $('.hamburgerMenu .Menu > ul span + ul').eq(9).toggleClass('show');
 });

 $('#eventInner .flex').slick({
  autoplay: true, // 自動再生
  autoplaySpeed: 6000, // 自動再生時の次にスライドするまでの時間(初期値：3000)
  infinite: true, //スライドのループ
  speed: 600, // スライダーの動く速さ(初期値：300)
  dots: true, // スライダー下部に表示されるページネーション
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
  var features = document.querySelector('#features h2');
  var ft_left = document.querySelector('.ft_left');
  var ft_center = document.querySelector('.ft_center');
  var ft_right = document.querySelector('.ft_right');
  var academic = document.getElementById('academic');
  var science = document.querySelector('.science');
  var international = document.querySelector('.international');
  var literature = document.querySelector('.literature');
  var medical = document.querySelector('.medical');
  var academic_view_btn = document.querySelector('#academic .view_btn');
  var news = document.getElementById('news');
  var event = document.getElementById('event');
  var media = document.getElementById('media');
  var contact = document.getElementById('contact');
  var show_arr = new Array(features,ft_left,ft_center,ft_right,academic,science,international,literature,medical,academic_view_btn,news,event,media,contact);
  var trigger = 100;
  for(var i = 0; i < show_arr.length; i++){
   if(window.innerHeight > show_arr[i].getBoundingClientRect().top + trigger){
    show_arr[i].classList.add('show');
   }
  }
 });
});
