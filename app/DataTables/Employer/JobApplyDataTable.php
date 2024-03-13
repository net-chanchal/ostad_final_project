<?php

namespace App\DataTables\Employer;

use App\Helpers\CoreHelper;
use App\Models\JobApply;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Carbon;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class JobApplyDataTable extends DataTable
{
    private int $jobPostId;

    public function __construct(int $jobPostId)
    {
        parent::__construct();
        $this->jobPostId = $jobPostId;
    }
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('account_id', function (JobApply $jobApply) {
                $account = $jobApply->__get('account');
                $accountId = $account->__get('id');

                $image = CoreHelper::accountAvatarImage($account->__get('avatar_image'));
                $name = $account->__get('name');
                $url = route('employer.jobs.job_seeker', $accountId);

                return <<<HTML
                            <div class="d-flex">
                                $image
                                <div class="ml-2 mt-1">
                                    <b>$name</b><br>
                                    <a href="$url" target="_blank"><small>Show Profile</small></a>
                                </div>
                            <div>
                        HTML;
            })
            ->editColumn('created_at', function (JobApply $jobApply) {
                return Carbon::make($jobApply->__get('created_at'))->format('Y-m-d h:i A') . '<br><small>'
                    . CoreHelper::timeAgo($jobApply->__get('created_at')) . '</small>';
            })
            ->editColumn('interview_date', function(JobApply $jobApply) {
                $datetime = $jobApply->__get('interview_date');

                return <<<HTML
                        <input type="datetime-local" value="$datetime" class="form-control form-control-sm interview_date">
                    HTML;
            })
            ->editColumn('status', function (JobApply $jobApply) {
                $statusList = [
                    'Submitted' => 'bg-warning text-white',
                    'Under Review' => 'bg-info text-white',
                    'Shortlisted' => 'bg-secondary',
                    'Interview Scheduled' => 'bg-light',
                    'Rejected' => 'bg-danger text-white',
                    'Withdrawn' => 'bg-danger text-white',
                    'Hired' => 'bg-success text-white',
                ];
                $status = $jobApply->__get('status');
                $options = [];

                $background = '';

                foreach ($statusList as $item => $colorClass) {
                    $selected = $item == $status ? 'selected' : '';

                    if ($background == '' && $item == $status) {
                        $background = $colorClass;
                    }

                    $options[] = "<option value=\"$item\" $selected>$item</option>";
                }

                $optionsHtml = implode('', $options);

                return <<<HTML
                        <select name="status" class="form-control form-select-sm status $background">
                          $optionsHtml
                        </select>
                    HTML;

            })
            ->addColumn('action', function (JobApply $jobApply) {
                $id = $jobApply->__get('id');

                return <<<HTML
                        <button class="btn btn-sm btn-light job_apply_id" value="$id"><i class="fa fa-save"></i> Save</button>
                    HTML;
            })
            ->rawColumns(['account_id', 'interview_date', 'status', 'created_at', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(): QueryBuilder
    {
        return JobApply::query()
            ->where('job_post_id', $this->jobPostId)
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
            ->addTableClass(['table-application'])
            ->orderBy(0, 'asc')
            ->drawCallback('function() {datatableCallback(); rowSelect()}');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('account_id')->title('Job Seeker'),
            Column::make('interview_date'),
            Column::make('created_at')->title('Apply Date'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }
}
