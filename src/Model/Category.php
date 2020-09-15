<?php
namespace App\Model;;


class Category
{

    private $id;

    private $name;

    private $slug;

    private $post_id;

    private $post;

    public function getID()
    {
        return $this->id;
    }
    public function setID(int $id): self
    {
        $this->id = $id;
        return $this;

    }


    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;

    }


    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug( string $slug): self
    {
        $this->slug = $slug;
        return $this; 
    }

    public function getPostID(): ?string
    {
        return $this->post_id;
    }

    public function setPost( Post $post): void
    {
        $this->post = $post; 
    }
}