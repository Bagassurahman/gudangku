<?php

namespace App\Http\Controllers\Finance;

use App\TransactionDetail;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductSalesReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('product_sales_report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $filter = $request->input('filter', 'all');

        $query = Product::leftJoin('transaction_details', function ($join) {
            $join->on('products.id', '=', 'transaction_details.product_id')
                ->where(function ($query) {
                    $query->where('transaction_details.qty', '!=', 0)
                        ->orWhereNull('transaction_details.qty');
                });
        })
            ->selectRaw('products.name, SUM(transaction_details.qty) as total_qty, SUM(transaction_details.total) as total_amount')
            ->groupBy('products.name')
            ->orderByDesc('total_qty');

        // $query = Product::leftJoin('transaction_details', function ($join) {
        //     $join->on('products.id', '=', 'transaction_details.product_id')
        //         ->where(function ($query) {
        //             $query->where('transaction_details.qty', '!=', 0)
        //                 ->orWhereNull('transaction_details.qty');
        //         });
        // })
        //     ->leftJoin('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
        //     ->selectRaw('products.name, transactions.customer_type, SUM(transaction_details.qty) as total_qty, SUM(transaction_details.total) as total_amount')
        //     ->groupBy('products.name', 'transactions.customer_type')
        //     ->orderByDesc('total_qty')
        //     ->where('transactions.customer_type', $customerType);




        if ($filter == 'daily') {
            $query->where(function ($query) {
                $query->whereDate('transaction_details.created_at', '=', Carbon::today()->toDateString())
                    ->orWhereNull('transaction_details.created_at');
            });
        } elseif ($filter == 'monthly') {
            $query->where(function ($query) {
                $query->whereYear('transaction_details.created_at', '=', Carbon::today()->year)
                    ->whereMonth('transaction_details.created_at', '=', Carbon::today()->month)
                    ->orWhereNull('transaction_details.created_at');
            });
        } elseif ($filter == 'yearly') {
            $query->where(function ($query) {
                $query->whereYear('transaction_details.created_at', '=', Carbon::today()->year)
                    ->orWhereNull('transaction_details.created_at');
            });
        }



        $productSales = $query->get();
        // foreach ($productSales as $productSales) {
        //     $tot = $productSales->total_qty;
        // }
        // dd($tot);

        return view('finance.product-sales-report.index', compact('productSales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
