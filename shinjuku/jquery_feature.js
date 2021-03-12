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

 $(window).scroll(function(){
  var feature_title = document.querySelector('#featureInner2 h3:nth-of-type(1)');
  var feature_sentence = document.querySelector('#featureInner2 > p');
  var philosophy_title = document.querySelector('#featureInner2 h3:nth-of-type(2)');
  var philosophy = document.querySelector('#featureInner2 div:nth-of-type(1)');
  var greeting = document.querySelector('#featureInner2 div:nth-of-type(2)');
  var history_title = document.querySelector('#featureInner2 h3:nth-of-type(3)');
  var history = document.querySelector('#featureInner2 div:nth-of-type(3)');
  var show_arr = new Array(feature_title,feature_sentence,philosophy_title,philosophy,greeting,history_title,history);
  var trigger = 100;
  for(var i = 0; i < show_arr.length; i++){
   if(window.innerHeight > show_arr[i].getBoundingClientRect().top + trigger){
    show_arr[i].classList.add('show');
   }
  }
 });
});
