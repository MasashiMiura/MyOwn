window.addEventListener('load',function(){
  document.querySelector('#main_visual div').style.transform = 'scale(1)';
  document.querySelector('#main_visual div p').style.transform = 'scale(1)';

  document.getElementById('rsv_btn').addEventListener('click',function(){
    document.getElementById('search').style.transform = 'translateY(0)';
    document.querySelector('header .inner').style.display = 'none';
  });

  var chk = document.getElementById('chk');
  chk.addEventListener('change',function(e){
    if(e.target.checked){
      document.getElementsByTagName('input')[0].setAttribute('disabled','disabled');
    }
    else{
      document.getElementsByTagName('input')[0].removeAttribute('disabled');
    }
  });

  document.getElementById('close').addEventListener('click',function(){
    document.getElementById('search').style.transform = 'translateY(-100%)';
    document.querySelector('header .inner').style.display = 'flex';
  });

  window.addEventListener('scroll',function(){
    var header = document.querySelector('header .inner');
    var main_visual = document.getElementById('main_visual');
    if(header.getBoundingClientRect().bottom > main_visual.getBoundingClientRect().top){
      header.style.backgroundColor = 'rgba(0,0,0,0.7)';
    }
    else{
      header.style.backgroundColor = '';
    }
    var toTop = document.getElementById('ToTop');
    if(toTop.getBoundingClientRect().bottom > main_visual.getBoundingClientRect().bottom){
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

    var main_h2 = document.querySelector('main > h2');
    var main_p1 = document.querySelector('main > p:nth-of-type(1)');
    var main_p2 = document.querySelector('main > p:nth-of-type(2)');
    var irori_h3 = document.querySelector('#irori h3');
    var irori_p = document.querySelector('#irori .sentence p');
    var cafe_h3 = document.querySelector('#cafe h3');
    var cafe_p = document.querySelector('#cafe .sentence p');
    var appearance_h3 = document.querySelector('#appearance h3');
    var appearance_p = document.querySelector('#appearance .sentence p');
    var infomation_h3 = document.querySelector('#infomation h3');
    var infomation_table = document.querySelector('#infomation table');
    var move_arr = new Array(main_h2,main_p1,main_p2,irori_h3,irori_p,cafe_h3,cafe_p,appearance_h3,appearance_p,infomation_h3,infomation_table);
    for(var i = 0; i < move_arr.length; i++){
      if(window.innerHeight > move_arr[i].getBoundingClientRect().top){
        move_arr[i].style.transform = 'translateY(0)';
      }
    }
  });
});
