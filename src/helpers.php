<?php


// Html entities

function e(string $string= null): string
{
    return htmlentities($string);
}

