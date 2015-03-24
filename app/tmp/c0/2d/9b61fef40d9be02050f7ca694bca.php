<?php

/* Resources/viewer.tpl */
class __TwigTemplate_c02d9b61fef40d9be02050f7ca694bca extends Twig_Template
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
        echo $this->getAttribute((isset($context["html"]) ? $context["html"] : null), "link", array(0 => $this->getAttribute($this->getAttribute((isset($context["resource"]) ? $context["resource"] : null), "Resource"), "title"), 1 => ("/resource/" . $this->getAttribute($this->getAttribute((isset($context["resource"]) ? $context["resource"] : null), "Resource"), "id")), 2 => array("class" => "title subtle")), "method");
        // line 3
        echo " 
  <button id=\"full-screen-btn\" class=\"btn toolbar-btn\" rel=\"tooltip\"
    data-original-title=\"Fullscreen\"><i class=\"icon-resize-full\"></i></button>
  <button id=\"annotation-vis-btn\" class=\"btn toolbar-btn\" rel=\"tooltip\" 
    data-placement=\"bottom\"><i class=\"icon-map-marker\"></i></button>
  <div id=\"zoom-buttons\" class=\"btn-group toolbar-btn\">
    <button id=\"zoom-in-btn\" class=\"btn\"><i class=\"icon-zoom-in\"></i></button>
    <button id=\"zoom-out-btn\" class=\"btn disabled\"><i class=\"icon-zoom-out\"></i></button>
  </div>
  <div id=\"export-buttons\" class=\"btn-group toolbar-btn\">
    <button id=\"export-btn\" class=\"btn dropdown-toggle\" rel=\"tooltip\"
      data-toggle=\"dropdown\" data-original-title=\"Export this resource\">
      <i class=\"icon-download-alt\"></i> Export
      <span class=\"caret\"></span>
    </button>
    <ul class=\"dropdown-menu\">
      <li><a id=\"download-btn\">Download</a></li>
    </ul>
  </div>
  ";
        // line 22
        if ($this->getAttribute((isset($context["user"]) ? $context["user"] : null), "loggedIn")) {
            // line 23
            echo "  <div id=\"action-buttons\" class=\"btn-group toolbar-btn\">
    <button id=\"annotate-btn\" class=\"btn\" rel=\"tooltip\" title=\"Annotate this resource\"
      data-placement=\"bottom\"><i class=\"icon-screenshot\"></i> Annotate</button>
    <button id=\"edit-btn\" class=\"btn\" rel=\"tooltip\" 
      data-original-title=\"Edit this resource's info\"><i class=\"icon-pencil\"></i> Edit</button>
    <button id=\"flag-btn\" class=\"btn\" rel=\"tooltip\"
      data-original-title=\"Flag this resource\"><i class=\"icon-flag\"></i> Flag</button>
    <div id=\"advanced-buttons\" class=\"btn-group pull-left\">
      <button id=\"advanced-btn\" class=\"btn\" rel=\"tooltip\" style=\"border-left:none\"
        data-toggle=\"dropdown\"><i class=\"icon-cog\"></i>
        <span class=\"caret\"></span>
      </button>
      <ul class=\"dropdown-menu\">
        <li><a id=\"rethumb-btn\">Re-thumbnail</a></li>
        <li><a id=\"split-btn\">Split PDF</a></li>
        ";
            // line 38
            if (($this->getAttribute((isset($context["user"]) ? $context["user"] : null), "role") == 0)) {
                // line 39
                echo "        <li><a id=\"delete-btn\">Delete</a></li>
        ";
            }
            // line 41
            echo "      </ul>
    </div>
  </div>
  ";
        }
        // line 45
        echo "</div>

<div id=\"viewer\" class=\"row\">
  <div id=\"standalone\" class=\"viewer-well\">
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
      <li class=\"active\" id=\"#information-btn\">
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
        <h3>Resource</h3>
        <table id=\"resource-details\" 
            class=\"details table table-striped table-bordered\"></table>
        <hr>
        <h3>Collections</h3>
        <div id=\"memberships-wrapper\">
        ";
        // line 83
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["memberships"]) ? $context["memberships"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["m"]) {
            // line 84
            echo "          ";
            echo $this->getAttribute((isset($context["html"]) ? $context["html"] : null), "link", array(0 => $this->getAttribute($this->getAttribute((isset($context["m"]) ? $context["m"] : null), "Collection"), "title"), 1 => ((("/collection/" . $this->getAttribute($this->getAttribute((isset($context["m"]) ? $context["m"] : null), "Collection"), "id")) . "/") . $this->getAttribute($this->getAttribute((isset($context["resource"]) ? $context["resource"] : null), "Resource"), "id"))), "method");
            // line 85
            echo "
          <br>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['m'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 88
        echo "        </div>
      </div>
      <div class=\"tab-pane\" id=\"notations\">
        <h3>Annotations</h3>
        <div id=\"annotations-wrapper\"></div>
        <hr>
        <h3>Keywords</h3>
        <div id=\"keywords-wrapper\"></div>
        <br>
        ";
        // line 97
        if ($this->getAttribute((isset($context["user"]) ? $context["user"] : null), "loggedIn")) {
            // line 98
            echo "        <input id=\"keyword-btn\" class=\"unfocused\" type=\"text\" placeholder=\"New keyword...\" />
        ";
        }
        // line 100
        echo "      </div>
      <div class=\"tab-pane\" id=\"discussion\">
        <div id=\"comment-wrapper\"></div>
        <br>
        ";
        // line 104
        if ($this->getAttribute((isset($context["user"]) ? $context["user"] : null), "loggedIn")) {
            // line 105
            echo "        <textarea id=\"content\" name=\"content\"></textarea>
        <button id=\"comment-btn\" class=\"btn\">Comment</button>
        ";
        } else {
            // line 108
            echo "        ";
            echo $this->getAttribute((isset($context["html"]) ? $context["html"] : null), "link", array(0 => "Login", 1 => "/login"), "method");
            echo " to comment.
        ";
        }
        // line 110
        echo "      </div>
    </div>
  </div>
</div>

<div class=\"viewer-footer\"></div>

<!-- Give the resource array to the client-side code -->
<script>
  arcs.resource = new arcs.models.Resource(";
        // line 119
        echo twig_jsonencode_filter((isset($context["resource"]) ? $context["resource"] : null));
        echo ");
  arcs.collection = new arcs.collections.Collection();
  arcs.viewer = new arcs.views.Viewer({
    model: arcs.resource,
    collection: arcs.collection,
    el: \$('#viewer')
  });
</script>
";
    }

    public function getTemplateName()
    {
        return "Resources/viewer.tpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  176 => 119,  165 => 110,  159 => 108,  154 => 105,  152 => 104,  146 => 100,  142 => 98,  140 => 97,  129 => 88,  121 => 85,  118 => 84,  114 => 83,  74 => 45,  68 => 41,  64 => 39,  62 => 38,  45 => 23,  43 => 22,  22 => 3,  20 => 2,  17 => 1,);
    }
}
