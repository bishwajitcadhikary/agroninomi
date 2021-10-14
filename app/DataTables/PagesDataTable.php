<?php

namespace App\DataTables;

use App\Models\Page;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PagesDataTable extends DataTable
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
            /*->editColumn('link', function ($page){
                return '<a href="'.$page->link.'" class="btn btn-sm btn-light" target="_blank"><i class="fas fa-external-link-alt"></i></a>';
            })
            ->editColumn('verification_status', function ($page){
                if ($page->verification_status == 'blue_verified'){
                    return '<i class="fas fa-check-circle text-blue"></i>';
                }
                return '<i class="fas fa-times-circle text-danger"></i>';
            })*/
            ->editColumn('created_at', fn($page) => $page->created_at->diffForHumans())
            ->addColumn('action', 'pages.action')
            ->rawColumns(['link', 'verification_status', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Page $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Page $model)
    {
        if (auth()->user()->hasRole('client')) {
            return $model->where(['user_id' => auth()->id()])->newQuery();
        }
        return $model->newQuery();

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
            ->setTableId('pages-table')
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
//            Column::make('name'),
            Column::make('page_id'),
//            Column::make('link'),
//            Column::make('verification_status')->addClass('text-center')->title('Verified'),
            Column::make('created_at')->title('Added At'),
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
        return 'Pages_' . date('YmdHis');
    }
}
