<?php
namespace Centauri\Extension\Frontend;

class PageNotFound
{
    public static function handle()
    {
        $html = view("centauri_frontend::Frontend.Templates.pageNotFound")->render();
        return response($html, 404);
    }
}
