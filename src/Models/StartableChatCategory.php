<?php

namespace Murkrow\Chat\Models;

use Illuminate\Database\Query\Builder;
class StartableChatCategory
{
    //Used to display the category title
    public string $title;

    //Used to get the users which a chat can be started with
    public Builder|\Illuminate\Database\Eloquent\Builder|null $query;

    //Used to force collapse the category even if results are few
    public bool $forceCollapse;

    public function __construct(string $title,  Builder|\Illuminate\Database\Eloquent\Builder|null $query, bool $forceCollapse = false)
    {
        $this->title = $title;
        $this->query = $query;
        $this->forceCollapse = $forceCollapse;
    }
}