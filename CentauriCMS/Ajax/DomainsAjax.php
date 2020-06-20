<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\Abstracts\AjaxAbstract;
use Illuminate\Http\Request;
use Centauri\CMS\Interfaces\AjaxInterface;
use Centauri\CMS\Model\Language;
use Centauri\CMS\Model\Page;
use Centauri\CMS\Utility\DomainsUtility;

class DomainsAjax implements AjaxInterface
{
    public function request(Request $request, String $ajaxName)
    {
        if($ajaxName == "showModal") {
            $rootpages = Page::where("page_type", "rootpage")->get()->all();
            
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

            $path = base_path("CentauriCMS/Domains/$id.json");

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

        if($ajaxName == "findById") {
            $id = $request->input("id");

            $path = base_path("CentauriCMS/Domains/" . strtolower($id) . ".json");
            $content = file_get_contents($path);

            return $content;
        }

        if($ajaxName == "findAll") {
            $domains = DomainsUtility::findAll();
            return json_encode($domains);
        }

        if($ajaxName == "edit") {
            $data = $request->input("data");
            $datasArr = json_decode($data, true);

            $id = strtolower($request->input("id"));

            $path = base_path("CentauriCMS/Domains/$id.json");
            $content = json_decode(file_get_contents($path));

            foreach($datasArr as $key => $value) {
                $content->$key = $value;
            }

            file_put_contents($path, json_encode($content, JSON_PRETTY_PRINT));

            return json_encode([
                "type" => "success",
                "title" => "Domains",
                "description" => "Updated Domain-Record with ID '" . $id . "'"
            ]);
        }

        if($ajaxName == "delete") {
            $id = $request->input("id");

            $path = base_path("CentauriCMS/Domains/$id.json");
            unlink($path);

            return json_encode([
                "type" => "warning",
                "title" => "Domains",
                "description" => "Deleted Domain-Record with ID '" . $id . "'"
            ]);
        }

        return AjaxAbstract::default($request, $ajaxName);
    }
}
