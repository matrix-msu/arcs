<?php

/* Pages/about.tpl */
class __TwigTemplate_fb801cafb2cc553ed22c1e0bbabef597 extends Twig_Template
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
        echo "<div class=\"about\">
  <div class=\"about-intro\">
    <h1>
      <a href=\"";
        // line 4
        if (isset($context["html"])) { $_html_ = $context["html"]; } else { $_html_ = null; }
        echo $this->getAttribute($_html_, "url", array(0 => "/"), "method");
        echo "\">
        ";
        // line 5
        if (isset($context["html"])) { $_html_ = $context["html"]; } else { $_html_ = null; }
        echo $this->getAttribute($_html_, "image", array(0 => "arcs-icon-big.png"), "method");
        echo " ARCS
      </a>
    </h1>
  </div>
  <div class=\"about-features\">
    <section class=\"feature feature-left\" style=\"margin-top:-2px\">
      <div class=\"number\">";
        // line 11
        if (isset($context["html"])) { $_html_ = $context["html"]; } else { $_html_ = null; }
        echo $this->getAttribute($_html_, "image", array(0 => "about/f1.png"), "method");
        echo "</div>
      <h2>Create, relate, organize and search digitized primary evidence</h2>
      <p>ARCS is an open-source web platform that enables individuals to 
      collaborate in creating and relating digitized primary evidence when conducting 
      research in the humanities.
      <p>";
        // line 16
        if (isset($context["html"])) { $_html_ = $context["html"]; } else { $_html_ = null; }
        echo $this->getAttribute($_html_, "image", array(0 => "about/main.jpg", 1 => array("width" => "640", "class" => "shadow")), "method");
        echo "
    </section>
    <div class=\"spacer spacer-left\"></div>
    <section class=\"feature feature-right\">
      <div class=\"number\">";
        // line 20
        if (isset($context["html"])) { $_html_ = $context["html"]; } else { $_html_ = null; }
        echo $this->getAttribute($_html_, "image", array(0 => "about/f2.png"), "method");
        echo "</div>
      <h2>A desktop-like experience</h2>
      <p>Click and drag just like on your PC's desktop. Apply actions en masse. 
      Speed up your workflow with keyboard shortcuts.
      <p>";
        // line 24
        if (isset($context["html"])) { $_html_ = $context["html"]; } else { $_html_ = null; }
        echo $this->getAttribute($_html_, "image", array(0 => "docs/selection.png", 1 => array("class" => "shadow")), "method");
        echo "
    </section>
    <div class=\"spacer spacer-right\"></div>
    <section class=\"feature feature-left\">
      <div class=\"number\">";
        // line 28
        if (isset($context["html"])) { $_html_ = $context["html"]; } else { $_html_ = null; }
        echo $this->getAttribute($_html_, "image", array(0 => "about/f3.png"), "method");
        echo "</div>
      <h2>Uploading your research has never been easier</h2>
      <p>Just drag and drop your files into the uploader. No more clunky upload forms.
      <p>";
        // line 31
        if (isset($context["html"])) { $_html_ = $context["html"]; } else { $_html_ = null; }
        echo $this->getAttribute($_html_, "image", array(0 => "docs/uploading.png"), "method");
        echo "
    </section>
    <div class=\"spacer spacer-left\"></div>
    <section class=\"feature feature-right\">
      <div class=\"number\">";
        // line 35
        if (isset($context["html"])) { $_html_ = $context["html"]; } else { $_html_ = null; }
        echo $this->getAttribute($_html_, "image", array(0 => "about/f4.png"), "method");
        echo "</div>
      <h2>One copy, no worries.</h2>
      <p>Work on your research from anywhere. Collaborate with colleagues on 
      a shared copy of your research. Never lose another file.
      <p>";
        // line 39
        if (isset($context["html"])) { $_html_ = $context["html"]; } else { $_html_ = null; }
        echo $this->getAttribute($_html_, "image", array(0 => "about/5.png"), "method");
        echo "
    </section>
    <div class=\"spacer spacer-right\"></div>
    <section class=\"feature feature-left\">
      <div class=\"number\">";
        // line 43
        if (isset($context["html"])) { $_html_ = $context["html"]; } else { $_html_ = null; }
        echo $this->getAttribute($_html_, "image", array(0 => "about/f5.png"), "method");
        echo "</div>
      <h2>Powerful annotation tools</h2>
      <p>Relate one resource to another. Transcribe handwritten text. Just start drawing 
      on an image.
      <p>";
        // line 47
        if (isset($context["html"])) { $_html_ = $context["html"]; } else { $_html_ = null; }
        echo $this->getAttribute($_html_, "image", array(0 => "docs/annotating.png", 1 => array("class" => "shadow")), "method");
        echo "
    </section>
    <div class=\"spacer spacer-left\"></div>
    <section class=\"feature feature-right\">
      <div class=\"number\">";
        // line 51
        if (isset($context["html"])) { $_html_ = $context["html"]; } else { $_html_ = null; }
        echo $this->getAttribute($_html_, "image", array(0 => "about/f6.png"), "method");
        echo "</div>
      <h2>Whittle down large data sets with facets</h2>
      <p>Search, filter and sort by characteristics to find the needle in the haystack.
      <p>";
        // line 54
        if (isset($context["html"])) { $_html_ = $context["html"]; } else { $_html_ = null; }
        echo $this->getAttribute($_html_, "image", array(0 => "docs/search-1.png", 1 => array("class" => "shadow")), "method");
        echo "
    </section>
    <div class=\"spacer spacer-right\"></div>
    <section class=\"feature feature-left\">
      <div class=\"number\">";
        // line 58
        if (isset($context["html"])) { $_html_ = $context["html"]; } else { $_html_ = null; }
        echo $this->getAttribute($_html_, "image", array(0 => "about/f7.png"), "method");
        echo "</div>
      <h2>It's free!</h2>
      <p>ARCS is open-source software. You can download the source code and put
      ARCS to work for your organization. 
      Check out <a href=\"http://github.com/calmsu/arcs\">ARCS on Github</a>
      <h3>Take ARCS for a spin:</h3>
      <p><a href=\"";
        // line 64
        if (isset($context["html"])) { $_html_ = $context["html"]; } else { $_html_ = null; }
        echo $this->getAttribute($_html_, "url", array(0 => "/search"), "method");
        echo "\" class=\"btn btn-large\">
        <i class=\"icon-search\"></i> Search our Public Collection</a>
    </section>
    <div class=\"spacer spacer-left\"></div>
  </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "Pages/about.tpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  142 => 64,  132 => 58,  124 => 54,  117 => 51,  109 => 47,  101 => 43,  93 => 39,  85 => 35,  77 => 31,  70 => 28,  62 => 24,  54 => 20,  46 => 16,  37 => 11,  27 => 5,  22 => 4,  17 => 1,);
    }
}
