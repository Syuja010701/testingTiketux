<?php

namespace App\Charts;

use App\Models\ChartOfAccount;
use App\Models\KategoriCoa;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class ProfitLossMonthly
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $coa = ChartOfAccount::with('transaksi')->get();

        $debitTotals = [];
        $creditTotals = [];
        $resultData = [];

        foreach ($coa as $key => $value) {
            foreach ($value->transaksi as $key => $value2) {
                $tanggal = \Carbon\Carbon::parse($value2->tanggal);
                $monthKey = $tanggal->format('Y-m');

                $kategori = ChartOfAccount::with('kategoriCoa')->find($value2->coa_id);
                $kategoriId = optional($kategori->kategoriCoa)->id ?? null;

                if (!isset($debitTotals[$kategoriId][$monthKey])) {
                    $debitTotals[$kategoriId][$monthKey] = 0;
                }
                if (!isset($creditTotals[$kategoriId][$monthKey])) {
                    $creditTotals[$kategoriId][$monthKey] = 0;
                }

                $debitTotals[$kategoriId][$monthKey] += $value2->debit;
                $creditTotals[$kategoriId][$monthKey] += $value2->credit;
            }
        }

        foreach ($debitTotals as $kategoriId => $debitByMonth) {
            foreach ($debitByMonth as $month => $totalDebit) {
                $totalCredit = $creditTotals[$kategoriId][$month];
                $kategori = KategoriCoa::find($kategoriId);

                // Check if the category exists
                $kategoriName = optional($kategori)->nama ?? 'Unknown Category';

                // Store the data in the resultData array
                $resultData[] = [
                    'kategori_id' => $kategoriId,
                    'kategori' => $kategoriName,
                    'month' => $month,
                    'total_debit' => $totalDebit,
                    'total_credit' => $totalCredit,
                ];
            }
        }
        $kategoris_id = [];
        $kategori_nama = [];
        $month = [];
        $debit = [];
        $credit = []; 
        foreach ($resultData as $data) {
                $kategoris_id[] = $data['kategori_id'];
                $kategori_nama[] = $data['kategori'];
                $month[] = $data['month'];
                $debit[] = $data['total_debit'];
                $credit[] = $data['total_credit'];
        }
        // dd($kategoris_id);


        return $this->chart->lineChart()
            ->setTitle('Laporan Profit Loss')
            ->setSubtitle('profit and loss per month')
            ->addData('Income', $credit)
            ->addData('Expense',$debit)
            ->setColors(['#c5e0b4', '#f8cbad'])
            ->setXAxis($month);
    }

    }

