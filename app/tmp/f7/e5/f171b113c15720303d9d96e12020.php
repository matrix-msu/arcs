<?php

/* Pages/home.tpl */
class __TwigTemplate_f7e5f171b113c15720303d9d96e12020 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"search-home search-wrapper\"></div>

<div class=\"accordion-wrapper\">

  ";
        // line 5
        if (isset($context["user"])) { $_user_ = $context["user"]; } else { $_user_ = null; }
        if ((!$this->getAttribute($_user_, "loggedIn"))) {
            // line 6
            echo "  <div style=\"font-weight:200\">
    <i class=\"icon-info-sign\"></i>
    You're viewing publicly available resources. 
    You'll need to ";
            // line 9
            if (isset($context["html"])) { $_html_ = $context["html"]; } else { $_html_ = null; }
            echo $this->getAttribute($_html_, "link", array(0 => "login", 1 => "/login"), "method");
            echo " to see the rest.
  </div>
  ";
        }
        // line 12
        echo "
  <details class=\"unselectable\" open=\"open\" data-type=\"Notebook\">
    <summary class=\"large\">Notebooks</summary>
    <div></div>
  </details>

  <details class=\"unselectable\" data-type=\"Notebook Page\">
    <summary class=\"large\">Notebook Pages</summary>
    <div></div>
  </details>

  <details class=\"unselectable\" data-type=\"Photograph\">
    <summary class=\"large\">Photographs</summary>
    <div></div>
  </details>

  <details class=\"unselectable\" data-type=\"Report\">
    <summary class=\"large\">Reports</summary>
    <div></div>
  </details>

  <details class=\"unselectable\" data-type=\"Drawing\">
    <summary class=\"large\">Drawings</summary>
    <div></div>
  </details>

  <details class=\"unselectable\" data-type=\"Map\">
    <summary class=\"large\">Maps</summary>
    <div></div>
  </details>

  <details class=\"unselectable\" data-type=\"Inventory Card\">
    <summary class=\"large\">Inventory Cards</summary>
    <div></div>
  </details>

</div>

<script>arcs.homeView = new arcs.views.Home({el: \$('.page')});</script>
";
    }

    public function getTemplateName()
    {
        return "Pages/home.tpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  38 => 12,  31 => 9,  26 => 6,  23 => 5,  17 => 1,);
    }
}
