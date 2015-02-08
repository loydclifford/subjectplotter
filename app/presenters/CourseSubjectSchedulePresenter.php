<?php

class CourseSubjectSchedulePresenter extends Presenter{

    public function getDayString()
    {
        $str = array();

        if ($this->day_mon) $str[] = 'Mon';
        if ($this->day_tue) $str[] = 'Tue';
        if ($this->day_wed) $str[] = 'Wed';
        if ($this->day_thu) $str[] = 'Thu';
        if ($this->day_sat) $str[] = 'Sat';
        if ($this->day_sun) $str[] = 'Sun';

        return join('-',$str);
    }

    public function getTimeSchedule()
    {
        $formatted_start_time = date('h:i a', strtotime($this->time_start));
        $formatted_end_time = date('h:i a', strtotime($this->time_end));
        return  $formatted_start_time . ' - ' . $formatted_end_time;
    }
}