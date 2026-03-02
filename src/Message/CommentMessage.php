<?php

namespace App\Message;

use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage('async')]
final class CommentMessage
{
    /*
     * Add whatever properties and methods you need
     * to hold the data for this message class.
     */

    // public function __construct(
    //     public readonly string $name,
    // ) {
    // }
    public function __construct(
        private readonly int   $id,
        private readonly array $context = [],
    )

    {
    }

    public function getContext(): array
    {
        return $this->context;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
