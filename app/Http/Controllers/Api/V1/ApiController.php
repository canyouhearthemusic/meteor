<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;

/**
 * @OA\Info(version="1.0.0",description="WitMe API",title="Witme API Documentation")
 */
class ApiController extends Controller
{
    use ApiResponse;

    protected $policyClass;

    public function include(string $relationship): bool
    {
        $param = request()->get('include');

        if (!isset($param)) {
            return false;
        }

        $includeValues = explode(',', strtolower($param));

        return in_array(strtolower($relationship), $includeValues);
    }

    /**
     * @throws \Exception
     */
    public function isAble($ability, $targetModel)
    {
        if (empty($this->policyClass)) {
            throw new \RuntimeException('Policy class are not set');
        }

        return $this->authorize($ability, [$targetModel, $this->policyClass]);
    }
}
