<?php

namespace App\Admin\Controllers;

use App\Models\HealthCentre;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class HealthCentreController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Health centre';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

      

        $grid = new Grid(new HealthCentre());

        $grid->column('id', __('Id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('district_id', __('District id'));
        $grid->column('name', __('Name'));
        $grid->column('details', __('Details'));

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
        $show = new Show(HealthCentre::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('district_id', __('District id'));
        $show->field('name', __('Name'));
        $show->field('details', __('Details'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new HealthCentre());


        $district_ajax_url = url(
            '/api/ajax?'
                . "&search_by_1=name"
                . "&search_by_2=id"
                . "&query_parent=0"
                . "&model=Location"
        );
        $form->select('district_id', 'Select District')
            ->ajax($district_ajax_url)
            ->rules('required');


        $form->text('name', __('Health cente name'))->rules('required');
        $form->textarea('details', __('Details'));

        return $form;
    }
}
