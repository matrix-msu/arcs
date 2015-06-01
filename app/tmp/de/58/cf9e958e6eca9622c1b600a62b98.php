<?php

/* Collections/index.tpl */
class __TwigTemplate_de58cf9e958e6eca9622c1b600a62b98 extends Twig_Template
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
        if (isset($context["user_collections"])) { $_user_collections_ = $context["user_collections"]; } else { $_user_collections_ = null; }
        if (($_user_collections_ && (twig_length_filter($this->env, $_user_collections_) > 0))) {
            // line 2
            echo "  <div class=\"collection-list-wrapper\">
    <h2>
      <img class=\"profile-image thumbnail\" 
        src=\"http://gravatar.com/avatar/";
            // line 5
            if (isset($context["user"])) { $_user_ = $context["user"]; } else { $_user_ = null; }
            echo $this->getAttribute($_user_, "gravatar");
            echo "?s=50\"/>
      Your Collections
    </h2>
    <div class=\"collection-list\" id=\"user-collections\"></div>
    <script>
      arcs.user_viewer = new arcs.views.CollectionList({
        model: arcs.models.Collection,
        collection: new arcs.collections.CollectionList(";
            // line 12
            if (isset($context["user_collections"])) { $_user_collections_ = $context["user_collections"]; } else { $_user_collections_ = null; }
            echo twig_jsonencode_filter($_user_collections_);
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
        if (isset($context["html"])) { $_html_ = $context["html"]; } else { $_html_ = null; }
        echo $this->getAttribute($_html_, "image", array(0 => "arcs-icon-big", 1 => array("class" => "profile-image thumbnail")), "method");
        echo "
      All Collections
    </h2>
  <div class=\"collection-list\" id=\"all-collections\"></div>
  <script>
    arcs.user_viewer = new arcs.views.CollectionList({
      model: arcs.models.Collection,
      collection: new arcs.collections.CollectionList(";
        // line 28
        if (isset($context["collections"])) { $_collections_ = $context["collections"]; } else { $_collections_ = null; }
        echo twig_jsonencode_filter($_collections_);
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
        return array (  62 => 28,  51 => 21,  46 => 18,  36 => 12,  25 => 5,  20 => 2,  17 => 1,);
    }
}
