<?php

namespace App\Observers;

use App\Models\PenerimaanDonasi;
use App\Models\Donatur;

class PenerimaanDonasiObserver
{
    /**
     * Handle the PenerimaanDonasi "created" event.
     */
    public function created(PenerimaanDonasi $penerimaanDonasi): void
    {
        $this->updateDonaturTotals($penerimaanDonasi);
    }

    /**
     * Handle the PenerimaanDonasi "updated" event.
     * (jika jumlah berubah, misal koreksi nominal)
     */
    public function updated(PenerimaanDonasi $penerimaanDonasi): void
    {
        // Hitung selisih jika jumlah berubah
        $oldJumlah = $penerimaanDonasi->getOriginal('jumlah') ?? 0;
        $newJumlah = $penerimaanDonasi->jumlah ?? 0;
        $selisih   = $newJumlah - $oldJumlah;

        if ($selisih != 0) {
            $donatur = $penerimaanDonasi->donatur;
            if ($donatur) {
                $donatur->total_donasi = ($donatur->total_donasi ?? 0) + $selisih;
                $donatur->saveQuietly(); // tanpa trigger event lagi
            }
        }
    }

    /**
     * Handle the PenerimaanDonasi "deleted" event.
     */
    public function deleted(PenerimaanDonasi $penerimaanDonasi): void
    {
        $this->updateDonaturTotals($penerimaanDonasi, -1 * ($penerimaanDonasi->jumlah ?? 0));
    }

    /**
     * Handle the PenerimaanDonasi "forceDeleted" event.
     */
    public function forceDeleted(PenerimaanDonasi $penerimaanDonasi): void
    {
        $this->updateDonaturTotals($penerimaanDonasi, -1 * ($penerimaanDonasi->jumlah ?? 0));
    }

    /**
     * Update total donasi di tabel donatur
     */
    private function updateDonaturTotals(PenerimaanDonasi $penerimaanDonasi, $delta = null): void
    {
        $donatur = $penerimaanDonasi->donatur;

        if (!$donatur) {
            return;
        }

        // Jika pakai delta (untuk delete/forceDelete)
        if ($delta !== null) {
            $donatur->total_donasi = ($donatur->total_donasi ?? 0) + $delta;
        } else {
            // Created atau update full recalculate (lebih aman jika banyak perubahan)
            $donatur->total_donasi = $donatur->penerimaanDonasi()->sum('jumlah');
        }

        $donatur->saveQuietly(); // hindari infinite loop observer
    }
}