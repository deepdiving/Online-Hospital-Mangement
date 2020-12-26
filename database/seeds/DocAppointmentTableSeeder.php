<?php

use Illuminate\Database\Seeder;
use App\Models\doctor\DocAppointment;
class DocAppointmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [

            [              
                'invoice'          => 'A0001',
                'patient_id'       => '1',
                'doctor_id'        => '1',
                'doc_schedule_id'  => '5',
                'referral_id'      => '0',
                'trans_id'         => '1',
                'doctor_fees'      => '1000',
                'discount'         => '100',
                'net_fees'         => '900',
                'serial'           => '1',
                'date'             =>date('Y-m-d'),
                'remark'           => 'dgsdfhfj',               
                'status'           => 'Paid',
                'user_id'          => '4',
                'created_at'       => now(),
                'updated_at'       => now()
            ],
            [              
                'invoice'          => 'A0002',
                'patient_id'       => '2',
                'doctor_id'        => '1',
                'doc_schedule_id'  => '5',
                'referral_id'      => '0',
                'trans_id'         => '1',
                'doctor_fees'      => '1000',
                'discount'         => '100',
                'net_fees'         => '900',
                'serial'           => '1',
                'date'             =>date('Y-m-d'),
                'remark'           => 'dgsdfhfj',               
                'status'           => 'Paid',
                'user_id'          => '4',
                'created_at'       => now(),
                'updated_at'       => now()
            ],
            [              
                'invoice'          => 'A0003',
                'patient_id'       => '3',
                'doctor_id'        => '1',
                'doc_schedule_id'  => '5',
                'referral_id'      => '0',
                'trans_id'         => '1',
                'doctor_fees'      => '1000',
                'discount'         => '100',
                'net_fees'         => '900',
                'serial'           => '1',
                'date'             =>date('Y-m-d'),
                'remark'           => 'dgsdfhfj',               
                'status'           => 'Paid',
                'user_id'          => '4',
                'created_at'       => now(),
                'updated_at'       => now()
            ],

            [              
                'invoice'          => 'A0004',
                'patient_id'       => '4',
                'doctor_id'        => '2',
                'doc_schedule_id'  => '12',
                'referral_id'      => '0',
                'trans_id'         => '1',
                'doctor_fees'      => '1200',
                'discount'         => '100',
                'net_fees'         => '1100',
                'serial'           => '5',
                'date'             =>date('Y-m-d'),
                'remark'           => 'affsdggdh',               
                'status'           => 'Paid',
                'user_id'          => '4',
                'created_at'       => now(),
                'updated_at'       => now()
            ],

            [              
                'invoice'          => 'A0005',
                'patient_id'       => '5',
                'doctor_id'        => '2',
                'doc_schedule_id'  => '12',
                'referral_id'      => '0',
                'trans_id'         => '1',
                'doctor_fees'      => '1200',
                'discount'         => '100',
                'net_fees'         => '1100',
                'serial'           => '5',
                'date'             =>date('Y-m-d'),
                'remark'           => 'affsdggdh',               
                'status'           => 'Paid',
                'user_id'          => '4',
                'created_at'       => now(),
                'updated_at'       => now()
            ],

            [              
                'invoice'          => 'A0006',
                'patient_id'       => '6',
                'doctor_id'        => '2',
                'doc_schedule_id'  => '12',
                'referral_id'      => '0',
                'trans_id'         => '1',
                'doctor_fees'      => '1200',
                'discount'         => '100',
                'net_fees'         => '1100',
                'serial'           => '5',
                'date'             =>date('Y-m-d'),
                'remark'           => 'affsdggdh',               
                'status'           => 'Paid',
                'user_id'          => '4',
                'created_at'       => now(),
                'updated_at'       => now()
            ],

            [              
                'invoice'          => 'A0007',
                'patient_id'       => '7',
                'doctor_id'        => '3',
                'doc_schedule_id'  => '19',
                'referral_id'      => '0',
                'trans_id'         => '7',
                'doctor_fees'      => '800',
                'discount'         => '0',
                'net_fees'         => '800',
                'serial'           => '1',
                'date'             =>date('Y-m-d'),
                'remark'           => 'mfcmncdhzh',               
                'status'           => 'Paid',
                'user_id'          => '4',
                'created_at'       => now(),
                'updated_at'       => now()
            ],

            [              
                'invoice'          => 'A0008',
                'patient_id'       => '8',
                'doctor_id'        => '3',
                'doc_schedule_id'  => '19',
                'referral_id'      => '0',
                'trans_id'         => '7',
                'doctor_fees'      => '800',
                'discount'         => '0',
                'net_fees'         => '800',
                'serial'           => '1',
                'date'             =>date('Y-m-d'),
                'remark'           => 'mfcmncdhzh',               
                'status'           => 'Paid',
                'user_id'          => '4',
                'created_at'       => now(),
                'updated_at'       => now()
            ],
            [              
                'invoice'          => 'A0009',
                'patient_id'       => '1',
                'doctor_id'        => '3',
                'doc_schedule_id'  => '19',
                'referral_id'      => '0',
                'trans_id'         => '7',
                'doctor_fees'      => '800',
                'discount'         => '0',
                'net_fees'         => '800',
                'serial'           => '1',
                'date'             =>date('Y-m-d'),
                'remark'           => 'mfcmncdhzh',               
                'status'           => 'Paid',
                'user_id'          => '4',
                'created_at'       => now(),
                'updated_at'       => now()
            ],
            [              
                'invoice'          => 'A0010',
                'patient_id'       => '5',
                'doctor_id'        => '3',
                'doc_schedule_id'  => '19',
                'referral_id'      => '0',
                'trans_id'         => '7',
                'doctor_fees'      => '800',
                'discount'         => '0',
                'net_fees'         => '800',
                'serial'           => '1',
                'date'             =>date('Y-m-d'),
                'remark'           => 'mfcmncdhzh',               
                'status'           => 'Paid',
                'user_id'          => '4',
                'created_at'       => now(),
                'updated_at'       => now()
            ],
           
        ];
            DB::table('doc_appointments')->insert($data);
    }
}
