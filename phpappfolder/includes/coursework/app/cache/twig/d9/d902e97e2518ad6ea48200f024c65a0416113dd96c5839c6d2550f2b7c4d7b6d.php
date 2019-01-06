<?php

/* display_registration_result.html.twig */
class __TwigTemplate_5b60de6febb52cf87c36d187904d59ee2ca08dbb831cda3d44f4fdcdd7c537f3 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("layout.html.twig", "display_registration_result.html.twig", 1);
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
        echo twig_escape_filter($this->env, ($context["username"] ?? null), "html", null, true);
        echo " </br>
        Password: ";
        // line 6
        echo twig_escape_filter($this->env, ($context["password"] ?? null), "html", null, true);
        echo "
    </div>
";
    }

    public function getTemplateName()
    {
        return "display_registration_result.html.twig";
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
        return new Twig_Source("", "display_registration_result.html.twig", "/p3t/phpappfolder/includes/coursework/app/templates/display_registration_result.html.twig");
    }
}
