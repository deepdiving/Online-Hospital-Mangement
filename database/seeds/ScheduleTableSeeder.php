<?php

use Illuminate\Database\Seeder;
use\App\Models\doctor\DocSchedule;
class ScheduleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

          { $data = [

              [
                  'name'         => 'Morning Shift',
                  'doctor_fees'  => '1000',
                  'week_day'     => 'Sunday',
                  'start_time'   => '08:00:00',
                  'end_time'     => '14:00:00',
                  'visit_qty'    => '15',
                  'doctor_id'    => '1',
                  'status'       => 'Active',
                  'user_id'      => '2',
                  'created_at'   => now(),
                  'updated_at'   => now()
              ],

              [
                
                'name'         => 'Evening Shift',
                'doctor_fees'  => '1000',
                'week_day'     => 'Monday',
                'start_time'   => '20:00:00',
                'end_time'     => '23:00:00',
                'visit_qty'    => '15',
                'doctor_id'    => '1',
                'status'       => 'Active',
                'user_id'      => '4',
                'created_at'   => now(),
                'updated_at'   => now()
            ],

            [
                'name'         => 'Evening Shift',
                'doctor_fees'  => '1000',
                'week_day'     => 'Tuesday',
                'start_time'   => '20:00:00',
                'end_time'     => '23:00:00',
                'visit_qty'    => '15',
                'doctor_id'    => '1',
                'status'       => 'Active',
                'user_id'      => '2',
                'created_at'   => now(),
                'updated_at'   => now()
            ],

            [
                'name'         => 'Morning Shift',
                'doctor_fees'  => '1000',
                'week_day'     => 'Wednesday',
                'start_time'   => '08:00:00',
                'end_time'     => '14:00:00',
                'visit_qty'    => '15',
                'doctor_id'    => '1',
                'status'       => 'Active',
                'user_id'      => '2',
                'created_at'   => now(),
                'updated_at'   => now()
            ],

            [
                'name'         => 'Morning Shift',
                'doctor_fees'  => '1000',
                'week_day'     => 'Thursday',
                'start_time'   => '08:00:00',
                'end_time'     => '14:00:00',
                'visit_qty'    => '15',
                'doctor_id'    => '1',
                'status'       => 'Active',
                'user_id'      => '2',
                'created_at'   => now(),
                'updated_at'   => now()
            ],

            [
                'name'         => 'Evening Shift',
                'doctor_fees'  => '1000',
                'week_day'     => 'Friday',
                'start_time'   => '20:00:00',
                'end_time'     => '23:00:00',
                'visit_qty'    => '15',
                'doctor_id'    => '1',
                'status'       => 'Active',
                'user_id'      => '2',
                'created_at'   => now(),
                'updated_at'   => now()
            ],

            [
                'name'         => 'Evening Shift',
                'doctor_fees'  => '1000',
                'week_day'     => 'Saturday',
                'start_time'   => '20:00:00',
                'end_time'     => '23:00:00',
                'visit_qty'    => '15',
                'doctor_id'    => '1',
                'status'       => 'Active',
                'user_id'      => '2',
                'created_at'   => now(),
                'updated_at'   => now()
            ],


            [
                'name'         => 'Morning Shift',
                'doctor_fees'  => '1200',
                'week_day'     => 'Sunday',
                'start_time'   => '08:00:00',
                'end_time'     => '14:00:00',
                'visit_qty'    => '15',
                'doctor_id'    => '2',
                'status'       => 'Active',
                'user_id'      => '2',
                'created_at'   => now(),
                'updated_at'   => now()
            ],

            [
              
              'name'         => 'Evening Shift',
              'doctor_fees'  => '1200',
              'week_day'     => 'Monday',
              'start_time'   => '20:00:00',
              'end_time'     => '23:00:00',
              'visit_qty'    => '15',
              'doctor_id'    => '2',
              'status'       => 'Active',
              'user_id'      => '4',
              'created_at'   => now(),
              'updated_at'   => now()
          ],

          [
              'name'         => 'Evening Shift',
              'doctor_fees'  => '1200',
              'week_day'     => 'Tuesday',
              'start_time'   => '20:00:00',
              'end_time'     => '23:00:00',
              'visit_qty'    => '15',
              'doctor_id'    => '2',
              'status'       => 'Active',
              'user_id'      => '2',
              'created_at'   => now(),
              'updated_at'   => now()
          ],

          [
              'name'         => 'Morning Shift',
              'doctor_fees'  => '1200',
              'week_day'     => 'Wednesday',
              'start_time'   => '08:00:00',
              'end_time'     => '14:00:00',
              'visit_qty'    => '15',
              'doctor_id'    => '2',
              'status'       => 'Active',
              'user_id'      => '2',
              'created_at'   => now(),
              'updated_at'   => now()
          ],

          [
              'name'         => 'Morning Shift',
              'doctor_fees'  => '1200',
              'week_day'     => 'Thursday',
              'start_time'   => '08:00:00',
              'end_time'     => '14:00:00',
              'visit_qty'    => '15',
              'doctor_id'    => '2',
              'status'       => 'Active',
              'user_id'      => '2',
              'created_at'   => now(),
              'updated_at'   => now()
          ],

          [
              'name'         => 'Evening Shift',
              'doctor_fees'  => '1200',
              'week_day'     => 'Friday',
              'start_time'   => '20:00:00',
              'end_time'     => '23:00:00',
              'visit_qty'    => '15',
              'doctor_id'    => '2',
              'status'       => 'Active',
              'user_id'      => '2',
              'created_at'   => now(),
              'updated_at'   => now()
          ],

          [
              'name'         => 'Evening Shift',
              'doctor_fees'  => '1200',
              'week_day'     => 'Saturday',
              'start_time'   => '20:00:00',
              'end_time'     => '23:00:00',
              'visit_qty'    => '15',
              'doctor_id'    => '2',
              'status'       => 'Active',
              'user_id'      => '2',
              'created_at'   => now(),
              'updated_at'   => now()
          ],


          
          [
            'name'         => 'Morning Shift',
            'doctor_fees'  => '800',
            'week_day'     => 'Sunday',
            'start_time'   => '08:00:00',
            'end_time'     => '14:00:00',
            'visit_qty'    => '15',
            'doctor_id'    => '3',
            'status'       => 'Active',
            'user_id'      => '2',
            'created_at'   => now(),
            'updated_at'   => now()
        ],

        [
          
          'name'         => 'Evening Shift',
          'doctor_fees'  => '800',
          'week_day'     => 'Monday',
          'start_time'   => '20:00:00',
          'end_time'     => '23:00:00',
          'visit_qty'    => '15',
          'doctor_id'    => '3',
          'status'       => 'Active',
          'user_id'      => '4',
          'created_at'   => now(),
          'updated_at'   => now()
      ],

      [
          'name'         => 'Evening Shift',
          'doctor_fees'  => '800',
          'week_day'     => 'Tuesday',
          'start_time'   => '20:00:00',
          'end_time'     => '23:00:00',
          'visit_qty'    => '15',
          'doctor_id'    => '3',
          'status'       => 'Active',
          'user_id'      => '3',
          'created_at'   => now(),
          'updated_at'   => now()
      ],

      [
          'name'         => 'Morning Shift',
          'doctor_fees'  => '800',
          'week_day'     => 'Wednesday',
          'start_time'   => '08:00:00',
          'end_time'     => '14:00:00',
          'visit_qty'    => '15',
          'doctor_id'    => '3',
          'status'       => 'Active',
          'user_id'      => '2',
          'created_at'   => now(),
          'updated_at'   => now()
      ],

      [
          'name'         => 'Morning Shift',
          'doctor_fees'  => '800',
          'week_day'     => 'Thursday',
          'start_time'   => '08:00:00',
          'end_time'     => '14:00:00',
          'visit_qty'    => '15',
          'doctor_id'    => '3',
          'status'       => 'Active',
          'user_id'      => '2',
          'created_at'   => now(),
          'updated_at'   => now()
      ],

      [
          'name'         => 'Evening Shift',
          'doctor_fees'  => '800',
          'week_day'     => 'Friday',
          'start_time'   => '20:00:00',
          'end_time'     => '23:00:00',
          'visit_qty'    => '15',
          'doctor_id'    => '3',
          'status'       => 'Active',
          'user_id'      => '2',
          'created_at'   => now(),
          'updated_at'   => now()
      ],

      [
          'name'         => 'Evening Shift',
          'doctor_fees'  => '800',
          'week_day'     => 'Saturday',
          'start_time'   => '20:00:00',
          'end_time'     => '23:00:00',
          'visit_qty'    => '15',
          'doctor_id'    => '3',
          'status'       => 'Active',
          'user_id'      => '2',
          'created_at'   => now(),
          'updated_at'   => now()
      ],

          ];

      DB::table('doc_schedules')->insert($data);
    }
  }
}
