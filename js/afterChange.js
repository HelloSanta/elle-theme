jQuery(function(){

  var 
    $slide      = jQuery('.article-slick-area .view-content'),
    basePath    = '',
    currentPage = 0,
    pageRex     = /page-node-page(\d*)/g,
    pageMatch   = pageRex.exec( jQuery('body').attr('class') );
  
  var countPV = function()
  {
      if( typeof ga === 'function' ){
        window._atrk_fired = false;
        ga('send', 'pageview', {'page': location.href.replace(/http:\/\/(www|stg)\.elle\.com\.tw/g, '') });
        jQuery.get('/sites/default/external/comscore.php', function(){
          jQuery.getScript("http://b.scorecardresearch.com/b?c1=2&c2=13016544&c8="+encodeURI(document.title)+"&c7="+document.URL+"&c9="+document.referrer);
        });
        window.atrk();
      }else{
        console.log('tracing send ' + location.href.replace('http://www.elle.com.tw', '') );
      }
  };

  // slick init
  $slide.slick({
    prevArrow: '<button type="button" class="slide-prev" style="display: block; position: absolute; top: 130px; left: 0; z-index: 10; color: #555; width: 30px; height: 60px; opacity: 0.5;">&lt;</button>',
    nextArrow: '<button type="button" class="slide-next" style="display: block; position: absolute; top: 130px; right: 0; z-index: 10; color: #555; width: 30px; height: 60px; opacity: 0.5;">&gt;</button>',
    adaptiveHeight: true
  });

  // get current page
  if(pageMatch)
  {
    currentPage = parseInt(pageMatch[1]) - 1;
    $slide.slick('slickGoTo', currentPage);
  }
  else
  {
    currentPage = 0;
  }

  if( currentPage === 0 )
  {
    basePath = location.pathname; 
  }
  else
  {
    basePath = location.pathname.substr(0, location.pathname.lastIndexOf('/'));
  }


  $slide.on('afterChange', function(slick, currentSlide)
  {

    var path    = '';
    currentPage = currentSlide.currentSlide;

    switch( currentPage )
    {
      case 0:
        path = basePath;
      break;
      default :
        path = basePath + '/page' + (currentPage + 1);
      break;
    }

    if(window.history.pushState){
      window.history.pushState( null, document.title, path );
      countPV();
    }
  });
  
});