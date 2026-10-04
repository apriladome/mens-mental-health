<?php

declare(strict_types=1);

namespace App\Actions\Safety;

use App\Models\EmergencyResource;
use Illuminate\Support\Collection;

class ResolveEmergencyHotlinesAction
{
    /**
     * Resolve active emergency resources for a region (defaults to US national hotlines).
     *
     * @return Collection<int, EmergencyResource>
     */
    public function execute(string $countryCode = 'US', ?string $regionCode = null): Collection
    {
        $query = EmergencyResource::where('country_code', strtoupper($countryCode));

        if ($regionCode) {
            $query->where(function ($q) use ($regionCode) {
                $q->where('region_code', strtoupper($regionCode))
                  ->orWhereNull('region_code');
            });
        } else {
            $query->whereNull('region_code');
        }

        $resources = $query->orderBy('is_veteran_specific', 'desc')->get();

        // Fallback: If no regional resources match, return any US national 24/7 resources
        if ($resources->isEmpty()) {
            return EmergencyResource::where('country_code', 'US')
                ->whereNull('region_code')
                ->get();
        }

        return $resources;
    }
}