<?php
class App_controller{
    
  function page(){
    
    $slug=F3::get('PARAMS.slug');
    
    $app=new App();
    $menu=$app->getMenu();
    F3::set('menu',$menu);
    
    $page=$app->getPage($slug);
    if(!$page){
      F3::error(404);
      return;
    }
    F3::set('page',$page);
    
    $content=$app->getContent($page->id);
    F3::set('content',$content);
    
    
    $views=new Views();
    echo $views->render($slug.'.html');
    
  }

}

?>