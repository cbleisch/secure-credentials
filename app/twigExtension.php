<?php namespace SecureCredentials\TwigExtension;
class WordpressTemplateExtension extends \Twig_Extension{



public function getFunctions()
{
    return array(
            'header' => new \Twig_Function_Method($this, 'header'),
            'footer' => new \Twig_Function_Method($this, 'footer'),
            'sidebar' => new \Twig_Function_Method($this, 'sidebar')
    );
}

public function header($string = null)
{   
    return get_header( $string );

}

public function footer($string = null)
{
    return get_footer( $string );
}

public function sidebar($string = null)
{
    return get_sidebar( $string );
}

public function getName()
{
    return 'template';
}
}

