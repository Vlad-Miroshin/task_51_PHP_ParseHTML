<?php


function parse_html_file($file_path) {

    $result = array();

    $dom = get_dom_from_file($file_path);

    $title_nodes = $dom->getElementsByTagName('title');
    foreach($title_nodes as $node) {
        $result['title'] = $node->nodeValue;
        break;
    }

    $meta_nodes = $dom->getElementsByTagName('meta');
    foreach($meta_nodes as $node) {

        $attr_name = $node->getAttribute('name');

        if ($attr_name == 'keywords') {
            $result['keywords'] = $node->getAttribute('content');
        } 
        else if ($attr_name == 'description') {
            $result['description'] = $node->getAttribute('content');
        }

    }
    
    return $result;
}


function remove_tags($source_path, $target_path) {

    $nodes_to_remove = array();

    $dom = get_dom_from_file($source_path);

    $title_nodes = $dom->getElementsByTagName('title');
    if ($title_nodes->count() > 0)
    {
        $nodes_to_remove []= $title_nodes->item(0);
    }

    $meta_nodes = $dom->getElementsByTagName('meta');
    foreach($meta_nodes as $node) {

        $attr_name = $node->getAttribute('name');

        if ($attr_name == 'keywords' || $attr_name == 'description' ) {
            $nodes_to_remove []= $node;
        } 
    }

    foreach($nodes_to_remove as $node) {
        remove($node);
    }


    $dom->save($target_path);
}


function get_dom_from_file($file_path) {
    $dom = new DOMDocument;
    $dom->loadHTMLFile($file_path, LIBXML_NOWARNING | LIBXML_NOERROR);

    return $dom;
}


function remove($node) {
    $parent = $node->parentNode;
    $parent->removeChild($node);
}