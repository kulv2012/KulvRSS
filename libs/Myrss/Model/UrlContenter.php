<?php

require_once("Myrss/Model/Http.php");
require_once ('Third/readability/Readability.php');

class Myrss_Model_UrlContenter {


    public static function getContent( $url, $basecontent ="" ){
        $http = new Myrss_Model_Http();
        $html  = $http->fetch( $url );
        if($html == false)
            return $basecontent ;

        // Note: PHP Readability expects UTF-8 encoded content.
        // If your content is not UTF-8 encoded, convert it 
        // first before passing it to PHP Readability. 
        // Both iconv() and mb_convert_encoding() can do this.

        $readability = new Readability($html, $url);
        $readability->debug = false;
        // convert links to footnotes?
        $readability->convertLinksToFootnotes = true;
        $result = $readability->init();
        if ($result) {
            //    echo $readability->getTitle()->textContent, "\n\n";
            $content = $readability->getContent()->innerHTML;
            return $content ;
        } 
        else {
            return $basecontent ;
        }
    }


}


