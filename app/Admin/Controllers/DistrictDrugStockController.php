<?php

namespace App\Admin\Controllers;

use App\Models\DistrictDrugStock;
use App\Models\DrugCategory;
use App\Models\DrugStock;
use App\Models\Utils;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;

class DistrictDrugStockController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'District Drug Stocks';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new DistrictDrugStock());
        $grid->disableActions();
        $grid->disableCreateButton();
        $grid->disableBatchActions();
        $grid->disableExport();

        $grid->column('created_at', __('Date'))->display(function ($t) {
            return Utils::my_date($t);
        })->sortable();

        $grid->column('district_id', __('District'))->display(function ($t) {
            return $this->district->name;
        })->sortable();

        $grid->column('drug_category_id', __('Drug'))->display(function ($t) {
            return $this->drug_category->name_of_drug;
        })->sortable();

        $grid->column('drug_stock_id', __('Batch'))->display(function ($t) {
            return $this->drug_stock->batch_number;
        })->sortable();

        $grid->column('original_quantity', __('Original quantity'))
            ->display(function ($t) {
                return  Utils::quantity_convertor($t, $this->drug_stock->drug_state);
            })->sortable();
        $grid->column('current_quantity', __('Current quantity'))
            ->display(function ($t) {
                return  Utils::quantity_convertor($t, $this->drug_stock->drug_state);
            })->sortable();

        $grid->column('created_by', __('Created by'))
            ->display(function ($t) {
                return $this->creator->name;
            })->sortable();
            

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(DistrictDrugStock::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('drug_category_id', __('Drug category id'));
        $show->field('drug_stock_id', __('Drug stock id'));
        $show->field('district_id', __('District id'));
        $show->field('created_by', __('Created by'));
        $show->field('original_quantity', __('Original quantity'));
        $show->field('current_quantity', __('Current quantity'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $drug_id = 0;
        if (isset($_GET['drug_id'])) {
            $drug_id =  ((int)($_GET['drug_id']));
        }

        $form = new Form(new DistrictDrugStock());
        $form->disableReset();
        $form->disableViewCheck();
        $form->disableCreatingCheck();
        $form->disableEditingCheck();

        $stocks = [];
        foreach (DrugStock::all() as $stock) {
            if ($stock->current_quantity < 1) {
                continue;
            }
            $stocks[$stock->id] = $stock->drug_category->name_of_drug . " - Batch #" .
                $stock->batch_number . ", Available Quantity: " . $stock->current_quantity_text;
        }

        $district_ajax_url = url(
            '/api/ajax?'
                . "&search_by_1=name"
                . "&search_by_2=id"
                . "&query_parent=0"
                . "&model=Location"
        );



        $form->select('drug_stock_id', 'Drug stock')
            ->options($stocks)
            ->default($drug_id)
            ->readOnly()
            ->rules('required');


        $form->select('district_id', 'Select District')
            ->ajax($district_ajax_url)
            ->rules('required');



        $form->hidden('created_by', __('Created by'))->default(Auth::user()->id);

        $form->divider();
        $form->decimal('original_quantity_temp', 'Drug quantity (in Killograms for solids, in Litters for Liquids)')
            ->rules('required');



        return $form;
    }
}
