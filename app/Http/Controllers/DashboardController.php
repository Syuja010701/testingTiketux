<?php

namespace App\Http\Controllers;

use App\Charts\ProfitLossMonthly;
use App\Exports\ProfitLossExport;
use App\Models\ChartOfAccount;
use App\Models\KategoriCoa;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
// use Maatwebsite\Excel\Excel;
use PhpParser\Node\Expr\Print_;

class DashboardController extends Controller
{
    public function index(ProfitLossMonthly $profitLoss)
    {
        $categories = ['Salary', 'Other Income', 'Total Income', 'Family Expense', 'Transport Expense', 'Meal Expense', 'Total Expense', 'Net Income'];
        $categoryColors = ['bg-success-subtle', 'bg-success-subtle', 'bg-success', 'bg-danger-subtle', 'bg-danger-subtle', 'bg-danger-subtle', 'bg-danger', 'bg-light'];
    
        $transaksiIncome = Transaksi::selectRaw('YEAR(transaksis.tanggal) as year, MONTH(transaksis.tanggal) as month, chart_of_accounts.kategori_coa_id, SUM(transaksis.credit) as total')
            ->join('chart_of_accounts', 'transaksis.coa_id', '=', 'chart_of_accounts.id')
            ->groupBy('year', 'month', 'chart_of_accounts.kategori_coa_id')
            ->get();

        $transaksiExpense = Transaksi::selectRaw('YEAR(transaksis.tanggal) as year, MONTH(transaksis.tanggal) as month, chart_of_accounts.kategori_coa_id, SUM(transaksis.debit) as total')
            ->join('chart_of_accounts', 'transaksis.coa_id', '=', 'chart_of_accounts.id')
            ->groupBy('year', 'month', 'chart_of_accounts.kategori_coa_id')
            ->get();

        // Membuat struktur data yang diinginkan
        $resultIncome = [];
        $resultExpense = [];

        $total_income = []; // Inisialisasi variabel total_income
        $total_expense = []; // Inisialisasi variabel total_expense

        foreach ($transaksiIncome as $data) {
            $year = $data->year;
            $month = $data->month;
            $kategoriId = $data->kategori_coa_id;
            $total = $data->total;

            // Mengelompokkan berdasarkan tahun dan bulan
            $resultIncome[$year . '-'. $month][$kategoriId] = $total;

            if (!isset($total_income[$year . '-' . $month])) {
                $total_income[$year . '-' . $month] = 0;
            }

            $total_income[$year . '-' . $month] += $total;
        }

    
        foreach ($transaksiExpense as $data) {
            $year = $data->year;
            $month = $data->month;
            $kategoriId = $data->kategori_coa_id;
            $total = $data->total;

            // Mengelompokkan berdasarkan tahun dan bulan
            $resultExpense[$year . '-'. $month][$kategoriId] = $total;

            if (!isset($total_expense[$year . '-' . $month])) {
                $total_expense[$year . '-' . $month] = 0;
            }

            $total_expense[$year . '-' . $month] += $total;

        }
        
        $finalData = [];

        // Menggabungkan data income dan expense ke dalam satu struktur
        foreach ($resultIncome as $key => $income) {
            // Periksa apakah data expense juga ada untuk tahun dan bulan yang sama
            if (isset($resultExpense[$key])) {
                $finalData[$key] = [
                    'Salary' => $income[1] ?? 0,
                    'Other Income' => $income[2] ?? 0,
                    'Total Income' => ($income[1] ?? 0) + ($income[2] ?? 0),
                    'Family Expense' => $resultExpense[$key][3] ?? 0,
                    'Transport Expense' => $resultExpense[$key][4] ?? 0,
                    'Meal Expense' => $resultExpense[$key][5] ?? 0,
                    'Total Expense' => ($resultExpense[$key][3] ?? 0) + ($resultExpense[$key][4] ?? 0) + ($resultExpense[$key][5] ?? 0),
                    'Net Income' => ($income[1] ?? 0) + ($income[2] ?? 0) - (($resultExpense[$key][3] ?? 0) + ($resultExpense[$key][4] ?? 0) + ($resultExpense[$key][5] ?? 0)),
                ];
            }
        }

        return view('dashboard.index', [
            'finalData' => $finalData,
            'chart' => $profitLoss->build(),
            'categories' => $categories,
            'categoryColors' => $categoryColors
        ]);
    }

    public function export() 
    {
        return Excel::download(new ProfitLossExport, ' ProfitLoss.xlsx');
    }
}
