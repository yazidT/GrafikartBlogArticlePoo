<?php
namespace App\Helpers;

Class Text 
{
    public static function excerpt( string $content, int $limit = 70)
    {
        if(mb_strlen($content) <= $limit )
        {
            return $content;
        }
        $lastSpace = mb_strpos($content, ' ', $limit); // Trouver le dernier espace a partir de la limite 
        return mb_substr($content, 0, $lastSpace) . '...';
    }
}