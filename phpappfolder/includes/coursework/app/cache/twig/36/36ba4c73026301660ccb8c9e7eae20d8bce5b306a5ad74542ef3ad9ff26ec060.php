<?php

/* home.html.twig */
class __TwigTemplate_fc56857d3d1cca4b3de58b9dab1beead589e85fd40531ea6027c9f1095b109db extends Twig_Template
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
        <p>EE M2M Connect Message Sender/Receiver</p>
        <form action=\"";
        // line 6
        echo twig_escape_filter($this->env, ($context["sendmessage"] ?? null), "html", null, true);
        echo "\" method=\"post\">
            <fieldset>
                <legend>Configure a virtual circuit board & send information on its state to the EE server.</legend>
                <br>

                <label for=\"switches\">Switches (on/off):</label>
                <input id=\"switch1\" name =\"switch1\" type=\"checkbox\" value=\"on\">
                <input id=\"switch2\" name =\"switch2\" type=\"checkbox\" value=\"on\">
                <input id=\"switch3\" name =\"switch3\" type=\"checkbox\" value=\"on\">
                <input id=\"switch4\" name =\"switch4\" type=\"checkbox\" value=\"on\">
                <br><br>


                <label for=\"fan\">Fan state:</label><br>
                <input id=\"fan\" name=\"fan\" type=\"radio\" value=\"fwd\" checked> Forward <br>
                <input id=\"fan\" name=\"fan\" type=\"radio\" value=\"rev\"> Reverse
                <br><br>

                <label for=\"heater\">Heater temperature (*C):</label>
                <input id=\"heater\" name=\"heater\" type=\"text\" value=\"";
        // line 25
        echo twig_escape_filter($this->env, ($context["initial_input_box_value"] ?? null), "html", null, true);
        echo "\" size=\"30\" maxlength=\"50\">
                <br><br>

                <label for=\"keypad\">Keypad value:</label>
                <input id=\"keypad\" name=\"keypad\" type=\"text\" value=\"";
        // line 29
        echo twig_escape_filter($this->env, ($context["initial_input_box_value"] ?? null), "html", null, true);
        echo "\" size=\"30\" maxlength=\"50\">
                <br><br>

                <input type=\"submit\" value=\"Send message >>>\"><br>
                <p>";
        // line 33
        echo twig_escape_filter($this->env, ($context["sentmessage"] ?? null), "html", null, true);
        echo "</p>
            </fieldset>
        </form>

        <form action=\"";
        // line 37
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
        return array (  89 => 37,  82 => 33,  75 => 29,  68 => 25,  46 => 6,  42 => 4,  39 => 3,  33 => 2,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "home.html.twig", "/p3t/phpappfolder/includes/coursework/app/templates/home.html.twig");
    }
}
