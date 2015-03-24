<?php

/* Collections/viewer.tpl */
class __TwigTemplate_e22b9f5524cffb5711efa318b7a08a88 extends Twig_Template
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
        echo "<div id=\"viewer-controls\">
  ";
        // line 2
        if (isset($context["html"])) { $_html_ = $context["html"]; } else { $_html_ = null; }
        if (isset($context["collection"])) { $_collection_ = $context["collection"]; } else { $_collection_ = null; }
        echo $this->getAttribute($_html_, "link", array(0 => $this->getAttribute($_collection_, "title"), 1 => ("/collection/" . $this->getAttribute($_collection_, "id")), 2 => array("class" => "title subtle")), "method");
        // line 3
        echo " 
  <input type=\"text\" class=\"collection-search toolbar-btn\" 
    placeholder=\"Search this collection...\" />
  <button id=\"thumbs-btn\" class=\"btn toolbar-btn\" rel=\"tooltip\"
    title=\"View this collection in the search\" data-placement=\"bottom\">
    <i class=\"icon-th-large\"></i></button>
  <button id=\"full-screen-btn\" class=\"btn toolbar-btn\" rel=\"tooltip\" title=\"Fullscreen\"
    data-placement=\"bottom\"><i class=\"icon-resize-full\"></i></button>
  <button id=\"annotation-vis-btn\" class=\"btn toolbar-btn\" rel=\"tooltip\" 
    data-placement=\"bottom\"><i class=\"icon-map-marker\"></i></button>
  <div id=\"zoom-buttons\" class=\"btn-group toolbar-btn\">
    <button id=\"zoom-in-btn\" class=\"btn\"><i class=\"icon-zoom-in\"></i></button>
    <button id=\"zoom-out-btn\" class=\"btn disabled\"><i class=\"icon-zoom-out\"></i></button>
  </div>
  <div class=\"page-nav toolbar-btn input-append input-prepend\">
    <button id=\"mini-prev-btn\" class=\"btn\"><i class=\"icon-arrow-left\"></i></button>
    <input type=\"text\" class=\"span2\" />
    <button id=\"mini-next-btn\" class=\"btn\"><i class=\"icon-arrow-right\"></i></button>
  </div>
  <div id=\"export-buttons\" class=\"btn-group toolbar-btn\">
    <button id=\"export-btn\" class=\"btn dropdown-toggle\" data-toggle=\"dropdown\">
      <i class=\"icon-download-alt\"></i> Export
      <span class=\"caret\"></span>
    </button>
    <ul class=\"dropdown-menu\">
      <li><a id=\"download-btn\">Download</a></li>
    </ul>
  </div>
  ";
        // line 31
        if (isset($context["user"])) { $_user_ = $context["user"]; } else { $_user_ = null; }
        if ($this->getAttribute($_user_, "loggedIn")) {
            // line 32
            echo "  <div id=\"action-buttons\" class=\"btn-group toolbar-btn\">
    <button id=\"annotate-btn\" class=\"btn\" rel=\"tooltip\" title=\"Annotate this resource\"
      data-placement=\"bottom\"><i class=\"icon-screenshot\"></i> Annotate</button>
    <button id=\"edit-btn\" class=\"btn\" rel=\"tooltip\" title=\"Edit this resource's info\"
      data-placement=\"bottom\"><i class=\"icon-pencil\"></i> Edit</button>
    <button id=\"flag-btn\" class=\"btn\" rel=\"tooltip\"
      title=\"Flag this resource\" data-placement=\"bottom\"><i class=\"icon-flag\"></i> Flag</button>
    <div id=\"advanced-buttons\" class=\"btn-group pull-left\">
      <button id=\"advanced-btn\" class=\"btn\" style=\"border-left:none\" data-toggle=\"dropdown\">
        <i class=\"icon-cog\"></i>
        <span class=\"caret\"></span>
      </button>
      <ul class=\"dropdown-menu\">
        <li><a id=\"rethumb-btn\">Re-thumbnail</a></li>
        <li><a id=\"split-btn\">Split PDF</a></li>
        ";
            // line 47
            if (isset($context["user"])) { $_user_ = $context["user"]; } else { $_user_ = null; }
            if (($this->getAttribute($_user_, "role") == 0)) {
                // line 48
                echo "        <li class=\"divider\"></li>
        <li><a id=\"delete-btn\">Delete this resource...</a></li>
        <li><a id=\"delete-col-btn\">Delete collection...</a></li>
        ";
            }
            // line 52
            echo "      </ul>
    </div>
  </div>
  ";
        }
        // line 56
        echo "</div>

<div id=\"viewer\" class=\"row\">
  <div class=\"viewer-well\">
    <div id=\"prev-btn\" class=\"viewer-nav\"></div>
    <div id=\"next-btn\" class=\"viewer-nav\"></div>
    <div id=\"wrapping\">
      <div id=\"hotspots-wrapper\"></div>
      <div id=\"resource\"></div>
      <div class=\"annotate-controls\">
        <span>Click and drag to annotate</span>
        <button id=\"annotate-done-btn\">
          <i class=\"icon-white icon-ok\"></i> Done
        </button>
        <button id=\"annotate-new-btn\">
          <i class=\"icon-white icon-map-marker\"></i> New Annotation
        </button>
      </div>
    </div>
  </div>
  <div class=\"viewer-tabs tabbable\">
    <ul class=\"nav nav-pills\">
      <li class=\"active\" id=\"information-btn\">
        <a data-toggle=\"tab\" href=\"#information\">Info</a>
      </li>
      <li id=\"notations-btn\">
        <a data-toggle=\"tab\" href=\"#notations\">Notations</a>
      </li>
      <li id=\"discussion-btn\">
        <a data-toggle=\"tab\" href=\"#discussion\">Discussion</a>
      </li>
    </ul>
    <div class=\"tab-content\">
      <div class=\"tab-pane active\" id=\"information\">
        <h3>Collection</h3>
        <table id=\"collection-details\" 
            class=\"details table table-striped table-bordered\"></table>
        <h3>Resource</h3>
        <table id=\"resource-details\" 
            class=\"details table table-striped table-bordered\"></table>
      </div>
      <div class=\"tab-pane\" id=\"notations\">
        <h3>Annotations</h3>
        <div id=\"annotations-wrapper\"></div>
        <hr>
        <h3>Keywords</h3>
        <div id=\"keywords-wrapper\"></div>
        <br>
        ";
        // line 104
        if (isset($context["user"])) { $_user_ = $context["user"]; } else { $_user_ = null; }
        if ($this->getAttribute($_user_, "loggedIn")) {
            // line 105
            echo "        <input id=\"keyword-btn\" class=\"unfocused\" type=\"text\" placeholder=\"New keyword...\" />
        ";
        }
        // line 107
        echo "      </div>
      <div class=\"tab-pane\" id=\"discussion\">
        <div id=\"comment-wrapper\"></div>
        <br>
        ";
        // line 111
        if (isset($context["user"])) { $_user_ = $context["user"]; } else { $_user_ = null; }
        if ($this->getAttribute($_user_, "loggedIn")) {
            // line 112
            echo "        <div class=\"well\">
          <textarea id=\"content\" name=\"content\"></textarea>
          <button id=\"comment-btn\" class=\"btn\">Comment</button>
        </div>
        ";
        } else {
            // line 117
            echo "        ";
            if (isset($context["html"])) { $_html_ = $context["html"]; } else { $_html_ = null; }
            echo $this->getAttribute($_html_, "link", array(0 => "Login", 1 => "/login"), "method");
            echo " to comment.
        ";
        }
        // line 119
        echo "      </div>
    </div>
  </div>
</div>

<div id=\"carousel-wrapper\" class=\"es-carousel-wrapper\">
  <div id=\"carousel\" class=\"es-carousel\">
    <ul></ul>
  </div>
</div>

<!-- Bootstrap our backbone models -->
<script>
  arcs.collectionModel = new arcs.models.Collection(";
        // line 132
        if (isset($context["collection"])) { $_collection_ = $context["collection"]; } else { $_collection_ = null; }
        echo twig_jsonencode_filter($_collection_);
        echo ");
  arcs.collection = new arcs.collections.Collection(";
        // line 133
        if (isset($context["resources"])) { $_resources_ = $context["resources"]; } else { $_resources_ = null; }
        echo twig_jsonencode_filter($_resources_);
        echo ");
  arcs.resource = new arcs.models.Resource(";
        // line 134
        if (isset($context["resources"])) { $_resources_ = $context["resources"]; } else { $_resources_ = null; }
        echo twig_jsonencode_filter($this->getAttribute($_resources_, 0, array(), "array"));
        echo ");
  arcs.viewer = new arcs.views.Viewer({
    model: arcs.resource,
    collection: arcs.collection,
    collectionModel: arcs.collectionModel,
    el: \$('#viewer')
  });
</script>
";
    }

    public function getTemplateName()
    {
        return "Collections/viewer.tpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  194 => 134,  189 => 133,  184 => 132,  169 => 119,  162 => 117,  155 => 112,  152 => 111,  146 => 107,  142 => 105,  139 => 104,  89 => 56,  83 => 52,  77 => 48,  74 => 47,  57 => 32,  54 => 31,  24 => 3,  20 => 2,  17 => 1,);
    }
}
