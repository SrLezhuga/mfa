<?php

class EnviayaAPI
{
    const APP_ID = 1;
    const CARRIER_ACCOUNT = 1;
    const DOMAIN = 'enviaya.com.mx';
    const TIMEOUT = 15;

    private $domain;
    private $enviaya_account;
    private $carrier_account;
    private $api_key;
    private $timeout;
    private $app_id;

    function __construct($data)
    {
        $this->api_key = $data['api_key'];
        $this->enviaya_account = $data['enviaya_account'];
        $this->carrier_account = isset($data['carrier_account']) ? $data['carrier_account'] : self::CARRIER_ACCOUNT;
        $this->app_id = isset($data['app_id']) ? $data['app_id'] : self::APP_ID;
        $this->domain = isset($data['domain']) ? $data['domain'] : self::DOMAIN;
        $this->timeout = isset($data['timeout']) ? $data['timeout'] : self::TIMEOUT;
    }

    private function request($url, $method = 'GET', $data = [])
    {
        $ch = curl_init();
        $data = json_encode($data);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result);
    }

    public function calculate($props)
    {
        $request = [
            'enviaya_account' => $this->enviaya_account,
            'carrier_account' => $this->carrier_account,
            'api_key' => $this->api_key,
            'api_application_id' => $this->app_id,
            'rate_currency' => isset($props['rate_currency']) ? $props['rate_currency'] : null,
            'shipment' => [
                'shipment_type' => isset($props['shipment_type']) ? $props['shipment_type'] : null,
                'parcels' => isset($props['parcels']) ? $props['parcels'] : null,
            ],
            'origin_direction' => [
                'country_code' => isset($props['origin_country_code']) ? $props['origin_country_code'] : null,
                'postal_code' => isset($props['origin_postal_code']) ? $props['origin_postal_code'] : null,
                'state_code' => isset($props['origin_state_code']) ? $props['origin_state_code'] : null,
            ],
            'destination_direction' => [
                'country_code' => isset($props['destination_country_code']) ? $props['destination_country_code'] : null,
                'postal_code' => isset($props['destination_postal_code']) ? $props['destination_postal_code'] : null,
                'state_code' => isset($props['destination_state_code']) ? $props['destination_state_code'] : null,
            ],
            'insured_value_currency' => isset($props['insured_value_currency']) ? $props['insured_value_currency'] : null,
            'currency' => isset($props['currency']) ? $props['currency'] : null,
            'order_total_amount' => isset($props['order_total_amount']) ? $props['order_total_amount'] : null,
            'locale' => isset($props['locale']) ? $props['locale'] : null
        ];

        $response = $this->request("https://{$this->domain}/api/v1/rates", 'POST', $request);

        $result = [
            'request' => $request,
            'response' => $response
        ];

        return $result;
    }

    public function create($props)
    {
        $request = [
            'enviaya_account' => $this->enviaya_account,
            'carrier_account' => $this->carrier_account,
            'api_key' => $this->api_key,
            'api_application_id' => $this->app_id,
            'rate_id' => isset($props['rate_id']) ? $props['rate_id'] : null,
            'rate_currency' => isset($props['rate_currency']) ? $props['rate_currency'] : null,
            'carrier' => isset($props['carrier']) ? $props['carrier'] : null,
            'carrier_service_code' => isset($props['carrier_service_code']) ? $props['carrier_service_code'] : null,
            'origin_direction' => [
                'full_name' => isset($props['origin_full_name']) ? $props['origin_full_name'] : null,
                'company' => isset($props['origin_company']) ? $props['origin_company'] : null,
                'country_code' => isset($props['origin_country_code']) ? $props['origin_country_code'] : null,
                'postal_code' => isset($props['origin_postal_code']) ? $props['origin_postal_code'] : null,
                'direction_1' => isset($props['origin_direction_1']) ? $props['origin_direction_1'] : null,
                'city' => isset($props['origin_city']) ? $props['origin_city'] : null,
                'phone' => isset($props['origin_phone']) ? $props['origin_phone'] : null,
                'state_code' => isset($props['origin_state_code']) ? $props['origin_state_code'] : null,
                'neighborhood' => isset($props['origin_neighborhood']) ? $props['origin_neighborhood'] : null,
                'district' => isset($props['origin_district']) ? $props['origin_district'] : null,
                'email' => isset($props['origin_email']) ? $props['origin_email'] : null,
            ],
            'destination_direction' => [
                'full_name' => isset($props['destination_full_name']) ? $props['destination_full_name'] : null,
                'company' => isset($props['destination_company']) ? $props['destination_company'] : null,
                'country_code' => isset($props['destination_country_code']) ? $props['destination_country_code'] : null,
                'postal_code' => isset($props['destination_postal_code']) ? $props['destination_postal_code'] : null,
                'direction_1' => isset($props['destination_direction_1']) ? $props['destination_direction_1'] : null,
                'city' => isset($props['destination_city']) ? $props['destination_city'] : null,
                'phone' => isset($props['destination_phone']) ? $props['destination_phone'] : null,
                'state_code' => isset($props['destination_state_code']) ? $props['destination_state_code'] : null,
                'district' => isset($props['destination_district']) ? $props['destination_district'] : null,
                'email' => isset($props['destination_email']) ? $props['destination_email'] : null,
            ],
            'shipment' => [
                'shipment_type' => isset($props['shipment_type']) ? $props['shipment_type'] : null,
                'parcels' => isset($props['parcels']) ? $props['parcels'] : null,
                'content' => isset($props['content']) ? $props['content'] : null,
            ],
            'label_format' => isset($props['label_format']) ? $props['label_format'] : null,
            'locale' => isset($props['locale']) ? $props['locale'] : null,
            'shop_order_id' => isset($props['shop_order_id']) ? $props['shop_order_id'] : null,
            'shop_domain' => $_SERVER['SERVER_NAME']
        ];

        $response = $this->request("https://{$this->domain}/api/v1/shipments", 'POST', $request);

        $result = [
            'request' => $request,
            'response' => $response
        ];

        return $result;
    }

    function track($props)
    {
        $request = [
            'enviaya_account' => $this->enviaya_account,
            'api_key' => $this->api_key,
            'shipment_number' => isset($props['shipment_number']) ? $props['shipment_number'] : null,
            'carrier' => isset($props['carrier']) ? $props['carrier'] : null
        ];

        return $this->request("https://{$this->domain}/api/v1/trackings", 'POST', $request);
    }

    function directions()
    {
        return $this->request("https://{$this->domain}/api/v1/directions?api_key={$this->api_key}", 'GET', null);
    }

    function get_accounts()
    {
        return $this->request("https://{$this->domain}/api/v1/get_accounts?api_key={$this->api_key}", 'GET', null);
    }
}
