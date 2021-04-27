<?php

namespace App\Service;

class Slugify

{

 public function generate(string $input): string

 {
    $slug= trim($input);
    $slug= strtr($slug, "àäåâôöîïûüéè", "aaaaooiiuuee");
    $slug = strtolower($slug);
    $slug = str_replace(' ','-', $slug);
    
    return $slug;
 }

}
