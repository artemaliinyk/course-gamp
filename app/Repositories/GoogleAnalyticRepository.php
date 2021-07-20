<?php

namespace App\Repositories;

use Irazasyed\LaravelGAMP\Facades\GAMP;

class GoogleAnalyticRepository
{
    private function getClientId($data)
    {
        if ($data->session()->has('ga_client_id'))
            $clientId = $data->session()->get('ga_client_id');
        else {
            $clientId = uniqid();
            $data->session()->put('ga_client_id', $clientId);
        }

        return $clientId;
    }

    public function sendEvent($data)
    {
        try {
            $gamp = GAMP::setClientId($this->getClientId($data));

            if(!is_null($data->ip()) && $data->ip() != '127.0.0.1') {
                $gamp->setIpOverride($data->ip());
            }

            if(!is_null($data->server('HTTP_REFERER'))) {
                $gamp->setDocumentReferrer($data->server('HTTP_REFERER'));
            }

            if(!is_null($data->server('HTTP_USER_AGENT'))) {
                $gamp->setUserAgentOverride($data->server('HTTP_USER_AGENT'));
            }

            $gamp->setDocumentPath($data->path());

            $gamp->setEventCategory('GAMPTrack')
                ->setEventAction('init')
                ->setEventLabel('GAMP Track Label')
                ->sendEvent();

            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
