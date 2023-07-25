<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Models\User;
use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

date_default_timezone_set('America/Mexico_City');


class InfoController extends Controller
{

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */

    public function getLatestUsers(Request $request)
    {
        $users = User::where('id_profile', 2)->latest('id')->take(5)->get();
        return $this->sendResponse($users, 'Ok');
    }

    public function getBalance(Request $request)
    {
        $totalUsers = count(User::all());
        $totalSales = count(Sale::all());
        $totalProducts = count(Product::all());
        $data = [
            "total_users" => $totalUsers,
            "total_sales" => $totalSales,
            "total_products" => $totalProducts,

        ];
        return response()->json($data, 200);
    }


    public function getBalanceSaleToday(Request $request)
    {

        $sales_yesterday = Sale::select(DB::raw('SUM(total) as absolute_total_day'))
            ->whereDate('sale_date', Carbon::now()->subDay())
            ->groupBy('sale_date')
            ->havingRaw('SUM(total) > ?', [0])
            ->first();

        $sales_today = Sale::select(DB::raw('SUM(total) as absolute_total_day'))
            ->whereDate('sale_date', Carbon::now())
            ->groupBy('sale_date')
            ->havingRaw('SUM(total) > ?', [0])
            ->first();

        $total_yesterday = 1;
        $total_today = 1;

        if ($sales_yesterday != NULL) {
            $total_yesterday = $sales_yesterday->absolute_total_day;
        }

        if ($sales_today != NULL) {
            $total_today = $sales_today->absolute_total_day;
        }

        $percentaje_earning = (($total_today - $total_yesterday) / $total_yesterday) * 100;

        $balance_sale_today = [
            "total_absolute_yesterday" => $total_yesterday,
            "total_absolute_today" => $total_today,
            "percentaje_earning" => (int) $percentaje_earning
        ];

        return response()->json($balance_sale_today, 200);
    }

    public function getNumberSalesWeek(Request $requet)
    {
        $week_sales = [];

        for ($i = 7; $i >= 0; $i--) {
            $current_date = Carbon::now()->subDay($i);

            $day_sale = [
                "date" => $current_date->toDateString(),
                "day" => ucfirst($current_date->locale('es_ES')->isoFormat('dddd')),
                "count_sale" => count(Sale::whereDate('sale_date', $current_date)->get())
            ];

            array_push($week_sales, $day_sale);
        }
        return response()->json($week_sales, 200);
    }

    public function getMoreSalesProducts(Request $request)
    {
        $products = Product::all();

        $products_total = [];

        if ($products != NULL) {

            foreach ($products as $product) {
                $detail_by_product = SaleDetail::select('id_product', DB::raw('SUM(amount) as total_amount'))
                    ->where('id_product', $product->id)
                    ->groupBy('id_product')
                    ->havingRaw('SUM(amount) > ?', [0])
                    ->first();
                if ($detail_by_product) {
                    $current_product = [
                        "name" => Product::where('id', $detail_by_product->id_product)->first()->name,
                        "amount_sales" => $detail_by_product->total_amount
                    ];
                    array_push($products_total, $current_product);
                }
            }

            usort($products_total, function ($a, $b) {
                return $b["amount_sales"] - $a["amount_sales"];
            });

            $topFive = array_slice($products_total, 0, 5);

            return response()->json($topFive, 200);
        }

        return response('No data', 200);
    }


    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }



    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
}
