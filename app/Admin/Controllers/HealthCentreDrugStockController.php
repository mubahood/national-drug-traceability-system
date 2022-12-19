<?php

namespace App\Admin\Controllers;

use App\Models\DistrictDrugStock;
use App\Models\HealthCentre;
use App\Models\HealthCentreDrugStock;
use App\Models\Utils;
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
    protected $title = 'Health centre drug stocks';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new HealthCentreDrugStock());
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


        $grid->column('health_centre_id', __('Health centre'))
            ->display(function () {
                return $this->health_centre->name;
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

        /* $data = new HealthCentreDrugStock();
        $data->district_drug_stock_id = 1;
        $data->created_by = Auth::user()->id;
        $data->health_centre_id = 1;
        $data->original_quantity_temp = 2;
        $data->save();
 */

        $form = new Form(new HealthCentreDrugStock());
        $stocks = [];
        foreach (DistrictDrugStock::all() as $stock) {
            if ($stock->current_quantity < 1) {
                continue;
            }
            $stocks[$stock->id] = "$stock->id. " . $stock->drug_category->name_of_drug . " - Batch #" .
                $stock->batch_number . ", Available Quantity: " . $stock->current_quantity_text;
        }

        $centres = [];
        foreach (HealthCentre::all() as $item) {
            $centres[$item->id] = "$item->id " . $item->name;
        }

        $form->select('district_drug_stock_id', 'Drug stock')
            ->options($stocks)
            ->rules('required');

        $form->select('health_centre_id', 'Health centre')
            ->options($centres)
            ->rules('required');

        $form->divider();
        $form->decimal('original_quantity_temp', 'Drug quantity (in Killograms for solids, in Litters for Liquids)')
            ->rules('required');

        $form->hidden('created_by', __('Created by'))->default(Auth::user()->id);

        return $form;
    }
}
