<?php

namespace App\DataTables;

use App\Models\App;
use App\Services\Facebook;
use Carbon\Carbon;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AppsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('photo', function ($app){
                return "<img src='".$app->photo_url."' class='direct-chat-img'>";
            })
            ->editColumn('created_at', fn($admin) => Carbon::parse($admin->created_at)->format('d M, Y'))
            ->addColumn('action', 'apps.action')
            ->rawColumns(['photo', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param App $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(App $model)
    {
        return $model->where(['user_id' => auth()->id()])->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html()
    {
        return $this->builder()
            ->addTableClass('table-bordered table-striped')
            ->autoWidth(false)
            ->setTableId('apps-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('create'),
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('photo'),
            Column::make('name'),
            Column::make('client_id'),
            Column::make('created_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Apps_' . date('YmdHis');
    }
}
