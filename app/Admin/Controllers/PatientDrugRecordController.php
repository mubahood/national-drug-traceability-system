<?php

namespace App\Admin\Controllers;

use App\Models\HealthCentreDrugStock;
use App\Models\PatientDrugRecord;
use App\Models\Utils;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;

class PatientDrugRecordController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Patient drug records';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PatientDrugRecord());

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

        $grid->column('patient_id', __('Patient by'))
            ->display(function () {
                return $this->patient->name;
            })->sortable();

        $grid->column('drug_category_id', __('Drug'))->display(function ($t) {
            return $this->drug_category->name_of_drug;
        })->sortable();

        $grid->column('drug_stock_id', __('Batch'))->display(function ($t) {
            return $this->drug_stock->batch_number;
        })->sortable();
        $grid->column('quantity', __('Quantity'))->display(function ($t) {
            return Utils::quantity_convertor_2($this->quantity, $this->drug_stock);
        })->label()->sortable();

        $grid->column('health_centre_id', __('Health centre'))->display(function ($t) {
            return $this->health_centre->name;
        })->sortable();

        $grid->column('district_drug_stock_id', __('District drug stock'))
            ->display(function () {
                return "#" . $this->district_drug_stock->id;
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
        // $rec = new PatientDrugRecord();
        // $rec->is_new_patient = 'No';
        // $rec->patient_name = 'Bwambale';
        // $rec->patient_sex = 'Male';
        // $rec->patient_address = 'Bwera, Kasese';
        // $rec->patient_phone_number = '0783204665';
        // $rec->nin = '1400019201011';
        // $rec->fingerprint = '1400019201011';
        // $rec->patient_district_id = 88;
        // $rec->health_centre_drug_stock_id = 1;
        // $rec->quantity = 5;
        // $rec->created_by = Auth::user();
        // $rec->save();

        $form = new Form(new PatientDrugRecord());

        $health_centre_drug_stock_id = 0;
        if (isset($_GET['health_centre_drug_stock_id'])) {
            $health_centre_drug_stock_id =  ((int)($_GET['health_centre_drug_stock_id']));
        }


        $stocks = [];
        foreach (HealthCentreDrugStock::all() as $stock) {
            if ($stock->current_quantity < 1) {
                continue;
            }
            $stocks[$stock->id] = "$stock->id. " . $stock->drug_category->name_of_drug . " - Batch #" .
                $stock->batch_number . ", Available Quantity: "
                . Utils::quantity_convertor_2($stock->current_quantity, $stock->drug_stock);
        }


        $form->select('health_centre_drug_stock_id', 'Select drug')
            ->options($stocks)
            ->readOnly()
            ->default($health_centre_drug_stock_id)
            ->rules('required');

        $form->decimal('quantity', 'Drug quantity')
            ->help('Number of tablets for solid drugs OR Number of bottles/bags for liquid drugs or syrups.')
            ->rules('required');

        $form->divider('Patient information');

        $form->hidden('created_by')->default(Auth::user()->id);


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

                $f->text('patient_address', 'Patient address')
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
