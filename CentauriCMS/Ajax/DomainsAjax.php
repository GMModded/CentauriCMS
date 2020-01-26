<?php
namespace Centauri\CMS\Ajax;

use Illuminate\Http\Request;
use Centauri\CMS\AjaxInterface;
use Centauri\CMS\Model\Language;
use Centauri\CMS\Model\Page;
use Centauri\CMS\Utility\DomainsUtility;

class DomainsAjax implements AjaxInterface
{
    public function request(Request $request, String $ajaxName)
    {
        if($ajaxName == "showModal") {
            $rootpages = Page::where("is_rootpage", 1)->get()->all();
            
            foreach($rootpages as $rootpage) {
                $lid = $rootpage->lid;
                $language = Language::where("uid", $lid)->get()->first();
                $rootpage->language = $language;
            }

            return view("Centauri::Backend.Modals.domains", [
                "rootpages" => $rootpages
            ]);
        }

        if($ajaxName == "create") {
            $id = $request->input("id");
            $domain = $request->input("domain");
            $rootpageuid = $request->input("rootpageuid");

            $path = base_path("CentauriCMS\\Domains\\$id.json");

            if(file_exists($path)) {
                return response("Domain with ID '" . $id . "' exists already!", 500);
            } else {
                $idFile = fopen($path, "w+");

                $data = [
                    "id" => $id,
                    "domain" => $domain,
                    "rootpageuid" => $rootpageuid
                ];

                fwrite($idFile, json_encode($data, JSON_PRETTY_PRINT));
                fclose($idFile);

                return json_encode([
                    "type" => "success",
                    "title" => "Domains",
                    "description" => "Created new domain '" . $id . "'"
                ]);
            }
        }

        if($ajaxName == "findAll") {
            $domains = DomainsUtility::findAll();
            return json_encode($domains);
        }

        if($ajaxName == "edit") {
            $id = $request->input("id");
            $domain = $request->input("domain");
            $rootpageuid = $request->input("rootpageuid");

            $path = base_path("CentauriCMS\\Domains\\$id.json");
            $content = json_decode(file_get_contents($path));

            $content->domain = $domain;
            $content->rootpageuid = $rootpageuid;
            file_put_contents($path, json_encode($content, JSON_PRETTY_PRINT));

            return json_encode([
                "type" => "success",
                "title" => "Domains",
                "description" => "Updated Domain-Record with ID '" . $id . "'"
            ]);
        }

        if($ajaxName == "delete") {
            $id = $request->input("id");

            $path = base_path("CentauriCMS\\Domains\\$id.json");
            unlink($path);

            return json_encode([
                "type" => "warning",
                "title" => "Domains",
                "description" => "Deleted Domain-Record with ID '" . $id . "'"
            ]);
        }
    }
}
