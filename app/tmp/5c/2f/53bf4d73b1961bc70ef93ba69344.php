<?php

/* Collections/index.tpl */
class __TwigTemplate_5c2f53bf4d73b1961bc70ef93ba69344 extends Twig_Template
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
        if (((isset($context["user_collections"]) ? $context["user_collections"] : null) && (twig_length_filter($this->env, (isset($context["user_collections"]) ? $context["user_collections"] : null)) > 0))) {
            // line 2
            echo "  <div class=\"collection-list-wrapper\">
    <h2>
      <img class=\"profile-image thumbnail\" 
        src=\"http://gravatar.com/avatar/";
            // line 5
            echo $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "gravatar");
            echo "?s=50\"/>
      Your Collections
    </h2>
    <div class=\"collection-list\" id=\"user-collections\"></div>
    <script>
      arcs.user_viewer = new arcs.views.CollectionList({
        model: arcs.models.Collection,
        collection: new arcs.collections.CollectionList(";
            // line 12
            echo twig_jsonencode_filter((isset($context["user_collections"]) ? $context["user_collections"] : null));
            echo "),
        el: \$('#user-collections')
      });
    </script>
  </div>
";
        }
        // line 18
        echo "
<div class=\"collection-list-wrapper\">
    <h2>
      ";
        // line 21
        echo $this->getAttribute((isset($context["html"]) ? $context["html"] : null), "image", array(0 => "arcs-icon-big", 1 => array("class" => "profile-image thumbnail")), "method");
        echo "
      All Collections
    </h2>
  <div class=\"collection-list\" id=\"all-collections\"></div>
  <script>
    arcs.user_viewer = new arcs.views.CollectionList({
      model: arcs.models.Collection,
      collection: new arcs.collections.CollectionList(";
        // line 28
        echo twig_jsonencode_filter((isset($context["collections"]) ? $context["collections"] : null));
        echo "),
      el: \$('#all-collections')
    });
  </script>
<div class=\"collection-list-wrapper\">
";
    }

    public function getTemplateName()
    {
        return "Collections/index.tpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  58 => 28,  48 => 21,  43 => 18,  34 => 12,  24 => 5,  19 => 2,  17 => 1,);
    }
}
