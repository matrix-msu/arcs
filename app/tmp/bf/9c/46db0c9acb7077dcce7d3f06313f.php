<?php

/* Search/search.tpl */
class __TwigTemplate_bf9c46db0c9acb7077dcce7d3f06313f extends Twig_Template
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
        echo "<div class=\"search-wrapper\"></div>
<div class=\"search-help\" style=\"display:none\">
  <div class=\"search-help-arrow\"></div>
  <a class=\"search-help-close\">close</a>
  <div class=\"tips\">
    Use search facets to narrow down results. For example, 
    <a href='type%3A%20\"Photograph\"'>type: Photograph</a>
  </div>
  <ul class=\"terms\">
    <li>collection</li>
    <li>comment</li>
    <li>filename</li>
    <li>filetype</li>
    <li>modified</li>
  </ul>
  <ul class=\"definitons\">
    <li>Filter by collection name</li>
    <li>Filter by text in a resource comment</li>
    <li>Filter by the original filename</li>
    <li>Filter by the file type (e.g. pdf, jpeg, png)</li>
    <li>Filter by last modified date</li>
  </ul>
  <ul class=\"terms\">
    <li>keyword</li>
    <li>title</li>
    <li>type</li>
    <li>uploaded</li>
    <li>user</li>
  </ul>
  <ul class=\"definitons\">
    <li>Filter by keyword</li>
    <li>Filter by resource title</li>
    <li>Filter by resource type (e.g. Notebook, Photograph)</li>
    <li>Filter by uploaded date</li>
    <li>Filter by uploader</li>
  </ul>
  <div>
    For more search tips, see the <a href=\"../help/searching\">Search</a> help page.
  </div>
</div>
<div id=\"search-results-wrapper\">
  <div id=\"search-actions\" class=\"search-toolbar\">
    <div id=\"action-buttons\" class=\"btn-group\">
    ";
        // line 44
        if ($this->getAttribute((isset($context["user"]) ? $context["user"] : null), "loggedIn")) {
            // line 45
            echo "      <div id=\"collection-buttons\" class=\"btn-group pull-left\">
        <button id=\"test-btn\" class=\"btn no-rounded needs-resource disabled\"
           data-toggle=\"dropdown\"><i class=\"icon-book\"></i> Collection
          <span class=\"caret\"></span>
        </button>
        <ul class=\"dropdown-menu\">
          <li><a id=\"collection-btn\">Create new collection...</a></li>
          <li><a id=\"collection-add-btn\">Add to existing collection...</a></li>
          <li><a id=\"bookmark-btn\">Add to bookmarks</a></li>
        </ul>
      </div>
      <button id=\"keyword-btn\" class=\"btn needs-resource disabled\" rel=\"tooltip\"
        title=\"Keyword the selected results\" data-placement=\"bottom\">
        <i class=\"icon-tag\"></i> Keyword
      </button>
      <button id=\"attribute-btn\" class=\"btn needs-resource no-rounded disabled\" 
        rel=\"tooltip\" title=\"Edit the attributes of the selected results\" 
        data-placement=\"bottom\">
        <i class=\"icon-pencil\"></i> Edit
      </button>
      <button id=\"flag-btn\" class=\"btn needs-resource disabled\" rel=\"tooltip\"
        title=\"Flag the selected results\" data-placement=\"bottom\">
        <i class=\"icon-flag\"></i> Flag
      </button>
      <div id=\"advanced-buttons\" class=\"btn-group pull-left\">
        <button id=\"advanced-btn\" class=\"btn needs-resource no-rounded disabled\" 
          rel=\"tooltip\" style=\"border-left:none\" data-toggle=\"dropdown\">
          <i class=\"icon-cog\"></i>
          <span class=\"caret\"></span>
        </button>
        <ul class=\"dropdown-menu\">
          ";
            // line 76
            if (($this->getAttribute((isset($context["user"]) ? $context["user"] : null), "role") < 2)) {
                // line 77
                echo "          <li><a id=\"access-btn\">Set Access...</a></li>
          <li class=\"divider\"></li>
          ";
            }
            // line 80
            echo "          <li><a id=\"rethumb-btn\">Redo thumbnail</a></li>
          <li><a id=\"repreview-btn\">Redo preview</a></li>
          <li><a id=\"split-btn\">Split PDF</a></li>
          ";
            // line 83
            if (($this->getAttribute((isset($context["user"]) ? $context["user"] : null), "role") == 0)) {
                // line 84
                echo "          <li class=\"divider\"></li>
          <li><a id=\"delete-btn\">Delete...</a></li>
          <li class=\"divider\"></li>
          <li><a id=\"solr-btn\">Queue SOLR index</a></li>
          ";
            }
            // line 89
            echo "        </ul>
      </div>
    ";
        } else {
            // line 92
            echo "      <div style=\"height:28px\"></div>
    ";
        }
        // line 94
        echo "    </div>
    <div id=\"view-buttons\" class=\"btn-group actions-right\">
      <button id=\"grid-btn\" class=\"btn active\">
        <i class=\"icon-th-large\"></i> Grid
      </button>
      <button id=\"list-btn\" class=\"btn\">
        <i class=\"icon-th-list\"></i> List
      </button>
    </div>
    <div id=\"sort-buttons\" class=\"btn-group actions-right\">
      <button id=\"sort-btn\" class=\"btn dropdown-toggle\" data-toggle=\"dropdown\">
        Sort by <span id=\"sort-by\">title</span>
        <span class=\"caret\"></span>
      </button>
      <ul class=\"dropdown-menu\">
        <li><a class=\"sort-btn\" id=\"sort-title-btn\">title&nbsp;
          <i class=\"icon-ok\"></i></a></li>
        <li><a class=\"sort-btn\" id=\"sort-modified-btn\">modified&nbsp;</a></li>
        <li><a class=\"sort-btn\" id=\"sort-created-btn\">created&nbsp;</a></li>
        <li class=\"divider\"></li>
        <li><a class=\"dir-btn\" id=\"dir-asc-btn\">ascending&nbsp;
          <i class=\"icon-ok\"></i></a></li>
        <li><a class=\"dir-btn\" id=\"dir-desc-btn\">descending&nbsp;</a></li>
      </ul>
    </div>
    <div id=\"open-buttons\" class=\"btn-group actions-right\">
      <button id=\"open-btn\" class=\"btn needs-resource disabled\" rel=\"tooltip\"
        title=\"Open selected results\" data-placement=\"bottom\">Open</button>
      <button class=\"btn needs-resource disabled dropdown-toggle\" 
        data-toggle=\"dropdown\">
        <span class=\"caret\"></span>
      </button>
      <ul class=\"dropdown-menu\">
        <li><a id=\"open-btn\">In separate windows</a></li>
        <li><a id=\"open-colview-btn\">In a collection view</a></li>
      </ul>
    </div>
    <div id=\"export-buttons\" class=\"btn-group actions-right\" style=\"margin-right:30px\">
      <button id=\"export-btn\" class=\"btn dropdown-toggle needs-resource disabled\" 
        data-toggle=\"dropdown\">
        <i class=\"icon-download-alt\"></i> Export
        <span class=\"caret\"></span>
      </button>
      <ul class=\"dropdown-menu\">
        <li><a id=\"download-btn\">Download</a></li>
        <li><a id=\"zipped-btn\">Download as zipfile</a></li>
      </ul>
    </div>
  </div>
  <div id=\"search-results\"></div>
  <div id=\"search-pagination\"></div>
</div>

<script>
  arcs.searchView = new arcs.views.search.Search({
    el: \$('#search-results-wrapper')
  });
</script>
";
    }

    public function getTemplateName()
    {
        return "Search/search.tpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  127 => 94,  123 => 92,  118 => 89,  111 => 84,  109 => 83,  104 => 80,  99 => 77,  97 => 76,  64 => 45,  62 => 44,  17 => 1,);
    }
}
