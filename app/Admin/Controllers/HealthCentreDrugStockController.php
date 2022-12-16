<?php

namespace App\Admin\Controllers;

use App\Models\DistrictDrugStock;
use App\Models\HealthCentreDrugStock;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;

class HealthCentreDrugStockController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'HealthCentreDrugStock';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new HealthCentreDrugStock());

        $grid->column('id', __('Id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('drug_category_id', __('Drug category id'));
        $grid->column('drug_stock_id', __('Drug stock id'));
        $grid->column('district_id', __('District id'));
        $grid->column('created_by', __('Created by'));
        $grid->column('health_centre_id', __('Health centre id'));
        $grid->column('original_quantity', __('Original quantity'));
        $grid->column('current_quantity', __('Current quantity'));

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
        $show = new Show(HealthCentreDrugStock::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('drug_category_id', __('Drug category id'));
        $show->field('drug_stock_id', __('Drug stock id'));
        $show->field('district_id', __('District id'));
        $show->field('created_by', __('Created by'));
        $show->field('health_centre_id', __('Health centre id'));
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
        $form = new Form(new HealthCentreDrugStock());
        $stocks = [];
        foreach (DistrictDrugStock::all() as $stock) {
            if ($stock->current_quantity < 1) {
                continue;
            }
            $stocks[$stock->id] = $stock->drug_category->name_of_drug . " - Batch #" .
                $stock->batch_number . ", Available Quantity: " . $stock->current_quantity_text;
        }

        $form->select('district_drug_stock_id', 'Drug stock')
            ->options($stocks)
            ->rules('required'); 
 
        $form->hidden('created_by', __('Created by'))->default(Auth::user()->id);
        $form->number('health_centre_id', __('Health centre id'));
        $form->number('original_quantity', __('Original quantity'));
        $form->number('current_quantity', __('Current quantity'));

        return $form;
    }
}
