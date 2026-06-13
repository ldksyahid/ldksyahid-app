<?php

namespace App\Http\Controllers\CelenganSyahid\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function dashboardCelenganSyahid()
    {
        return view('admin-page.service.celengan-syahid.dashboard.index', ['title' => 'Celengan Syahid']);
    }

    /**
     * Dashboard chart data (JSON) for the analytics dashboard.
     *
     * Replaces the former Python/SVM script. That "model" trained an SVM whose
     * label was also one of its input features (data leakage), so its output was
     * identical to plain amount/age binning. This aggregates PAID donations
     * directly in PHP/SQL and returns the same JSON shape the charts expect.
     * Cached for 10 minutes.
     */
    public function dashboardData()
    {
        $data = Cache::remember('celsyahid_dashboard_charts', now()->addMinutes(10), function () {
            $donations = Donation::where('payment_status', 'PAID')
                ->get(['jumlah_donasi', 'usia']);

            $donationCategories = [
                'Low (0 - 25k)',
                'Moderately Low (26k - 50k)',
                'Moderate (51k - 100k)',
                'Moderately High (101k - 250k)',
                'High (> 251k)',
            ];
            $ageCategories = [
                'Children (5-11 years old)',
                'Teenagers (12-25 years old)',
                'Adults (26-45 years old)',
                'Elderly (46-65 years old)',
                'Other Ages',
            ];

            // class_counts: fixed 5-slot array indexed by donation class (0-4)
            $classCounts = array_fill(0, 5, 0);
            $ageCounts   = array_fill_keys($ageCategories, 0);
            $crossTab    = []; // [ageCategory][donationCategory] => count

            foreach ($donations as $donation) {
                $classIndex       = $this->donationClassIndex((int) $donation->jumlah_donasi);
                $ageCategory      = $this->ageCategory($donation->usia);
                $donationCategory = $donationCategories[$classIndex];

                $classCounts[$classIndex]++;
                $ageCounts[$ageCategory]++;
                $crossTab[$ageCategory][$donationCategory] =
                    ($crossTab[$ageCategory][$donationCategory] ?? 0) + 1;
            }

            // Flatten the cross-tab into parallel arrays (matches the old groupby output)
            $ageColumn = $donationColumn = $countColumn = [];
            foreach ($crossTab as $ageCategory => $byDonation) {
                foreach ($byDonation as $donationCategory => $count) {
                    $ageColumn[]      = $ageCategory;
                    $donationColumn[] = $donationCategory;
                    $countColumn[]    = $count;
                }
            }

            return [
                'donation_class' => ['class_counts' => $classCounts],
                'age_category'   => $ageCounts,
                'age_donation'   => [
                    'age_category'      => $ageColumn,
                    'donation_category' => $donationColumn,
                    'donor_count'       => $countColumn,
                ],
            ];
        });

        return response()->json($data);
    }

    /**
     * Map a donation amount (Rupiah) to its class index (0-4).
     */
    private function donationClassIndex(int $amount): int
    {
        if ($amount <= 25000)  return 0;
        if ($amount <= 50000)  return 1;
        if ($amount <= 100000) return 2;
        if ($amount <= 250000) return 3;
        return 4;
    }

    /**
     * Map a donor age to its category label.
     */
    private function ageCategory($usia): string
    {
        $age = is_numeric($usia) ? (int) $usia : -1;
        if ($age >= 5  && $age <= 11) return 'Children (5-11 years old)';
        if ($age >= 12 && $age <= 25) return 'Teenagers (12-25 years old)';
        if ($age >= 26 && $age <= 45) return 'Adults (26-45 years old)';
        if ($age >= 46 && $age <= 65) return 'Elderly (46-65 years old)';
        return 'Other Ages';
    }
}
