<?php

class CourseSubjectScheduleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CourseSubjectSchedule::insert( array(
            array('course_subject_id' => '283','room_id' => 'RM-01','instructor_id' => 'INS-704879','day_mon' => '1','day_tue' => '0','day_wed' => '1','day_thu' => '0','day_fri' => '1','day_sat' => '0','day_sun' => '0','time_start' => '1970-01-01 08:00:00','time_end' => '1970-01-01 09:30:00','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('course_subject_id' => '286','room_id' => 'RM-01','instructor_id' => 'INS-704879','day_mon' => '1','day_tue' => '0','day_wed' => '1','day_thu' => '0','day_fri' => '1','day_sat' => '0','day_sun' => '0','time_start' => '1970-01-01 09:30:00','time_end' => '1970-01-01 10:30:00','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('course_subject_id' => '289','room_id' => 'RM-01','instructor_id' => 'INS-269655','day_mon' => '0','day_tue' => '1','day_wed' => '0','day_thu' => '1','day_fri' => '0','day_sat' => '0','day_sun' => '0','time_start' => '1970-01-01 08:00:00','time_end' => '1970-01-01 09:30:00','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('course_subject_id' => '292','room_id' => 'RM-01','instructor_id' => 'INS-933422','day_mon' => '0','day_tue' => '1','day_wed' => '0','day_thu' => '1','day_fri' => '0','day_sat' => '0','day_sun' => '0','time_start' => '1970-01-01 09:30:00','time_end' => '1970-01-01 10:30:00','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('course_subject_id' => '295','room_id' => 'RM-01','instructor_id' => 'INS-910021','day_mon' => '0','day_tue' => '1','day_wed' => '0','day_thu' => '1','day_fri' => '0','day_sat' => '0','day_sun' => '0','time_start' => '1970-01-01 10:30:00','time_end' => '1970-01-01 11:30:00','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('course_subject_id' => '298','room_id' => 'RM-01','instructor_id' => 'INS-933422','day_mon' => '0','day_tue' => '1','day_wed' => '0','day_thu' => '1','day_fri' => '0','day_sat' => '0','day_sun' => '0','time_start' => '1970-01-01 13:00:00','time_end' => '1970-01-01 14:00:00','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('course_subject_id' => '301','room_id' => 'RM-01','instructor_id' => 'INS-704879','day_mon' => '0','day_tue' => '1','day_wed' => '0','day_thu' => '1','day_fri' => '0','day_sat' => '0','day_sun' => '0','time_start' => '1970-01-01 14:30:00','time_end' => '1970-01-01 15:30:00','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('course_subject_id' => '304','room_id' => 'RM-01','instructor_id' => 'INS-269655','day_mon' => '0','day_tue' => '1','day_wed' => '0','day_thu' => '1','day_fri' => '0','day_sat' => '0','day_sun' => '0','time_start' => '1970-01-01 15:30:00','time_end' => '1970-01-01 16:30:00','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('course_subject_id' => '307','room_id' => 'RM-01','instructor_id' => 'INS-933422','day_mon' => '0','day_tue' => '1','day_wed' => '0','day_thu' => '1','day_fri' => '0','day_sat' => '0','day_sun' => '0','time_start' => '1970-01-01 16:30:00','time_end' => '1970-01-01 17:30:00','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
            array('course_subject_id' => '310','room_id' => 'RM-01','instructor_id' => 'INS-933422','day_mon' => '0','day_tue' => '0','day_wed' => '0','day_thu' => '0','day_fri' => '0','day_sat' => '1','day_sun' => '0','time_start' => '1970-01-01 08:00:00','time_end' => '1970-01-01 10:00:00','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00')
        ));
    }
}