<?php
/**
 * Created by PhpStorm.
 * User: dev7
 * Date: 9/19/19
 * Time: 11:12 AM
 */

namespace App\Repositories;


use App\Models\SystemConfig;

class SystemConfigRepository
{
    public function first()
    {
        return SystemConfig::where('company_id', company_id())->first();
    }

    public function createOrUpdate($request)
    {
        $config = $this->first();

        if ($config) {
            return $config->update($request);
        }
        return SystemConfig::create($request);

    }

}