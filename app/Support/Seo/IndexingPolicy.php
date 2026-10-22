<?php

namespace App\Support\Seo;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

final class IndexingPolicy
{
    private const IGNORED_PARAMS = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'gclid', 'fbclid', 'msclkid'];

    public function decide(Request $request, LengthAwarePaginator $projects): array
    {
        $params = array_diff_key($request->query(), array_flip(self::IGNORED_PARAMS));
        $page = $projects->currentPage();
        $filtersOrSort = array_diff_key($params, ['page' => 1]) !== [];
        $clean = url()->current();

        if ($filtersOrSort || ($page === 1 && isset($params['page']))) {
            return ['noindex' => true, 'canonical' => $clean, 'reason' => 'filtered-or-sorted'];
        }

        if ($page > 1) {
            return ['noindex' => true, 'canonical' => $clean . '?page=' . $page, 'reason' => 'paginated'];
        }

        return ['noindex' => $projects->total() < 1, 'canonical' => $clean, 'reason' => 'indexable'];
    }
}
