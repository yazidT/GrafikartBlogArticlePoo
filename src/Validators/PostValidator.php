<?php
namespace App\Validators;

use App\Table\PostTable;


class PostValidator extends AbstractValidator
{
 
    public function __construct(array $data, PostTable $table, ?int $postID = null )
    {
        parent::__construct($data);
        $this->validator->labels(array(
            'name' => 'Le titre', 
            'content' => 'Le contenu',
            'slug' => 'L\'url'
        ));
        $this->validator->rule('required', ['name', 'slug', 'content']);
        $this->validator->rule('lengthBetween', ['name', 'slug'], 3, 200);
        $this->validator->rule('lengthMin', 'content', 20);
        $this->validator->rule(function($field, $value) use ($table, $postID){
            return !$table->exists($field, $value, $postID);
        }, ['slug', 'name'], 'cette valeur est déjà utilisée');

    
    }


}

