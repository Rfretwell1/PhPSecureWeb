<?php

/* display_storage_result.html.twig */
class __TwigTemplate_2a934666b85ce7d6d652da2c3cd2700f00b682a9a9319d47eea14d57667f1025 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("layout.html.twig", "display_storage_result.html.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_content($context, array $blocks = array())
    {
        // line 3
        echo "    <div id=\"page-content-div\">
        <h4>";
        // line 4
        echo twig_escape_filter($this->env, ($context["storage_text"] ?? null), "html", null, true);
        echo "</h4>
        Username: ";
        // line 5
        echo twig_escape_filter($this->env, ($context["content"] ?? null), "html", null, true);
        echo " </br>
        Password: ";
        // line 6
        echo twig_escape_filter($this->env, ($context["metadata"] ?? null), "html", null, true);
        echo "
    </div>
";
    }

    public function getTemplateName()
    {
        return "display_storage_result.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  46 => 6,  42 => 5,  38 => 4,  35 => 3,  32 => 2,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "display_storage_result.html.twig", "/p3t/phpappfolder/includes/coursework/app/templates/display_storage_result.html.twig");
    }
}
