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

 $('input,select').focus(function(){
  $(this).css({background:'#ffc'});
 }).blur(function(){
  $(this).css({background:''});
 });

 var year = document.getElementById('year');
 for(var i = 2020; i > 1900; i--){
  var optionY = document.createElement('option');
  optionY.innerHTML = i;
  year.appendChild(optionY);
 }

 var month = document.getElementById('month');
 for(var j = 1; j < 13; j++){
  var optionM = document.createElement('option');
  optionM.innerHTML = j;
  month.appendChild(optionM);
 }

 var day = document.getElementById('day');
 for(var k = 1; k < 32; k++){
  var optionD = document.createElement('option');
  optionD.innerHTML = k;
  day.appendChild(optionD);
 }

 var arr_pref = new Array('北海道','青森県','秋田県','岩手県','宮城県','山形県','福島県','茨城県','群馬県','栃木県','埼玉県','千葉県','東京都','神奈川県','新潟県','富山県','石川県','福井県','山梨県','長野県','岐阜県','静岡県','愛知県','三重県','滋賀県','京都府','大阪府','兵庫県','奈良県','和歌山県','鳥取県','島根県','岡山県','広島県','山口県','徳島県','香川県','愛媛県','高知県','福岡県','佐賀県','長崎県','熊本県','大分県','宮崎県','鹿児島県','沖縄県');
 var prefecture = document.getElementById('prefecture');
 for(var l = 0; l < arr_pref.length; l++){
  var optionP = document.createElement('option');
  optionP.innerHTML = arr_pref[l];
  prefecture.appendChild(optionP);
 }
});
