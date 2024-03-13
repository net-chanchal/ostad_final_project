<?php

namespace App\DataTables\Employer;

use App\Helpers\ConstantHelper;
use App\Helpers\CoreHelper;
use App\Models\JobPost;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class JobDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('created_at', function (JobPost $jobPost) {
                return Carbon::make($jobPost->__get('deadline'))->format('Y-m-d');
            })
            ->editColumn('salary', function (JobPost $jobPost) {
                $salaryObj = $jobPost->__get('salary');
                $attributeObjs = $jobPost->__get('attributes');

                $currency = ConstantHelper::CURRENCY;
                $minSalary = $salaryObj->__get('min_salary');
                $maxSalary = $salaryObj->__get('max_salary');

                if ($maxSalary) {
                    $salary = number_format($minSalary) . ' - ' . number_format($maxSalary);
                } else {
                    $salary = number_format($minSalary);
                }

                $attributeObj = $attributeObjs->first(function ($attributeObj) {
                    return $attributeObj->attribute->type === 'Salary Type';
                });
                $salaryType = $attributeObj ? $attributeObj->attribute->name : '-';

                return "$salary $currency<br><small>$salaryType</small>";
            })
            ->editColumn('deadline', function (JobPost $jobPost) {
                $deadline = Carbon::make($jobPost->__get('deadline'))->format('d M, Y');

                if (!Carbon::make($jobPost->__get('deadline'))->isFuture()) {
                    $deadline .= '<br><small class="text-danger">Deadline Expired</small>';
                }

                return $deadline;
            })
            ->editColumn('job_applies_count', function(JobPost $jobPost) {
                $url = route('employer.jobs.applies', $jobPost->__get('id'));

                return <<<HTML
                            <a href="$url" target="_blank" class="badge badge-light"><u>{$jobPost->__get('job_applies_count')}</u></a>
                        HTML;
            })
            ->editColumn('status', function (JobPost $jobPost) {
                return CoreHelper::status($jobPost->__get('status'), [
                    'Pending' => 'warning',
                    'Publish' => 'success',
                    'Expired' => 'danger',
                ]);
            })
            ->addColumn('action', function (JobPost $jobPost) {
                return
                    CoreHelper::buttonView(route('employer.jobs.show', $jobPost->__get('id'))) .
                    CoreHelper::buttonEdit(route('employer.jobs.edit', $jobPost->__get('id'))) .
                    CoreHelper::buttonDelete(route('employer.jobs.destroy', $jobPost->__get('id')));
            })
            ->rawColumns(['salary', 'deadline', 'job_applies_count', 'status', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(): QueryBuilder
    {
        $accountId = Auth::guard('account')->id();

        return JobPost::with([
            'category',
            'account',
            'attributes',
            'attributeOther',
            'location',
            'salary'
        ])
            ->where('account_id', $accountId)
            ->withCount('jobApplies')
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
            ->orderBy(0)
            ->drawCallback('function() {datatableCallback()}');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('created_at')->title('created'),
            Column::make('title'),
            Column::make('account.name')
                ->name('account_id')
                ->title('employer'),
            Column::make('category.name')
                ->name('job_category_id')
                ->title('category'),
            Column::make('deadline'),
            Column::make('salary', 'salary.min_salary'),
            Column::make('job_applies_count')->title('Applies'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }
}
