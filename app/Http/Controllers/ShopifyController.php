<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ShopifyController extends Controller
{
    public function index()
    {
        try {
            $client = new Client([
                'base_uri' => 'https://'.env('STORE_NAME').'.myshopify.com',
                'headers' => ['Content-Type' => 'application/json']
            ]);
            $response = $client->get('/admin/api/2024-04/products.json', [
                'headers' => [
                    'X-Shopify-Access-Token' => env('APP_ACCESS_TOKEN'),
                ]
            ]);
            return json_decode($response->getBody(), true);
        } catch (Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    public function view($product_id)
    {
        try {
            if (!is_numeric($product_id)) {
                throw new Exception('Invalid Product Id');
            }
            $client = new Client([
                'base_uri' => 'https://'.env('STORE_NAME').'.myshopify.com',
            ]);
            $response = $client->get('/admin/api/2024-04/products/' . $product_id . '.json', [
                'headers' => [
                    'X-Shopify-Access-Token' => env('APP_ACCESS_TOKEN'),
                ]
            ]);
            return json_decode($response->getBody(), true);
        } catch (Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    public function create(Request $request)
    {
        try {
            $client = new Client([
                'base_uri' => 'https://'.env('STORE_NAME').'.myshopify.com',
            ]);
            $response = $client->post('/admin/api/2024-04/products.json', [
                'headers' => [
                    'X-Shopify-Access-Token' => env('APP_ACCESS_TOKEN'),
                ],
                'json' => $request->all()
            ]);
            return json_decode($response->getBody(), true);
        } catch (Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    public function update(Request $request, $product_id)
    {
        try {
            if (!is_numeric($product_id)) {
                throw new Exception('Invalid Product Id');
            }
            $client = new Client([
                'base_uri' => 'https://'.env('STORE_NAME').'.myshopify.com',
            ]);
            $response = $client->put('/admin/api/2024-04/products/' . $product_id . '.json', [
                'headers' => [
                    'X-Shopify-Access-Token' => env('APP_ACCESS_TOKEN'),
                ],
                'json' => $request->all()
            ]);
            return json_decode($response->getBody(), true);
        } catch (Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    public function destroy($product_id)
    {
        try {
            if (!is_numeric($product_id)) {
                throw new Exception(('Invalid Product Id'));
            }
            $client = new Client([
                'base_uri' => 'https://'.env('STORE_NAME').'.myshopify.com',
            ]);
            $response = $client->delete('/admin/api/2024-04/products/' . $product_id . '.json', [
                'headers' => [
                    'X-Shopify-Access-Token' => env('APP_ACCESS_TOKEN'),
                ]
            ]);
            return json_decode($response->getBody(), true);
        } catch (Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    public function curl($customer_id)
    {
        try {
            if (!is_numeric($customer_id)) {
                throw new Exception('Invalid Customer ID');
            }
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://'.env('STORE_NAME').'.myshopify.com/admin/customers/' . $customer_id . '.json',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'X-Shopify-Access-Token: '.env('APP_ACCESS_TOKEN').'',
                ),
            )
            );

            $response = curl_exec($curl);

            curl_close($curl);
            return json_decode($response, true);
        } catch (Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }

    }

    public function graphQLGuzzle(Request $request){
        try{
            $client = new Client();
            $res = $client->post('https://'.env('STORE_NAME').'.myshopify.com/admin/api/2024-04/graphql.json', [
                'headers' => [
                    'X-Shopify-Access-Token' => env('APP_ACCESS_TOKEN'),
                    'Content-Type' => 'application/json'
                ],
                'json'=> $request->all(),
            ]);
            return json_decode($res->getBody(), true);
        }catch(Exception $e){
            return ['error' => $e->getMessage()];
        }
    }

    public function graphQLCurl(Request $request){
        try{
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://'.env('STORE_NAME').'.myshopify.com/admin/api/2024-04/graphql.json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($request->all()),
            CURLOPT_HTTPHEADER => array(
                'X-Shopify-Access-Token: '.env('APP_ACCESS_TOKEN').'',
                'Content-Type: application/json',
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return json_decode($response, true);
        }catch(Exception $e){
            return ['error' => $e->getMessage()];
        }
    }
}
