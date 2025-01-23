<?php

namespace Teodil\CommentService\Models;

class Comment
{
    public int $id;
    public string $name;
    public string $text;

    public function __construct($id, $name, $text)
    {
        $this->id = $id;
        $this->name = $name;
        $this->text = $text;
    }

}