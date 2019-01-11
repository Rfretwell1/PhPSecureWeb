<?php

/* home.html.twig */
class __TwigTemplate_261311e4ca7d960570616d683d1c309e4f41255dcd0027fc1c5053f1d4331f28 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("layout.html.twig", "home.html.twig", 1);
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
        <p>Very basic webpage</p>
        <form action=\"";
        // line 6
        echo twig_escape_filter($this->env, ($context["storeindatabase"] ?? null), "html", null, true);
        echo "\" method=\"post\">
            <fieldset>
                <legend>Store message in database</legend>
                <br>
                <label for=\"content\">Message content:</label>
                <input id=\"content\" name=\"content\" type=\"text\" value=\"";
        // line 11
        echo twig_escape_filter($this->env, ($context["initial_input_box_value"] ?? null), "html", null, true);
        echo "\" size=\"30\" maxlength=\"50\">
                <br><br>
                <label for=\"metadata\">Message metadata:</label>
                <input id=\"metadata\" name=\"metadata\" type=\"text\" value=\"";
        // line 14
        echo twig_escape_filter($this->env, ($context["initial_input_box_value"] ?? null), "html", null, true);
        echo "\" size=\"30\" maxlength=\"50\">
                <br><br>
                <input type=\"submit\" value=\"Store the information >>>\">
            </fieldset>
        </form>
        <form action=\"";
        // line 19
        echo twig_escape_filter($this->env, ($context["sendmessage"] ?? null), "html", null, true);
        echo "\" method=\"post\">
            <fieldset>
                <legend>Send an SMS message</legend>
                <br>
                <label for=\"number\">Phone number:</label>
                <input id=\"number\" name=\"number\" type=\"text\" value=\"";
        // line 24
        echo twig_escape_filter($this->env, ($context["initial_input_box_value"] ?? null), "html", null, true);
        echo "\" size=\"30\" maxlength=\"50\">
                <br><br>
                <label for=\"message\">Message:</label>
                <input id=\"message\" name=\"message\" type=\"text\" value=\"";
        // line 27
        echo twig_escape_filter($this->env, ($context["initial_input_box_value"] ?? null), "html", null, true);
        echo "\" size=\"30\" maxlength=\"50\">
                <br><br>
                <input type=\"submit\" value=\"Send the message >>>\">
            </fieldset>
        </form>
        <form action=\"";
        // line 32
        echo twig_escape_filter($this->env, ($context["peekmessages"] ?? null), "html", null, true);
        echo "\" method=\"post\">
            <fieldset>
                <legend>Peek the messages</legend>
                <input type=\"submit\" value=\"Peek >>>\">
            </fieldset>
        </form>
    </div>
";
    }

    public function getTemplateName()
    {
        return "home.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  90 => 32,  82 => 27,  76 => 24,  68 => 19,  60 => 14,  54 => 11,  46 => 6,  42 => 4,  39 => 3,  33 => 2,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "home.html.twig", "H:\\p3t\\phpappfolder\\includes\\coursework\\app\\templates\\home.html.twig");
    }
}
