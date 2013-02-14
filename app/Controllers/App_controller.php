<?php
class App_controller{
    
  function page(){
    
    if(!$page=App::instance()->page(F3::get('PARAMS.slug'))){
      F3::error(404);
      return;
    }
    
    F3::set('page',$page);
    
    F3::set('content',App::instance()->content($page->id));
    
    if(F3::get('AJAX')){
      echo Views::instance()->render('partials/'.F3::get('PARAMS.slug').'.html');
      return;
    }
    
    F3::set('menu',App::instance()->menu());
    
    echo Views::instance()->render('layout.html');  
  }
  

}

?>
