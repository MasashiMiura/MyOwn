window.addEventListener('load',function(){
  var toTop = document.querySelector('.scrollTop');
  toTop.style.visibility = 'hidden';
  window.addEventListener('scroll',function(){
   var section = document.getElementsByTagName('section')[0];
   var toTop = document.querySelector('.scrollTop');
   if(window.innerHeight > section.getBoundingClientRect().top - 100){
    toTop.style.visibility = 'visible';
   }
   else{
    toTop.style.visibility = 'hidden';
   }
   toTop.addEventListener('click',function(){
    window.scroll({
     top:0,
     behavior:'smooth'
    });
   });
  });

 var catchphrase = document.querySelector('#main_visual .slide .catchphrase');
 var catchphrase2 = document.querySelector('#main_visual .slide .catchphrase2');
 catchphrase.classList.add('show');
 catchphrase2.classList.add('show');

 document.querySelector('.hamburgerMenu .MenuButton').addEventListener('click',function(){
  document.querySelector('.hamburgerMenu .MenuButton').classList.toggle('show');
  document.querySelector('.hamburgerMenu .Menu').classList.toggle('show');
 });

 document.getElementsByClassName('deployment')[0].addEventListener('click',function(){
  document.getElementsByClassName('departmentOpen')[0].classList.toggle('show');
 });
 document.getElementsByClassName('deployment')[1].addEventListener('click',function(){
  document.getElementsByClassName('departmentOpen')[1].classList.toggle('show');
 });
 document.getElementsByClassName('deployment')[2].addEventListener('click',function(){
  document.getElementsByClassName('departmentOpen')[2].classList.toggle('show');
 });
 document.getElementsByClassName('deployment')[3].addEventListener('click',function(){
  document.getElementsByClassName('departmentOpen')[3].classList.toggle('show');
 });
 document.getElementsByClassName('deployment')[4].addEventListener('click',function(){
  document.getElementsByClassName('departmentOpen')[4].classList.toggle('show');
 });
 document.getElementsByClassName('deployment')[5].addEventListener('click',function(){
  document.getElementsByClassName('departmentOpen')[5].classList.toggle('show');
 });
 document.getElementsByClassName('deployment')[6].addEventListener('click',function(){
  document.getElementsByClassName('departmentOpen')[6].classList.toggle('show');
 });
 document.getElementsByClassName('deployment')[7].addEventListener('click',function(){
  document.getElementsByClassName('departmentOpen')[7].classList.toggle('show');
 });
 document.getElementsByClassName('deployment')[8].addEventListener('click',function(){
  document.getElementsByClassName('departmentOpen')[8].classList.toggle('show');
 });
 document.getElementsByClassName('deployment')[9].addEventListener('click',function(){
  document.getElementsByClassName('departmentOpen')[9].classList.toggle('show');
 });

 window.addEventListener('scroll',function(){
  var features = document.querySelector('#features h1');
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
