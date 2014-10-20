<?php
namespace BasicLibs;
/**
 * Document
 *
 * Implementation of the document for BasicMVC.
 * This class provides this interface:
 *
 * setTitle( string $title )
 * setKeywords( array|string $keyword )
 * setDescription( string $description )
 * addMetaWithArray(array $meta)
 * addMeta( string $content, string $name )
 * addOGMeta( string $property, string $content )
 * addLinkWithArray( array $link )
 * addLink( string $href, string $rel )
 * addStyle( string $href )
 * addScriptWithArray( array $script )
 * addScript( string $src )
 * renderMetas()
 * renderScripts()
 * renderLinks()
 * render()
 * fetch()
 *
 * @package BasicLib
 * @author Haydar KULEKCI <haydarkulekci@gmail.com>
 * @version 0.1
 */
class Document{

    /**
     *  Page Metas Attributes <meta>
     *
     *  Attributes of meta tag:
     *   charset
     *   content
     *   http-equiv
     *   name
     *   scheme
     *   property [For OpenGraph]
     *
     *  @var array
     */
    protected $metas = array();

    /**
     *  Page Links Attributes <link>
     *
     *  Attributes of link tag:
     *   charset
     *   href
     *   hreflang
     *   media
     *   rel
      *    alternate
      *    archives
      *    author
      *    bookmark
      *    external
      *    first
      *    help
      *    icon
      *    last
      *    license
      *    next
      *    nofollow
      *    noreferrer
      *    pingback
      *    prefetch
      *    prev
      *    search
      *    sidebar
      *    stylesheet
      *    tag
      *    up
     *   rev
     *   size
     *   target
      *    _blank
      *    _self
      *    _top
      *    _parent
     *   type
     *
     *  @var array
     *
     */
    protected $links = array();

    /**
     *
     *  Page Links Attributes <script>
     *
     *  Attributes of script tag:
     *   async
     *   charset
     *   defer
     *   src
     *   type
     *
     *  @var array
     */
    protected $scripts = array();

    /**
     *   Page Title Content <title>
     *
     *   @var string
     */
    protected $title = "";

    /**
     *   Page Description Content <meta[description]>
     *
     *   @var string
     */
    protected $description = "";

    /**
     *   Page Keyword Content <meta[keyword]">
     *
     *   @var string
     */
    protected $keywords = "";


    /**
     *   Add title to document
     *   Result :
     *      <title>{$title}</title>
     *
     *   @param  string      $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     *   Add keywords meta tag to document
     *   Result :
     *      <meta name="keywords" content="{$keywords}">
     *
     *   @param  array|string      $keyword
     */
    public function setKeywords($keyword)
    {
        if (is_array($keyword))
            $this->keywords = implode(", ", $keyword);
        else
            $this->keywords = $keyword;
    }

    /**
     *   Add description meta tag to document
     *   Result :
     *      <meta name="description" content="{$description}">
     *
     *   @param  string      $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     *   Add meta to document with array
     *   $meta array is key-value array.
     *   Result :
     *      <meta {$meta[key1]}="{$meta[value1]}" {$meta[key2]}="{$meta[value2]}">
     *
     *   @param  array       $meta
     */
    public function addMetaWithArray(array $meta)
    {
        $this->metas[] = $meta;
    }

    /**
     *   Add meta to document with content and name
     *   Result :
     *      <meta name="{$name}" content="{$content}">
     *
     *   @param  string      $content
     *   @param  string      $name
     */
    public function addMeta($content, $name)
    {
        $this->addMetaWithArray(array("content" => $content, "name" => $name));
    }

    /**
     *   Add meta to document with content and property
     *   Result :
     *      <meta property="{$name}" content="{$content}">
     *
     *   @param  string      $content
     *   @param  string      $name
     */
    public function addOGMeta($property, $content)
    {
        $this->addMetaWithArray(array("property" => $property, "content" => $content));
    }

    /**
     *   Add link to document with array
     *   $link is key-value array.
     *   Result :
     *      <link {$link[key]}="{$link[value]}" ...>
     *
     *   @param  array      $link
     */
    public function addLinkWithArray(array $link)
    {
        $this->links[] = $link;
    }

    /**
     *   Add link to document with href and rel information
     *   Result :
     *      <link href="{$href}" rel="{$rel}">
     *
     *   @param  string      $href
     *   @param  string      $rel
     */
    public function addLink($href, $rel)
    {
        $this->addLinkWithArray(array("href" => $href, "rel" => $rel));
    }

    /**
     *   Add style to document with href information
     *   Result :
     *      <link href="{$href}" type="text/css" rel="stylesheet">
     *
     *   @param  string      $href
     */
    public function addStyle($href)
    {
        $this->addLinkWithArray(array("href" => $href, "rel" => "stylesheet", "type" => "text/css"));
    }

    /**
     *   Add script to document with array
     *   $script is key-value array.
     *   Result :
     *      <script {$script[key1]}="{$script[value1]}" ...></script>
     *
     *   @param  array      $script
     */
    public function addScriptWithArray(array $script)
    {
        $this->scripts[] = $script;
    }

    /**
     *   Add script to document with src information
     *   Result :
     *      <script src="{$src}" type="text/javascript"></script>
     *
     *   @param  string      $src
     */
    public function addScript($src)
    {
        $this->addScriptWithArray(array("src" => $src, "type" => "text/javascript"));
    }

    /**
     *   Add style to document with href information
     *   Result :
     *      <script src="{$src}" type="text/javascript"></script>
     *
     *   @param  string      $src
     */
    public function renderMetas()
    {
        $html = "";

        foreach ($this->metas as $meta) {
            $html .= "    <meta ";
            foreach ($meta as $key => $value) {
                $html .= $key . "=" . "\"".$value."\" ";
            }
            $html .= ">\n";
        }

        return $html;
    }

    /**
     *   Render all the scripts of the class from $scripts variable.
     *
     *   @return  string
     */
    public function renderScripts()
    {
        $html = "";

        foreach ($this->scripts as $script) {
            $html .= "    <script ";
            foreach ($script as $key => $value) {
                $html .= $key . "=" . "\"".$value."\" ";
            }
            $html .= "></script>\n";
        }

        return $html;
    }

    /**
     *   Render all the links of the class from $links variable.
     *
     *   @return  string
     */
    public function renderLinks()
    {
        $html = "";

        foreach ($this->links as $link) {
            $html .= "    <link ";
            foreach ($link as $key => $value) {
                $html .= $key . "=" . "\"".$value."\" ";
            }
            $html .= ">\n";
        }

        return $html;
    }

    /**
     *   Render all the documents.
     *
     *   @return  string
     */
    public function render()
    {
        $html = "";

        $html .= "<title>".$this->title."</title>\n";
        $html .= "<meta name=\"keywords\" content=\"".$this->keywords."\">\n";
        $html .= "<meta name=\"description\" content=\"".$this->description."\">\n\n";

        $html .= $this->renderMetas();
        $html .= $this->renderLinks();
        $html .= $this->renderScripts();

        return $html;

    }

    /**
     *   Fetch all the documents information.
     *
     *   @return  array
     */
    public function fetch()
    {
        return array(
            "title"         => $this->title,
            "keywords"      => $this->keywords,
            "description"   => $this->description,
            "metas"         => $this->renderMetas(),
            "scripts"       => $this->renderScripts(),
            "links"         => $this->renderLinks(),
            );

    }

} // END Document
