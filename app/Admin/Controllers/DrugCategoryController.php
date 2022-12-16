<?php

namespace App\Admin\Controllers;

use App\Models\DrugCategory;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DrugCategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Drug categories';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new DrugCategory());
        $grid->quickSearch('name_of_drug')->placeholder('Search...');
        $grid->disableBatchActions();
        $grid->column('id', __('ID'))->sortable();
        $grid->column('name_of_drug', __('Name of drug'));
        $grid->column('generic_name_of_drug', __('Generic name of drug'));
        $grid->column('nda_registration_number', __('NDA registration number'));
        $grid->column('license_holder', __('License holder'));
        $grid->column('strength_of_drug', __('Strength of drug'));
        $grid->column('manufacturer', __('Manufacturer'));
        $grid->column('country_of_manufacturer', __('Country of manufacturer'));
        $grid->column('dosage_form', __('Dosage form'));
        $grid->column('registration_date', __('Registration date'));

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
        $show = new Show(DrugCategory::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('nda_registration_number', __('Nda registration number'));
        $show->field('license_holder', __('License holder'));
        $show->field('name_of_drug', __('Name of drug'));
        $show->field('generic_name_of_drug', __('Generic name of drug'));
        $show->field('strength_of_drug', __('Strength of drug'));
        $show->field('manufacturer', __('Manufacturer'));
        $show->field('country_of_manufacturer', __('Country of manufacturer'));
        $show->field('dosage_form', __('Dosage form'));
        $show->field('registration_date', __('Registration date'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new DrugCategory());

        $form->text('nda_registration_number', __('Nda registration number'))->rules('required');
        $form->text('license_holder', __('License holder'))->rules('required');
        $form->text('name_of_drug', __('Name of drug'))->rules('required');
        $form->text('generic_name_of_drug', __('Generic name of drug'))->rules('required');
        $form->text('strength_of_drug', __('Strength of drug'))->rules('required');
        $form->text('manufacturer', __('Manufacturer'))->rules('required');
        $form->text('country_of_manufacturer', __('Country of manufacturer'))->rules('required');
        $form->text('dosage_form', __('Dosage form'))->rules('required');
        $form->date('registration_date', __('Registration date'))->rules('required');

        return $form;
    }
}
