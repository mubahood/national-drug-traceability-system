<?php

namespace App\Admin\Controllers;

use App\Models\HealthCentreDrugStock;
use App\Models\PatientDrugRecord;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PatientDrugRecordController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'PatientDrugRecord';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PatientDrugRecord());

        $grid->column('id', __('Id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('district_id', __('District id'));
        $grid->column('created_by', __('Created by'));
        $grid->column('patient_id', __('Patient id'));
        $grid->column('drug_category_id', __('Drug category id'));
        $grid->column('drug_stock_id', __('Drug stock id'));
        $grid->column('health_centre_id', __('Health centre id'));
        $grid->column('district_drug_stock_id', __('District drug stock id'));

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
        $show = new Show(PatientDrugRecord::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('district_id', __('District id'));
        $show->field('created_by', __('Created by'));
        $show->field('patient_id', __('Patient id'));
        $show->field('drug_category_id', __('Drug category id'));
        $show->field('drug_stock_id', __('Drug stock id'));
        $show->field('health_centre_id', __('Health centre id'));
        $show->field('district_drug_stock_id', __('District drug stock id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $rec = new PatientDrugRecord();
        $rec->is_new_patient = 'Yes';
        $rec->patient_name = 'Bwambale';
        $rec->patient_sex = 'Male';
        $rec->patient_address = 'Bwera, Kasese';
        $rec->patient_phone_number = '0783204665';
        $rec->nin = '1400019201011';
        $rec->fingerprint = '1400019201011';
        $rec->patient_district_id = 88;
        $rec->health_centre_drug_stock_id = 1;
        $rec->quantity = 5;
        $rec->save();

        $form = new Form(new PatientDrugRecord());

        $stocks = [];
        foreach (HealthCentreDrugStock::all() as $stock) {
            if ($stock->current_quantity < 1) {
                continue;
            }
            $stocks[$stock->id] = "$stock->id. " . $stock->drug_category->name_of_drug . " - Batch #" .
                $stock->batch_number . ", Available Quantity: " . $stock->current_quantity_text;
        }


        $form->radio('is_new_patient', 'Is new patient?')
            ->options([
                'Yes' => 'Yes',
                'No' => 'No',
            ])
            ->when('Yes', function ($f) {
                $f->text('patient_name', 'Patient name');
                $f->radio('patient_sex', 'Patient sex')->options([
                    'Male' => ' Male',
                    'Female' => ' Female',
                ])->rules('required');

                $f->radio('patient_address', 'Patient address')
                    ->rules('required');

                $f->text('patient_phone_number', 'Phone number')
                    ->rules('required');

                $f->text('nin', 'Patient\'s National ID  Numbew')
                    ->rules('required');

                $district_ajax_url = url(
                    '/api/ajax?'
                        . "&search_by_1=name"
                        . "&search_by_2=id"
                        . "&query_parent=0"
                        . "&model=Location"
                );
                $f->select('patient_district_id', 'Select District')
                    ->ajax($district_ajax_url)
                    ->rules('required');

                $f->text('fingerprint', 'Patient\'s Fingerprint')
                    ->rules('required');

                return $f;
            })
            ->when('No', function ($f) {
                $f->text('fingerprint', 'Patient\'s Fingerprint')
                    ->rules('required');
            })
            ->rules('required');

        $form->divider();
        $form->select('health_centre_drug_stock_id', 'Select drug')
            ->options($stocks)
            ->rules('required');

        $form->decimal('quantity', 'Drug quantity')
            ->help('Number of tablets for solid drugs OR Number of bottles/bags for liquid drugs or syrups.')
            ->rules('required');



        /*         $form->number('district_id', __('District id'));
        $form->number('created_by', __('Created by'));
        $form->number('patient_id', __('Patient id'));
        $form->number('drug_category_id', __('Drug category id'));
        $form->number('drug_stock_id', __('Drug stock id'));
        $form->number('health_centre_id', __('Health centre id'));
        $form->number('district_drug_stock_id', __('District drug stock id'));
 */
        return $form;
    }
}
