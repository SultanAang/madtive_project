<?php

namespace Illuminate\Http;

interface Request
{
    /**
     * @return \App\Models\Login|null
     */
    public function user($guard = null);
}