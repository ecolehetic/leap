<?php
class App_controller{
    
  function page(){
    
    $slug=F3::get('PARAMS.slug');
    
    $app=new App();
    $menu=$app->getMenu();
    F3::set('menu',$menu);
    //F3::set('menu',App::instance()->getMenu());
    
    $page=$app->getPage($slug);
    if(!$page){
      F3::error(404);
      return;
    }
    F3::set('page',$page);
    /*if(!$page=App::instance()->getPage(F3::get('PARAMS.slug'))){
      F3::error(404);
      return;
    }
    F3::set('page',$page);*/
    
    
    $content=$app->getContent($page->id);
    F3::set('content',$content);
    //F3::set('content',App::instance()->getContent($page->id));
    
    
    $page=$app->getPage($slug);
    if(!$page){
      F3::error(404);
      return;
    }
    F3::set('page',$page);
    
    $content=$app->getContent($page->id);
    F3::set('content',$content);
    
    
    $views=new Views();
    echo $views->render('layout.html');
    //echo Views::instance()->render(F3::get('PARAMS.slug').'.html');
    
  }

}

?>