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
    protected $title = 'DrugCategory';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new DrugCategory());

        $grid->column('id', __('Id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('nda_registration_number', __('Nda registration number'));
        $grid->column('license_holder', __('License holder'));
        $grid->column('name_of_drug', __('Name of drug'));
        $grid->column('generic_name_of_drug', __('Generic name of drug'));
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

        $form->textarea('nda_registration_number', __('Nda registration number'));
        $form->textarea('license_holder', __('License holder'));
        $form->textarea('name_of_drug', __('Name of drug'));
        $form->textarea('generic_name_of_drug', __('Generic name of drug'));
        $form->textarea('strength_of_drug', __('Strength of drug'));
        $form->textarea('manufacturer', __('Manufacturer'));
        $form->textarea('country_of_manufacturer', __('Country of manufacturer'));
        $form->textarea('dosage_form', __('Dosage form'));
        $form->textarea('registration_date', __('Registration date'));

        return $form;
    }
}
