<?php

class ElementIterator implements Iterator 
{
    private $getter = [];

    public function __construct($file_path)
    {
        $dom = new DOMDocument;
        $dom->loadHTMLFile($file_path, 
            LIBXML_NOWARNING | LIBXML_NOERROR);

        $this->getter []= new Getter_title($dom);
        $this->getter []= new Getter_keywords($dom);
        $this->getter []= new Getter_description($dom);
    }

    public function current(): string
    {
        return current($this->getter)->getValue();
    }
 
    public function key(): string
    {
        return current($this->getter)->getKey();
    }
 
    public function next(): void
    {
        next($this->getter);
    }

    public function rewind(): void
    {
        reset($this->getter);
    }    
 
    public function valid(): bool
    {
      return current($this->getter) != false;
    }
}

abstract class GetterBase 
{
    protected $dom = null;

    public function __construct($dom)
    {
        $this->dom = $dom;
    }

    public abstract function getKey(): string;
    public abstract function getValue(): string | null;

    public function getElementValue($tagName): string | null {
        $title_nodes = $this->dom->getElementsByTagName($tagName);
        if ($title_nodes->count() > 0)
        {
            return $title_nodes->item(0)->nodeValue;
        }
        else
            return null;
    }

    public function getMetaValue($attrName): string | null {
        $meta_nodes = $this->dom->getElementsByTagName('meta');
        foreach($meta_nodes as $node) 
        {
            if ($node->getAttribute('name') == $attrName) 
            {
                return $node->getAttribute('content');
            } 
        }

        return null;
    }
}


class Getter_title extends GetterBase
{
    public function getKey(): string {
        return "title";
    }

    public function getValue(): string | null {
        return $this->getElementValue($this->getKey());
    }
}

class Getter_keywords extends GetterBase
{
    public function getKey(): string {
        return "keywords";
    }

    public function getValue(): string | null {
        return $this->getMetaValue($this->getKey());
    }
}

class Getter_description extends GetterBase
{
    public function getKey(): string {
        return "description";
    }

    public function getValue(): string | null {
        return $this->getMetaValue($this->getKey());
    }
}
