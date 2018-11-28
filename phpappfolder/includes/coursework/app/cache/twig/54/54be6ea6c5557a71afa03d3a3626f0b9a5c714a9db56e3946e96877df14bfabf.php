<?php

/* display_peeked_messages.html.twig */
class __TwigTemplate_e9e5ac9bc11c866ce584f2a554cd3b68f6c81e440b2f32fa4179f65d5fc71570 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("layout.html.twig", "display_peeked_messages.html.twig", 1);
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
        Peeked messages: ";
        // line 5
        echo twig_escape_filter($this->env, ($context["peeked_messages"] ?? null), "html", null, true);
        echo " </br>
    </div>
";
    }

    public function getTemplateName()
    {
        return "display_peeked_messages.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  42 => 5,  38 => 4,  35 => 3,  32 => 2,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "display_peeked_messages.html.twig", "/p3t/phpappfolder/includes/coursework/app/templates/display_peeked_messages.html.twig");
    }
}
