<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\Abstracts\AjaxAbstract;
use Illuminate\Http\Request;
use Centauri\CMS\Model\Language;
use Centauri\CMS\Model\Page;
use Centauri\CMS\Traits\AjaxTrait;
use Centauri\CMS\Utility\DomainsUtility;

class DomainsAjax
{
    use AjaxTrait;

    /**
     * @todo Add domains-description for this ajax-method!
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function showModalAjax(Request $request)
    {
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

    /**
     * This will handle the submit-request of the modal when creating a new domain record (as json file ofcourse).
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function createAjax(Request $request)
    {
        $id = $request->input("id");
        $domain = $request->input("domain");
        $rootpageuid = $request->input("rootpageuid");

        $path = storage_path("Centauri/Domains/$id.json");

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

    /**
     * Returns the file-content of a domain (json) file by its identifier (id).
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function findByIdAjax(Request $request)
    {
        $id = $request->input("id");

        $path = storage_path("Centauri/Domains/" . strtolower($id) . ".json");
        $content = file_get_contents($path);

        return $content;
    }

    /**
     * Returns all Domain-Records.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function findAllAjax(Request $request)
    {
        $domains = DomainsUtility::findAll();
        return json_encode($domains);
    }

    /**
     * When editing a domain record (file) e.g. updating its rootpageuid or its 404-pageuid etc.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function editAjax(Request $request)
    {
        $data = $request->input("data");
        $datasArr = json_decode($data, true);

        $id = strtolower($request->input("id"));

        $path = storage_path("Centauri/Domains/$id.json");
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

    /**
     * Delete handling of a domain (record) file.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function deleteAjax(Request $request)
    {
        $id = $request->input("id");

        $path = storage_path("Centauri/Domains/$id.json");
        unlink($path);

        return json_encode([
            "type" => "warning",
            "title" => "Domains",
            "description" => "Deleted Domain-Record with ID '" . $id . "'"
        ]);
    }
}
