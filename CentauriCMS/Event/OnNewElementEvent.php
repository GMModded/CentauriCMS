<?php
namespace Centauri\CMS\Event;

use Centauri\CMS\Model\Page;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Cache;

class OnNewElementEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $channel = "centauri-channel";
    public $event = "pagereload";
    public $message;

    public function __construct($dataArr)
    {
        $pageUid = $dataArr["uid"];
        $page = Page::where("uid", $pageUid)->get()->first();

        $domainConfig = $page->getDomain();
        $host = $domainConfig->domain;

        $uniqid = preg_replace("/[^a-zA-Z0-9]+/", "", $host) . "-" . $pageUid;
        Cache::pull($uniqid);

        $messageArr = [];

        foreach($dataArr as $key => $value) {
            if($key != "uid") {
                $messageArr[$key] = $value;
            }
        }

        $this->message = $messageArr;
    }

    public function broadcastOn()
    {
        return [
            $this->channel
        ];
    }

    public function broadcastAs()
    {
        return $this->event;
    }
}
