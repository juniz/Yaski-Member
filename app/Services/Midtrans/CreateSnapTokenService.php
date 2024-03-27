<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
    protected $params;

    public function __construct($params)
    {
        parent::__construct();
        $this->params = $params;
    }

    public function getSnapToken()
    {
        $snapToken = Snap::getSnapToken($this->params);
        return $snapToken;
    }
}
