<?php

namespace App\Admin\Controllers;

use App\Models\Patient;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PatientController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Patient';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Patient());

        $grid->column('id', __('Id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('district_id', __('District id'));
        $grid->column('name', __('Name'));
        $grid->column('sex', __('Sex'));
        $grid->column('address', __('Address'));
        $grid->column('nin', __('Nin'));
        $grid->column('phone_number', __('Phone number'));
        $grid->column('fingerprint', __('Fingerprint'));

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
        $show = new Show(Patient::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('district_id', __('District id'));
        $show->field('name', __('Name'));
        $show->field('sex', __('Sex'));
        $show->field('address', __('Address'));
        $show->field('nin', __('Nin'));
        $show->field('phone_number', __('Phone number'));
        $show->field('fingerprint', __('Fingerprint'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Patient());

        $form->number('district_id', __('District id'));
        $form->textarea('name', __('Name'));
        $form->textarea('sex', __('Sex'));
        $form->textarea('address', __('Address'));
        $form->textarea('nin', __('Nin'));
        $form->textarea('phone_number', __('Phone number'));
        $form->textarea('fingerprint', __('Fingerprint'));

        return $form;
    }
}
