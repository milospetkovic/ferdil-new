<?php

namespace App\Observers;

use App\Models\Entity\Company;

class CompanyObserver
{
    /**
     * Handle the Company "created" event.
     *
     * @param  \App\Models\Entity\Company  $company
     * @return void
     */
    public function created(Company $company)
    {
        //
    }

    /**
     * Handle the Company "updated" event.
     *
     * @param  \App\Models\Entity\Company  $company
     * @return void
     */
    public function updated(Company $company)
    {
        //
    }

    /**
     * Handle the Company "deleting" event.
     *
     * @param  \App\Models\Entity\Company  $company
     * @return void
     */
    public function deleting(Company $company)
    {
        $company->workers()->delete();
    }

    /**
     * Handle the Company "deleted" event.
     *
     * @param  \App\Models\Entity\Company  $company
     * @return void
     */
    public function deleted(Company $company)
    {
        //
    }

    /**
     * Handle the Company "restored" event.
     *
     * @param  \App\Models\Entity\Company  $company
     * @return void
     */
    public function restored(Company $company)
    {
        //
    }

    /**
     * Handle the Company "force deleted" event.
     *
     * @param  \App\Models\Entity\Company  $company
     * @return void
     */
    public function forceDeleted(Company $company)
    {
        //
    }
}
