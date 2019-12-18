<?php

use Centauri\CMS\Model\BeUser;
use Centauri\CMS\Model\Page;
use Centauri\CMS\Model\Language;
use Centauri\CMS\Model\Element;
use Centauri\CMS\Model\BackendLayout;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        echo "\n";
        echo "Starting Database Seed...\n\n";


        // Backend Users
        $users = BeUser::all();

        if(count($users) == 0) {
            DB::table("be_users")->insert([
                "username" => "admin",
                "password" => bcrypt("password"),
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ]);

            echo "Created a backend user (admin & password).\n";
        } else {
            echo "Atleast one beuser has been found in be_users-table.\n";
        }


        // Pages
        $pages = Page::all();

        if(count($pages) == 0) {
            DB::table("pages")->insert([
                "pid" => 0,
                "lid" => 1,
                "backend_layout" => 1,
                "is_rootpage" => 1,
                "title" => "Home",
                "slugs" => "/",
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ]);

            echo "Created a home page.\n";
        } else {
            echo "Atleast one page has been found in pages-table.\n";
        }


        // Languages
        $languages = Language::all();

        if(count($languages) == 0) {
            DB::table("languages")->insert([
                "title" => "English",
                "lang_code" => "en-EN",
                "slug" => "",
                "flagsrc" => "CentauriCMS/public/images/flags/UK.jpg",
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ]);

            DB::table("languages")->insert([
                "title" => "Deutsch",
                "lang_code" => "de-DE",
                "slug" => "de",
                "flagsrc" => "CentauriCMS/public/images/flags/DE.jpg",
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ]);

            DB::table("languages")->insert([
                "title" => "Francé",
                "lang_code" => "fr-FR",
                "slug" => "fr",
                "flagsrc" => "CentauriCMS/public/images/flags/FR.png",
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ]);

            echo "Created default languages (english, german & french).\n";
        } else {
            echo "Atleast one language has been found in languages-table.\n";
        }


        // Elements
        $elements = Element::all();

        if(count($elements) == 0) {
            DB::table("elements")->insert([
                "pid" => 1,
                "lid" => 0,
                "rowPos" => 0,
                "colPos" => 0,
                "sorting" => 1,
                "ctype" => "headerdescription",

                "header" => "Welcome to CentauriCMS",
                "subheader" => "Flexible. Fast. Extendable.",
                "rte" => "<h1>RTEEEEE</h1>",

                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ]);

            echo "Created a dummy-element on your root page.\n";
        } else {
            echo "Atleast one element has been found in elements-table.\n";
        }




        echo "\n";
        echo "Database Seeder finished.\n";
    }
}
