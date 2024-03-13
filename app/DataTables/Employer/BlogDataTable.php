<?php

namespace App\DataTables\Employer;

use App\Helpers\CoreHelper;
use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BlogDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('image', function(Blog $blog) {
                $filename = $blog->__get('image');

                if (!empty($filename) && file_exists(public_path("storage/uploads/blogs/$filename"))) {
                    return CoreHelper::image(asset("storage/uploads/blogs/$filename"), ['width' => '100px']);
                } else {
                    return CoreHelper::image(asset('assets/img/example-image.jpg'), ['width' => '100px']);
                }
            })
            ->editColumn('created_at', function (Blog $blog) {
                return Carbon::make($blog->__get('created_at'))->format('d M, Y h:i A');
            })
            ->editColumn('status', function (Blog $blog) {
                return CoreHelper::status($blog->__get('status'), [
                    'Pending' => 'warning',
                    'Publish' => 'success',
                    'Unpublished' => 'danger',
                ]);
            })
            ->addColumn('action', function (Blog $blog) {
                return
                    CoreHelper::buttonView(route('employer.blogs.show', $blog->__get('id'))) .
                    CoreHelper::buttonEdit(route('employer.blogs.edit', $blog->__get('id'))) .
                    CoreHelper::buttonDelete(route('employer.blogs.destroy', $blog->__get('id')));
            })
            ->rawColumns(['image', 'status', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(): QueryBuilder
    {
        $accountId = Auth::guard('account')->id();

        return Blog::with(['category', 'account'])
            ->where('account_id', $accountId)
            ->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0, 'asc')
            ->drawCallback('function() {datatableCallback()}');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('image'),
            Column::make('title'),
            Column::make('category.name')
                ->name('blog_category_id')
                ->title('category'),
            Column::make('created_at')->title('created'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }
}
