<?php

namespace Murkrow\Chat\Models;

use Illuminate\Database\Query\Builder;
class StartableChatCategory
{
    //Used to display the category title
    public string $title;

    //Used to get the users which a chat can be started with
    public Builder $query;

    public function __construct(string $title, Builder $query)
    {
        $this->title = $title;
        $this->query = $query;
    }
}