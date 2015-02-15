<?php

class Admin_CourseYearController extends Admin_BaseController {

    public function postCreate()
    {
        // Check for taxonomy slugs
        $course_code = Input::get('course_code');
        $course_year_code = Input::get('course_year_code');

        // Delete previews data
        $exists = CourseYear::where('course_code', $course_code)->where('course_year_code', $course_year_code)->first();

        if (!$exists)
        {
            // create new data
            $model = new CourseYear();
            $model->course_code = $course_code;
            $model->course_year_code = $course_year_code;
            $model->course_year_order = $this->getNewOrder($course_code);
            $model->save();

            Session::flash(SUCCESS_MESSAGE, 'Successfully created course level.');

            return Response::json(array(
                'status' => RESULT_SUCCESS,
            ));
        }

        return Response::json(array(
            'status' => RESULT_FAILURE,
            'message' => 'Already created course level.',
        ));
    }

    public function postUpdate()
    {
        // Check for taxonomy slugs
        $course_code = Input::get('course_code');
        $course_year_code_old = Input::get('course_year_code_old');

        $course_year_code = Input::get('course_year_code');

        // Delete previews data
        CourseYear::where('course_code', $course_code)->where('course_year_code', $course_year_code_old)->update(array(
            'course_year_code' => $course_year_code
        ));

        return Response::json(array(
            'status' => RESULT_SUCCESS,
            'message' => 'Successfully updated course year.',
        ));
    }

    public function postReorder()
    {
        $raw_reorder = Input::get('reorder');
        $reorder = json_decode($raw_reorder, true);

        Utils::updateNestable('CourseYear', $reorder, 0, 'course_year_order', false);

        return Response::json(array(
            'status' => RESULT_SUCCESS
        ));
    }

    public function getDelete()
    {
        CourseYear::find(Input::get('course_year_id'))->delete();

        return Redirect::back();
    }

    /**
     * Count all levels to selected course code
     *
     * @param $course_code
     * @return int
     */
    private function getNewOrder($course_code)
    {
        return CourseYear::where('course_code', $course_code)->count();
    }


}