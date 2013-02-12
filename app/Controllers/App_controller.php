<?php
class App_controller{
    
  function page(){
    $slug=F3::get('PARAMS.slug');mlqksdjfmqlsdkjf
    
    F3::set('menu',App::instance()->menu());
    
    $page=App::instance()->page($slug); 
    F3::set('page',$page);
    
    F3::set('content',App::instance()->content($page->id));
    
    echo Views::instance()->render('layout.html');  
  }
  

}

?>
