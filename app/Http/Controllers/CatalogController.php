<?php

namespace App\Http\Controllers;

use App\View\ViewModels\CatalogViewModel;
use Domain\Catalog\Models\Category;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    const VIEW_REQUEST_KEY = 'view';
    const VIEW_SESSION_KEY = 'view';

    const AVAILABLE_VIEW_TYPES = [
        'grid',
        'list',
    ];
    const DEFAULT_VIEW_TYPE = 'grid';

    public function __invoke(Request $request, ?Category $category = null): CatalogViewModel
    {
        $viewType = $this->getViewType($request);

        return (new CatalogViewModel($category, $viewType))
            ->view('catalog.index');
    }

    private function getViewType(Request $request): string
    {
        $type = $request->get(self::VIEW_REQUEST_KEY);
        if (in_array($type, self::AVAILABLE_VIEW_TYPES)) {
            $request->session()->put(self::VIEW_SESSION_KEY, $type);

            return $type;
        }

        $type = $request->session()->get(self::VIEW_SESSION_KEY);
        if (in_array($type, self::AVAILABLE_VIEW_TYPES)) {
            return $type;
        }

        return self::DEFAULT_VIEW_TYPE;
    }
}
