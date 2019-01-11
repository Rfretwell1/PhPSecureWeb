<?php

/* layout.html.twig */
class __TwigTemplate_aea026f8141c27eb2c7434a42bd4877d52a26303964a22041fc2876498e37479 extends Twig_Template
{
    private $source;

    /**
     * __TwigTemplate_aea026f8141c27eb2c7434a42bd4877d52a26303964a22041fc2876498e37479 constructor.
     * @param Twig_Environment $env providing the title and content value that is constructed
     */
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    /**
     * call a procedure that defines a parameter array
     * @param array $context - array of parameters
     * @param array $blocks -
     * @throws Twig_Error - declares the error thrown by the function or the method
     * @throws Twig_Error_Runtime - declares the error run time that can be thrown by function or method
     */
    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=”en\">
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>
    <link rel=\"stylesheet\" href=\"";
        // line 5
        echo twig_escape_filter($this->env, ($context["css_path"] ?? null), "html", null, true);
        echo "\" type=\"text/css\"/>
    <title>";
        // line 6
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
</head>
<body>
";
        // line 9
        $this->displayBlock('content', $context, $blocks);
        // line 10
        echo "</body>
</html>
";
    }

    // line 6
    public function block_title($context, array $blocks = array())
    {
    }

    // line 9
    public function block_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  54 => 9,  49 => 6,  43 => 10,  41 => 9,  35 => 6,  31 => 5,  25 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "layout.html.twig", "/p3t/phpappfolder/includes/coursework/app/templates/layout.html.twig");
    }
}
