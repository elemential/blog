


    
    for (i=1;i<document.getElementsByTagName("h1").length;i++)
     {
        a=document.getElementsByClassName("poszt")[i-1].getElementsByClassName("szerzo")[0].innerHTML.slice(0,1).toUpperCase();  
        document.getElementsByTagName("h1")[i].innerHTML="<a class='sbox' href='#poszt_"+i+"'>"+a+"</a>"+document.getElementsByTagName("h1")[i].innerHTML;
          document.getElementsByTagName("h1")[i].id="poszt_"+i;
    }
    
    var topos = $('h1 a').position();
		$(window).scroll(function () {
		  if ($(window).scrollTop() > topos.top) {
			  $("header img").removeClass("off");
			} else {
			   $("header img").addClass("off");
			}
		}); 
    
    $("img[src='up.png']").click(function() {
      $("html, body").animate({ scrollTop: 0 }, "normal");
      return false;
    });
    
     $("#tartalomKontener article").mouseenter(function() {
            console.log('-');
      $('#fejlecKontener').removeClass('ext');
      $('#oldalsav').removeClass('ext');
    });
       
    $("img[src='profile_icon.png']").click(function() {
      $('#fejlecKontener').addClass('ext');
      $('#oldalsav').addClass('ext');
    });
    
       
    
    $('#oldalsav').css('right',$('#tartalomKontener').css("marginLeft"));
    
    onresize = function() {
     $('#oldalsav').css('right',$('#tartalomKontener').css("marginLeft"));
    }
    
    if (location.search=="?muvelet=uj_poszt") {
        document.getElementsByTagName("h1")[0].innerHTML+="<span style='opacity:.8'> új bejegyzés</span>";
        $('#newposzt').css('display','none');
        
        
    }
    
    
    
   
    acthovs=[];
    for (i=0;i<document.getElementsByClassName("sbox").length;i++)
    {
        acthovs[i]=$(document.getElementsByClassName('sbox')[i]).position().top ;
    }
    acthovs[acthovs.length]=Infinity;
    onscroll = function() {       
       if ($(window).scrollTop() > acthovs[0])
        {
         
            
          for (i=0;i<acthovs.length-1;i++) 
          {
             //console.log(i+'-'+acthovs[i]+'-'+$(window).scrollTop()+'-'+acthovs[i+1]);
              if ((acthovs[i] <= $(window).scrollTop()) && (acthovs[i+1] > $(window).scrollTop()))   
              {       
                 $(document.getElementsByClassName('sbox')[i]).addClass('on');                
              }             
              else {
                $(document.getElementsByClassName('sbox')[i]).removeClass('on');                 
              }
      
          }
            
        }
        else {
            $(document.getElementsByClassName('sbox')[0]).removeClass('on');         
        }
        
    }
    

        console.log('[BLOG] loaded');
    
           var $root = $('html, body');
        $('a').click(function() {
            var href = $.attr(this, 'href');
            $root.animate({
                scrollTop: $(href).offset().top-60
            }, 500, function () {
                window.location.hash = href;       
            });
            return false;
        });

   /* for (i=1;i<document.getElementsByClassName(").length;i++)
    {
        document.getElementsByName("article")
    }*/
    
    

    

		