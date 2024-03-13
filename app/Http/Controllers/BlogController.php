<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $categorySlug = $request->input('category');
        $search = $request->input('search');

        $blogs = Blog::with(['account', 'category']);
        $blogs = $blogs->where('status', '=', 'Publish');

        if ($categorySlug) {
            $blogs = $blogs->whereHas('category', function ($query) use ($categorySlug) {
                $query->where('slug', $categorySlug);
            });
        }

        if ($search) {
            $blogs = $blogs->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhere('short_description', 'like', '%' . $search . '%');
            });
        }

        $blogs = $blogs->orderByDesc('created_at');
        $blogs = $blogs->get();

        $categories = $this->getCategories();

        return view('app.blog.index', compact('blogs', 'categories'));
    }

    /**
     * @param string $slug
     * @return View
     * @throws Exception
     */
    public function detail(string $slug): View
    {
        $blog = Blog::with(['account', 'category'])
            ->where('status', '=', 'Publish')
            ->where('slug', '=', $slug)
            ->orderByDesc('created_at')
            ->firstOrFail();

        $categories = $this->getCategories();

        // Increment view count
        Blog::query()
            ->where('id', $blog->__get('id'))
            ->increment('views');


        return view('app.blog.detail', compact('blog', 'categories'));
    }

    /**
     * @return Builder[]|Collection
     */
    private function getCategories(): Builder|Collection
    {
        return BlogCategory::query()->withCount(['blogs' => function ($query) {
            $query->where('status', 'Publish');
        }])->get();
    }
}
