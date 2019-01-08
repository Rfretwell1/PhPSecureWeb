<?php

/* register.html.twig */
class __TwigTemplate_b6088bbdd0a6ea563251abe4858d49f29e60d200d797a02eb0db45a7ba9f1ad0 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("layout.html.twig", "register.html.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
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
    public function block_title($context, array $blocks = array())
    {
        echo twig_escape_filter($this->env, ($context["page_title"] ?? null), "html", null, true);
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "    <div id=\"page-content-div\">
        <p>Registration</p>
        <form action=\"";
        // line 6
        echo twig_escape_filter($this->env, ($context["registrationsubmit"] ?? null), "html", null, true);
        echo "\" method=\"post\">
            <fieldset>
                <legend>Registration</legend>
                <br>

                <label for=\"username\">Username:</label>
                <input id=\"username\" name=\"username\" type=\"text\" value=\"";
        // line 12
        echo twig_escape_filter($this->env, ($context["initial_input_box_value"] ?? null), "html", null, true);
        echo "\" size=\"30\" maxlength=\"50\">
                <br><br>

                <label for=\"password\">Password:</label>
                <input id=\"password\" name=\"password\" type=\"password\" value=\"";
        // line 16
        echo twig_escape_filter($this->env, ($context["initial_input_box_value"] ?? null), "html", null, true);
        echo "\" size=\"30\" maxlength=\"50\">
                <br>
                <p style=\"color: red\">";
        // line 18
        echo twig_escape_filter($this->env, ($context["useralreadyexists"] ?? null), "html", null, true);
        echo "</p>
                <input type=\"submit\" value=\"Register >>>\"><br>
            </fieldset>

        </form>
    </div>
";
    }

    public function getTemplateName()
    {
        return "register.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  67 => 18,  62 => 16,  55 => 12,  46 => 6,  42 => 4,  39 => 3,  33 => 2,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "register.html.twig", "H:\\p3t\\phpappfolder\\includes\\coursework\\app\\templates\\register.html.twig");
    }
}
