<?php

namespace Teodil\CommentService\Models;

class CreateCommentDTO
{
    public string $name;
    public string $text;

    public function __construct($name, $text)
    {
        $this->name = $name;
        $this->text = $text;
    }

}