<?php

namespace Illuminate\Support\Facades;

interface Auth
{
    /**
     * @return \App\Models\Login|false
     */
    public static function loginUsingId(mixed $id, bool $remember = false);

    /**
     * @return \App\Models\Login|false
     */
    public static function onceUsingId(mixed $id);

    /**
     * @return \App\Models\Login|null
     */
    public static function getUser();

    /**
     * @return \App\Models\Login
     */
    public static function authenticate();

    /**
     * @return \App\Models\Login|null
     */
    public static function user();

    /**
     * @return \App\Models\Login|null
     */
    public static function logoutOtherDevices(string $password);

    /**
     * @return \App\Models\Login
     */
    public static function getLastAttempted();
}