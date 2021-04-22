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
    var yama_h3 = document.querySelector('#yamaburo h3');
    var yama_p1 = document.querySelector('#yamaburo .sentence p:nth-of-type(1)');
    var yama_p2 = document.querySelector('#yamaburo .sentence p:nth-of-type(2)');
    var yama_p3 = document.querySelector('#yamaburo .sentence p:nth-of-type(3)');
    var kawa_h3 = document.querySelector('#kawaburo h3');
    var kawa_p1 = document.querySelector('#kawaburo .sentence p:nth-of-type(1)');
    var kawa_p2 = document.querySelector('#kawaburo .sentence p:nth-of-type(2)');
    var kawa_p3 = document.querySelector('#kawaburo .sentence p:nth-of-type(3)');
    var koya_h3 = document.querySelector('#koyaburo h3');
    var koya_p1 = document.querySelector('#koyaburo .sentence p:nth-of-type(1)');
    var koya_p2 = document.querySelector('#koyaburo .sentence p:nth-of-type(2)');
    var koya_p3 = document.querySelector('#koyaburo .sentence p:nth-of-type(3)');
    var quality = document.getElementById('quality');
    var efficacy = document.getElementById('efficacy');
    var day_trip_h3 = document.querySelector('#day_trip h3');
    var hr = document.getElementsByTagName('hr')[0];
    var day_trip_p1 = document.querySelector('#day_trip p:nth-of-type(1)');
    var day_trip_p2 = document.querySelector('#day_trip p:nth-of-type(2)');
    var day_trip_p3 = document.querySelector('#day_trip p:nth-of-type(3)');
    var day_trip_p4 = document.querySelector('#day_trip p:nth-of-type(4)');
    var move_arr = new Array(main_h2,main_p1,main_p2,yama_h3,yama_p1,yama_p2,yama_p3,kawa_h3,kawa_p1,kawa_p2,kawa_p3,koya_h3,koya_p1,koya_p2,koya_p3,quality,efficacy,day_trip_h3,hr,day_trip_p1,day_trip_p2,day_trip_p3,day_trip_p4);
    for(var i = 0; i < move_arr.length; i++){
      if(window.innerHeight > move_arr[i].getBoundingClientRect().top){
        move_arr[i].style.transform = 'translateY(0)';
      }
    }
  });
});
