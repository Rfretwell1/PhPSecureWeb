<?php

/* display_sent_message.html.twig */
class __TwigTemplate_0eb9bdbdda9bd7adcdc1d512f81c9f2ea058431c2c918ae85a6e76a2b5a30b16 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("layout.html.twig", "display_sent_message.html.twig", 1);
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
        Switches: ";
        // line 5
        echo twig_escape_filter($this->env, ($context["switches"] ?? null), "html", null, true);
        echo " </br>
        Fan: ";
        // line 6
        echo twig_escape_filter($this->env, ($context["fan"] ?? null), "html", null, true);
        echo "</br>
        Heater temperature: ";
        // line 7
        echo twig_escape_filter($this->env, ($context["heater"] ?? null), "html", null, true);
        echo "</br>
        Keypad: ";
        // line 8
        echo twig_escape_filter($this->env, ($context["keypad"] ?? null), "html", null, true);
        echo "
    </div>
";
    }

    public function getTemplateName()
    {
        return "display_sent_message.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  54 => 8,  50 => 7,  46 => 6,  42 => 5,  38 => 4,  35 => 3,  32 => 2,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "display_sent_message.html.twig", "/p3t/phpappfolder/includes/coursework/app/templates/display_sent_message.html.twig");
    }
}
