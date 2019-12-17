<?php
/* ******************************************************************* *\
    Defines and includes all necessary MVC files
    base on url parameters and form values.
\* ******************************************************************* */

class Router extends Config
{
  public static $page = array('name' => 'home',
                              'controller' => 'CHome.php',
                              'view' => 'VHome.php'
                              );

  /* ******************************************************** *\
      INCLUDE_MVC_FILES:
      Gets expected files and includes them.
  \* ******************************************************** */

  public static function include_mvc_files($GET_array, $POST_array, $output)
  {
    self::define_page_elements($GET_array, $POST_array);
    self::check_session_rights();
    self::include_models();
    self::include_controller($output);
  }

  /* ******************************************************** *\
      DEFINE_PAGE_ELEMENTS:
      Defines the expected output page.
  \* ******************************************************** */

  private static function define_page_elements($GET_array, $POST_array)
  {
    // Sanitizes the url input.
    $url_params = filter_var_array($GET_array, FILTER_SANITIZE_URL);

    // Sets the elements/files of the expected page (default is Home).
    if (isset($url_params['cat']))
    {
      self::$page['name'] = strtolower($url_params['cat']);
      self::$page['controller'] = 'C'.ucfirst(self::$page['name']).'.php';
      self::$page['view'] = 'V'.ucfirst(self::$page['name']).'.php';
    }

    // Sets the proper full paths for the page's url and files.
    self::$page['controller'] = Config::CONTROLLERS_PATH.self::$page['controller'];
    self::$page['view'] = Config::VIEWS_PATH.self::$page['view'];
  }

  /* ******************************************************** *\
      CHECK_SESSION_RIGHTS:
      Defines whether the (non-)logged user can access the
      requested page. If not, redirects to home.
  \* ******************************************************** */

  private static function check_session_rights()
  {
    $page = self::$page['name'];
    $common_area = array('home');
    $visitors_only = array('register', 'login', 'reset');
    $members_only = array('search', 'chatroom', 'chat', 'chatmessage', 'actions',
                          'profile', 'logout', 'modify-account', 'modify-profile', 'modify-pictures', 'modify-mate');

    if (!in_array($page, $common_area) &&
        !(in_array($page, $visitors_only) && !$_SESSION['is_logged']) &&
        !(in_array($page, $members_only) && $_SESSION['is_logged']))
      header('Location: '.Config::ROOT.'');
  }

  /* ******************************************************** *\
      INCLUDE_MODELS:
      Auto-loads all necessary models.
  \* ******************************************************** */

  private static function include_models()
  {
    spl_autoload_register(function($className)
    {
      require_once(Config::MODELS_PATH.$className.'.class.php');
    });
  }

  /* ******************************************************** *\
      INCLUDE_CONTROLLER:
      Sets the <main id="name"> for page-specific css
      and includes the expected controller.
  \* ******************************************************** */

  private static function include_controller($output)
  {
    if (file_exists(self::$page['controller']))
    {
      $output->set_page_name(self::$page['name']);
      require_once(self::$page['controller']);
    }
    else
      header('Location: '.Config::ROOT.'');
  }
}
