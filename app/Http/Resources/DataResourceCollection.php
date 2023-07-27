<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DataResourceCollection extends ResourceCollection
{
    private array $pagination;

    /**
     * @param $resource
     */
    public function __construct($resource)
    {

        $this->pagination = [
            'count' => $resource->count(),
            'per_page' => $resource->perPage(),
            'current_page' => $resource->currentPage(),
            'has_more_pages' => $resource->hasMorePages(),
            'total' => $resource->total(),
            'total_pages' => $resource->lastPage(),
        ];

        $resource = $resource->getCollection();

        parent::__construct($resource);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {

        return [
            'data' => $this->collection,
            'pagination' => $this->pagination
        ];
    }
}
